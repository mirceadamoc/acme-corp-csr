<?php
namespace Database\Seeders;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Enums\DonationStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DemoSeeder extends Seeder {
  public function run(): void {
    $admin = User::query()->firstOrCreate(
      ['email'=>'admin@example.com'],
      ['name'=>'Admin User','password'=>Hash::make('password'),'email_verified_at'=>now(),'is_admin'=>true]
    );
    $user = User::query()->firstOrCreate(
      ['email'=>'user@example.com'],
      ['name'=>'Demo User','password'=>Hash::make('password'),'email_verified_at'=>now()]
    );
    $campaign = Campaign::query()->firstOrCreate(
      ['title'=>'Plant 10,000 Trees'],
      ['user_id'=>$admin->id,'description'=>'Help us plant trees in urban areas.','goal_amount'=>10000,'status'=>'active','starts_at'=>now()->subDay(),'ends_at'=>now()->addMonth()]
    );
    Donation::query()->firstOrCreate(
      ['campaign_id'=>$campaign->id,'user_id'=>$user->id,'amount'=>25],
      ['status'=>DonationStatus::Confirmed]
    );
  }
}
