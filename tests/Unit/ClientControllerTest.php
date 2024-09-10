<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_clients()
    {
        Client::create([
            'name' => 'João',
            'email' => 'joao@teste.com',
            'phone' => '11981847044',
            'document' => '48704357898'
        ]);

        $response = $this->getJson('/api/client');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'name' => 'João',
        ]);
    }

    /** @test */
    public function it_can_create_a_new_client()
    {
        $data = [
            'name' => 'Ana',
            'email' => 'ana@teste.com',
            'phone' => '11981847045',
            'document' => '12345678901'
        ];

        $response = $this->postJson('/api/client', $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('clients', $data);
    }

    /** @test */
    public function it_can_show_a_specific_client()
    {
        $client = Client::create([
            'name' => 'Carlos',
            'email' => 'carlos@teste.com',
            'phone' => '11981847046',
            'document' => '23456789012'
        ]);

        $response = $this->getJson("/api/client/{$client->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['name' => 'Carlos']);
    }

   /** @test */
    public function it_can_update_a_client()
    {
        $client = Client::create([
            'name' => 'Carlos',
            'email' => 'carlos@teste.com',
            'phone' => '11981847047',
            'document' => '11122334455'
        ]);

        $data = [
            'name' => 'Carlos Updated',
            'email' => 'carlos@teste.com',
            'phone' => '11981847047',
            'document' => '66677788899'
        ];

        $response = $this->putJson("/api/client/{$client->id}", $data);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('clients', ['name' => 'Carlos Updated']);
    }


    /** @test */
    public function it_can_delete_a_client()
    {
        $client = Client::create([
            'name' => 'Laura',
            'email' => 'laura@teste.com',
            'phone' => '11981847048',
            'document' => '22233344456'
        ]);

        $response = $this->deleteJson("/api/client/{$client->id}");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }

}
