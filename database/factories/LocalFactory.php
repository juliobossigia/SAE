<?php

namespace Database\Factories;

use App\Models\Local;
use App\Models\Predio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Local>
 */

 

class LocalFactory extends Factory
{
    protected $model = Local::class;
    
    public function definition(): array
    {
        return [
            'predio_id'=> Predio::factory(),
            'tipo_local'=>$this->faker->randomElement(['sala','laboratório']),
            'numero'=>$this->faker->numberBetween(1,100),
        ];
    }
}
