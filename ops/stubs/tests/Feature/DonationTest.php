<?php
use App\Models\Campaign;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationReceipt;
uses(RefreshDatabase::class);
it('allows a user to donate via manual gateway and sends a receipt', function(){
  Mail::fake(); config()->set('payment.driver','manual');
  $user = User::factory()->create();
  $campaign = Campaign::factory()->create(['user_id'=>$user->id,'status'=>'active']);
  $this->actingAs($user)->post('/donations', ['campaign_id'=>$campaign->id,'amount'=>15])->assertSessionHasNoErrors();
  expect(Donation::query()->count())->toBe(1);
  Mail::assertSent(DonationReceipt::class);
});
