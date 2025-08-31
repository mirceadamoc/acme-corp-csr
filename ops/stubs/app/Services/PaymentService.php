<?php
namespace App\Services;
use App\Models\Donation;
use App\Services\DTO\PaymentResult;
use App\Services\Payments\ManualGateway;
use App\Services\Payments\StripeGateway;
use App\Services\Payments\PaymentGateway;
class PaymentService {
  protected PaymentGateway $gateway;
  public function __construct() {
    $driver = config('payment.driver','manual');
    $this->gateway = match ($driver) {
      'manual' => new ManualGateway(),
      'stripe' => new StripeGateway(),
      default => new ManualGateway(),
    };
  }
  public function process(Donation $donation): PaymentResult { return $this->gateway->process($donation); }
}
