<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use Inertia\Inertia;

class DashboardController extends Controller {
  public function index() {
    $user = auth()->user(); abort_unless($user && $user->is_admin, 403, 'Admins only.');
    $stats = [
      'campaigns'=>Campaign::query()->count(),
      'donations'=>Donation::query()->count(),
      'donated_sum'=>(float)Donation::query()->where('status','confirmed')->sum('amount'),
      'active_campaigns'=>Campaign::query()->where('status','active')->count(),
    ];
    return Inertia::render('Admin/Dashboard', ['stats'=>$stats]);
  }
}
