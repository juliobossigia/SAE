<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Local;
use App\Models\Predio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LocalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_locais(){
        $user = User::factory()->create();
        $this->actingAs($user);

        Local::factory()->count(5)->create();

        $response = $this->get(route('locais.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Lista de Locais');

    }

    #[Test]
    public function it_can_create_a_local(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $localData = Local::factory()->make()->toArray();

        $response = $this->post(route('locais.store'),$localData);

        $this->assertDatabaseHas('locais',$localData);

        $response->assertRedirect(route('locais.index'));
    }

    #[Test]
    public function it_can_delete_a_local(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $local = Local::factory()->create();
        
        $response = $this->delete(route('locais.destroy',$local->id));

        $this->assertDatabaseMissing('locais',['id'=>$local->id]);

        $response->assertRedirect(route('locais.index'));
    }

}