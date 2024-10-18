<?php

namespace Tests\Feature;

use App\Models\Docente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DocenteTest extends TestCase
{
    use RefreshDatabase;

   #[Test]
    public function it_can_list_a_docentes()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        Docente::factory()->count(3)->create();
        $response = $this->get(route('docentes.index'));

        $response->assertStatus(200);
        $response->assertViewHas('docentes');

        
    }

    #[Test]
    public function it_can_create_a_docentes(){

        $user = User::factory()->create();
        $this->actingAs($user);

        $docenteData = Docente::factory()->create();
        
        $this->assertDatabaseHas('docentes',['email'=>$docenteData['email']]);

        $response = $this->post(route('docentes.store'),$docenteData->toArray());


        $response->assertStatus(302);
        echo $response->getContent();

        //Log::info('Docente Data:', $docenteData);
        //Log::info('Response:', ['status' => $response->status(), 'content' => $response->getContent()]);

       

       /* $docente = Docente::where('email', $docenteData['email'])->first();

        if ($docente) {
            Log::info('Docente encontrado:', $docente->toArray());
        } else {
            Log::info('Docente não encontrado no banco de dados.');
        }
            */
    }

    #[Test]
    public function show_docentes(){

        $user = User::factory()->create();
        $this->actingAs($user);

        $docente = Docente::factory()->create();
        $response = $this->get(route('docentes.show',$docente->id));
        $response->assertStatus(200);
        $response->assertSee($docente->nome);
    }

    #[Test]
    public function it_can_delete_a_docente()
    {
    // Autenticar um usuário
    $user = User::factory()->create();
    $this->actingAs($user);

    
    $docente = docente::factory()->create();

    // Enviar requisição para deletar
    $response = $this->delete("/docentes/{$docente->id}");

    
    $response->assertStatus(302);

    
    $this->assertDatabaseMissing('docentes', ['id' => $docente->id]);
    }

}
