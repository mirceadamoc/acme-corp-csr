<?php
namespace App\Services\Payments;
use App\Mail\DonationReceipt;
use App\Models\Donation;
use App\Models\Enums\DonationStatus;
use App\Services\DTO\PaymentResult;
use Illuminate\Support\Facades\Mail;
class ManualGateway implements PaymentGateway {
  public function process(Donation $donation): PaymentResult {
    $donation->status = DonationStatus::Confirmed;
    $donation->payment_reference = 'MAN-'.now()->format('YmdHis').'-'.$donation->id;
    $donation->save();
    if ($donation->user) Mail::to($donation->user->email)->send(new DonationReceipt($donation));
    return new PaymentResult(true,'Manual confirmation',$donation->payment_reference);
  }
}
