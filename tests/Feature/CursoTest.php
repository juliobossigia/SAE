<?php

namespace Tests\Feature;

use App\Models\Curso;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CursoTest extends TestCase
{
    use RefreshDatabase;

   #[Test]
    public function it_can_create_a_curso()
    {
        // Autenticar um usuário (se necessário)
        $user = User::factory()->create();
        $this->actingAs($user);

        // Dado: Um curso a ser criado
        $data = [
            'nome' => 'curso de Matemática',
        ];

        // Quando: Enviar requisição para criar o curso
        $response = $this->post('/cursos', $data);

        // Então: Verificar se o curso foi criado
        $response->assertStatus(302); // Verifica se houve redirecionamento após a criação

        // Imprimir o conteúdo da resposta para debug
        echo $response->getContent();

        // Verificar se o curso foi criado no banco de dados
        $this->assertDatabaseHas('cursos', $data);

        // Verificar se o curso foi realmente criado
        $createdcurso = Curso::where('nome', $data['nome'])->first();
        $this->assertNotNull($createdcurso);
    }

    #[Test]
    public function it_can_update_a_curso()
    {
        // Criar um curso
        $curso = curso::factory()->create();

        // Dados para atualizar
        $newData = ['nome' => 'curso de Física'];

        // Autenticar um usuário (se necessário)
        $user = User::factory()->create();
        $this->actingAs($user);

        // Enviar requisição para atualizar
        $response = $this->put("/cursos/{$curso->id}", $newData);

        // Verificar se foi redirecionado
        $response->assertStatus(302);

        // Imprimir o conteúdo da resposta para debug
        echo $response->getContent();

        // Verificar se o curso foi atualizado no banco de dados
        $this->assertDatabaseHas('cursos', $newData);

        // Verificar se o curso foi realmente atualizado
        $updatedcurso = curso::find($curso->id);
        $this->assertEquals($newData['nome'], $updatedcurso->nome);
    }

    #[Test]
    public function it_can_delete_a_curso()
    {
    // Autenticar um usuário
    $user = User::factory()->create();
    $this->actingAs($user);

    // Criar um curso
    $curso = curso::factory()->create();

    // Enviar requisição para deletar
    $response = $this->delete("/cursos/{$curso->id}");

    // Verificar se houve redirecionamento
    $response->assertStatus(302);

    // Verificar se o curso foi deletado da base de dados
    $this->assertDatabaseMissing('cursos', ['id' => $curso->id]);
    }


}


