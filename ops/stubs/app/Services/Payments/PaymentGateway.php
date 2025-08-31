<?php
namespace App\Services\Payments;
use App\Models\Donation;
use App\Services\DTO\PaymentResult;
interface PaymentGateway { public function process(Donation $donation): PaymentResult; }
