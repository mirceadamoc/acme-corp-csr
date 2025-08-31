# ACME Corp CSR – Employee Donation Platform

This repository contains a starter implementation of ACME Corp’s **Corporate Social Responsibility (CSR) donation platform**, built with **Laravel 11** and **Vue 3 (Inertia + Breeze)**. Employees can create and manage fundraising campaigns, donate to initiatives, and administrators get oversight via a dashboard.

## ✨ Features
- Employee Campaigns: create/manage, search, view.
- Donations: pluggable gateway (`ManualGateway` confirmed + receipt; `StripeGateway` stub).
- Administration: `/admin` dashboard with KPIs.
- Auth via Breeze (Vue + Inertia).

## 🛠 Technology
Laravel 11 (PHP 8.3), Vue 3 + Inertia, MariaDB (Sail), Redis, Mailpit, Pest, PHPStan level 8 + Larastan, Docker (Sail).

## 🚀 Install
```bash
chmod +x install.sh
./install.sh
```
The script: creates fresh Laravel app in `src/`, installs Sail (mariadb, redis, mailpit), adds Breeze/Pest/PHPStan+Larastan, pins Vite ^6, copies CSR stubs, brings containers up, builds assets, migrates & seeds.

## 🔑 Access
- App: http://localhost
- Mailpit: http://localhost:8025
- Admin: admin@example.com / password
- Employee: user@example.com / password

## ⚙️ Dev
```bash
cd src
./vendor/bin/sail up -d
./vendor/bin/sail test
./vendor/bin/sail php -d memory_limit=1G vendor/bin/phpstan analyse
./vendor/bin/sail npm run dev
./vendor/bin/sail npm run build
```

## 📐 Architecture (text)
- Employees → CSR Platform (Laravel backend + Vue/Inertia frontend).
- Platform → MariaDB (data), Redis (cache/queues), Mailpit (emails).
- Donations → Payment Gateway abstraction (manual/Stripe stub).
- Admin Dashboard → metrics & oversight.
