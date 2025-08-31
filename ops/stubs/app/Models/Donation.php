<?php
namespace App\Models;
use App\Models\Enums\DonationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model {
  use HasFactory;
  protected $fillable = ['campaign_id','user_id','amount','status','payment_reference'];
  protected $casts = ['amount'=>'decimal:2','status'=>DonationStatus::class];
  public function campaign(): BelongsTo { return $this->belongsTo(Campaign::class); }
  public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
