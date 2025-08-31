<?php
namespace App\Services\DTO;
class PaymentResult { public function __construct(public bool $success, public ?string $message=null, public ?string $reference=null){} }
