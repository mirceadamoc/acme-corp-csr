<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
  public function up(): void {
    Schema::create('donations', function(Blueprint $table){
      $table->id();
      $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->decimal('amount',10,2);
      $table->string('payment_reference')->nullable();
      $table->enum('status',['pending','confirmed','failed'])->default('pending');
      $table->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('donations'); }
};
