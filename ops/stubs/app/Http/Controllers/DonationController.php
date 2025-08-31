<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreDonationRequest;
use App\Models\Campaign;
use App\Models\Donation;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;

class DonationController extends Controller {
  public function store(StoreDonationRequest $request, PaymentService $payments): RedirectResponse {
    $campaign = Campaign::query()->findOrFail($request->input('campaign_id'));
    $donation = Donation::query()->create([
      'campaign_id'=>$campaign->id,
      'user_id'=>$request->user()->id,
      'amount'=>$request->input('amount'),
      'status'=>\App\Models\Enums\DonationStatus::Pending,
    ]);
    $result = $payments->process($donation);
    return $result->success
      ? back()->with('success','Thank you! Your donation was recorded.')
      : back()->with('error','Payment failed: '.$result->message);
  }
}
