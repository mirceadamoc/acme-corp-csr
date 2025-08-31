<?php
namespace Database\Factories;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;
/** @extends Factory<\App\Models\Campaign> */
class CampaignFactory extends Factory {
  protected $model = Campaign::class;
  public function definition(): array {
    return ['user_id'=>1,'title'=>$this->faker->sentence(4),'description'=>$this->faker->paragraph(),'goal_amount'=>$this->faker->numberBetween(1000,10000),'status'=>'active'];
  }
}
