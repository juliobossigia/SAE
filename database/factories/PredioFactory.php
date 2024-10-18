<?php

namespace Database\Factories;

use App\Models\Predio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Predio>
 */
class PredioFactory extends Factory
{
    protected $model = Predio::class;
   
    public function definition(): array
    {
        
        
        return [
            'nome'=>$this->faker->name(),
        ];
    }
}
