<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class DepartamentoTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_departamento()
    {
        // Autenticar um usuário (se necessário)
        $user = User::factory()->create();
        $this->actingAs($user);

        // Dado: Um departamento a ser criado
        $data = Departamento::factory()->make()->toArray();

        // Quando: Enviar requisição para criar o departamento
        $response = $this->post('/departamentos', $data);

        // Então: Verificar se o departamento foi criado
        $response->assertStatus(302); // Verifica se houve redirecionamento após a criação

        // Imprimir o conteúdo da resposta para debug
        echo $response->getContent();

        // Verificar se o departamento foi criado no banco de dados
        $this->assertDatabaseHas('departamentos', $data);

        // Verificar se o departamento foi realmente criado
        $createdDepartamento = Departamento::where('nome', $data['nome'])->first();
        $this->assertNotNull($createdDepartamento);
    }

    #[Test]
    public function it_can_update_a_departamento()
    {
        // Criar um departamento
        $departamento = Departamento::factory()->create();

        // Dados para atualizar
        $newData = ['nome' => 'Departamento de Física'];

        // Autenticar um usuário (se necessário)
        $user = User::factory()->create();
        $this->actingAs($user);

        // Enviar requisição para atualizar
        $response = $this->put("/departamentos/{$departamento->id}", $newData);

        // Verificar se foi redirecionado
        $response->assertStatus(302);

        // Imprimir o conteúdo da resposta para debug
        echo $response->getContent();

        // Verificar se o departamento foi atualizado no banco de dados
        $this->assertDatabaseHas('departamentos', $newData);

        // Verificar se o departamento foi realmente atualizado
        $updatedDepartamento = Departamento::find($departamento->id);
        $this->assertEquals($newData['nome'], $updatedDepartamento->nome);
    }

    #[Test]
    public function it_can_delete_a_departamento()
    {
    // Autenticar um usuário
    $user = User::factory()->create();
    $this->actingAs($user);

    // Criar um departamento
    $departamento = Departamento::factory()->create();

    // Enviar requisição para deletar
    $response = $this->delete("/departamentos/{$departamento->id}");

    // Verificar se houve redirecionamento
    $response->assertStatus(302);

    // Verificar se o departamento foi deletado da base de dados
    $this->assertDatabaseMissing('departamentos', ['id' => $departamento->id]);
    }

}
