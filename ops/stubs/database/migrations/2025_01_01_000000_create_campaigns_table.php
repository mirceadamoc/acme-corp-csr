<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
  public function up(): void {
    Schema::create('campaigns', function(Blueprint $table){
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('title');
      $table->string('slug')->unique();
      $table->text('description');
      $table->decimal('goal_amount',10,2);
      $table->decimal('current_amount',10,2)->default(0);
      $table->timestamp('starts_at')->nullable();
      $table->timestamp('ends_at')->nullable();
      $table->enum('status',['draft','active','closed'])->default('draft');
      $table->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('campaigns'); }
};
