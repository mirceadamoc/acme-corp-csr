<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', fn() => Inertia::render('Welcome', [
  'canLogin' => Route::has('login'),
  'canRegister' => Route::has('register'),
  'laravelVersion' => app()->version(),
  'phpVersion' => PHP_VERSION,
]));

Route::middleware(['auth','verified'])->group(function() {
  Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
  Route::resource('campaigns', CampaignController::class)->only(['index','create','store','show']);
  Route::post('/donations', [DonationController::class,'store'])->name('donations.store');
  Route::get('/admin', [DashboardController::class,'index'])->name('admin.dashboard');
});
require __DIR__.'/auth.php';
