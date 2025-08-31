<?php
namespace App\Services\Payments;
use App\Models\Donation;
use App\Services\DTO\PaymentResult;
class StripeGateway implements PaymentGateway {
  public function process(Donation $donation): PaymentResult { return new PaymentResult(false,'Stripe not configured yet'); }
}
