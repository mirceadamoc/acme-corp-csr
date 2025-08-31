#!/usr/bin/env bash
set -euo pipefail

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SRC_DIR="${PROJECT_ROOT}/src"

pecho () { printf "\n\033[1;36m%s\033[0m\n" "$1"; }

command -v docker >/dev/null 2>&1 || { echo "Docker is required."; exit 1; }

pecho "1) Creating Laravel project (latest) in src/ ..."
mkdir -p "${SRC_DIR}"
docker run --rm -u "$(id -u):$(id -g)" -v "${SRC_DIR}:/app" -w /app laravelsail/php83-composer:latest bash -lc '\
  if [ ! -f composer.json ]; then composer create-project laravel/laravel . --prefer-dist --no-interaction; else echo "composer.json exists; skip"; fi \
'

pecho "2) Install Sail (mariadb,redis,mailpit) ..."
docker run --rm -u "$(id -u):$(id -g)" -v "${SRC_DIR}:/var/www/html" -w /var/www/html laravelsail/php83-composer:latest bash -lc '\
  composer require laravel/sail --dev --no-interaction; \
  php artisan sail:install --with=mariadb,redis,mailpit --no-interaction; \
'

pecho "3) Breeze (Vue + Inertia), Pest, PHPStan + Larastan ..."
docker run --rm -u "$(id -u):$(id -g)" \
  -v "${SRC_DIR}:/var/www/html" -w /var/www/html \
  laravelsail/php83-composer:latest bash -lc '\
    # Breeze first
    composer require laravel/breeze --dev --no-interaction; \
    php artisan breeze:install vue --no-interaction || true; \

    # Ensure phpstan extension installer is allowed
    composer config allow-plugins.phpstan/extension-installer true; \

    # --- Ensure framework is new enough for pest-plugin-laravel 3.2 & Larastan ---
    composer require laravel/framework:"^11.45" -W --no-interaction; \

    # --- Test stack: pin versions Pest 3.x works with ---
    composer require --dev phpunit/phpunit:11.5.33 nunomaduro/collision:^8.6 -W --no-interaction; \
    composer require --dev pestphp/pest:^3.8 pestphp/pest-plugin-laravel:^3.2 -W --no-interaction; \
    php artisan vendor:publish --provider="Pest\\Laravel\\PestServiceProvider" --force || true; \

    # --- Static analysis ---
    composer require --dev phpstan/phpstan:^1.11 phpstan/extension-installer:^1.3 nunomaduro/larastan:^2.11 -W --no-interaction; \
  '

pecho "4) Align Vite versions (pin vite@^6 to match @vitejs/plugin-vue@^5) ..."
docker run --rm -u "$(id -u):$(id -g)" -v "${SRC_DIR}:/work" -w /work alpine:3.20 sh -lc '\
  if [ -f package.json ]; then sed -i -E "s/\"vite\"\\s*:\\s*\"\\^[0-9.]+\"/\"vite\": \"^6.0.0\"/g" package.json; fi \
'

pecho "5) Copying CSR stubs ..."
rsync -a "${PROJECT_ROOT}/ops/stubs/" "${SRC_DIR}/"

# Append Breeze profile routes to web.php if missing
docker run --rm -u "$(id -u):$(id -g)" \
  -v "${SRC_DIR}:/work" -w /work alpine:3.20 sh -lc '\
    php -r "exit(strpos(file_get_contents(\"routes/web.php\"), \"ProfileController\")===false?0:1);" || exit 0; \
    cat >> routes/web.php <<'PHP'
use App\Http\Controllers\ProfileController;
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
PHP
  '

# Remove manual Larastan include to avoid double-include notice
docker run --rm -u "$(id -u):$(id -g)" \
  -v "${SRC_DIR}:/work" -w /work alpine:3.20 sh -lc '\
    [ -f phpstan.neon.dist ] && sed -i "/vendor\\/nunomaduro\\/larastan\\/extension\\.neon/d" phpstan.neon.dist || true; \
    [ -f phpstan.neon.dist ] && sed -i "/^includes:/d" phpstan.neon.dist || true; \
  '


pecho "6) Sail up ..."
cd "${SRC_DIR}"
./vendor/bin/sail up -d

pecho "7) Frontend deps & build ..."
./vendor/bin/sail npm install --legacy-peer-deps
./vendor/bin/sail npm run build

pecho "8) Migrate & seed ..."
./vendor/bin/sail artisan storage:link || true
./vendor/bin/sail artisan migrate --seed

pecho "9) Run tests & PHPStan (non-blocking) ..."
./vendor/bin/sail test || true
./vendor/bin/sail php -d memory_limit=1G vendor/bin/phpstan analyse || true

APP_URL=$(grep -E "^APP_URL=" .env | cut -d= -f2- || echo "http://localhost")
pecho "✅ Done! Open ${APP_URL}"
echo "Mailpit: http://localhost:8025"
echo "Admin:   admin@example.com / password"
