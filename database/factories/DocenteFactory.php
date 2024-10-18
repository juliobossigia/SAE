<?php

namespace Database\Factories;

use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Docente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Docente>
 */
class DocenteFactory extends Factory
{
     
    protected $model=Docente::class;
    public function definition()
    {
        $faker = FakerFactory::create('pt-BR');
        return [
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'cpf' => $this->faker->unique()->cpf(false),
            'data_nascimento' => $this->faker->date(),
            'departamento_id' => Departamento::factory(),
            'curso_id' => Curso::factory(),
            'is_coordenador' => $faker->boolean,

         ];
    }
}
