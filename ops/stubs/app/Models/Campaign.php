<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Campaign extends Model {
  use HasFactory;
  protected $fillable = ['user_id','title','slug','description','goal_amount','current_amount','starts_at','ends_at','status'];
  protected $casts = ['starts_at'=>'datetime','ends_at'=>'datetime','goal_amount'=>'decimal:2','current_amount'=>'decimal:2'];
  protected static function booted(): void {
    static::creating(function(self $m){ if(empty($m->slug)) $m->slug = Str::slug($m->title).'-'.Str::random(6); });
  }
  public function user(): BelongsTo { return $this->belongsTo(User::class); }
  public function donations(): HasMany { return $this->hasMany(Donation::class); }
}
