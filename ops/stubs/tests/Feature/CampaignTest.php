<?php
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);
it('requires auth to view campaign creation', function(){ $this->get('/campaigns/create')->assertRedirect('/login'); });
it('allows an authenticated user to create a campaign', function(){
  $user = User::factory()->create();
  $this->actingAs($user)->post('/campaigns', ['title'=>'Clean Rivers','description'=>'Let us clean rivers.','goal_amount'=>5000,'status'=>'active'])->assertRedirect();
  expect(Campaign::query()->count())->toBe(1);
});
