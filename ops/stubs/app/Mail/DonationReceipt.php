<?php
namespace App\Mail;
use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class DonationReceipt extends Mailable {
  use Queueable, SerializesModels;
  public function __construct(public Donation $donation){}
  public function build(){ return $this->subject('Donation receipt')->view('emails.donation_receipt'); }
}
