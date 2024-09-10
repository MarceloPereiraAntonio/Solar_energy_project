<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\InstallationType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class InstallationTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_index_installation_types()
    {
        InstallationType::create(['item' => 'Laje']);

        $response = $this->getJson('/api/install_type');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'item' => 'Laje',
        ]);
    }

    /** @test */
    public function it_can_store_a_new_installation_type()
    {
        $data = ['item' => 'Telhado'];

        $response = $this->postJson('/api/install_type', $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('installation_types', $data);
    }

    /** @test */
    public function it_can_show_a_specific_installation_type()
    {
        $installationType = InstallationType::create(['item' => 'Telhado']);

        $response = $this->getJson("/api/install_type/{$installationType->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['item' => 'Telhado']);
    }

    /** @test */
    public function it_can_update_an_installation_type()
    {
        $installationType = InstallationType::create(['item' => 'Laje']);

        $data = ['item' => 'Terreno'];

        $response = $this->putJson("/api/install_type/{$installationType->id}", $data);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('installation_types', $data);
    }

    /** @test */
    public function it_can_delete_an_installation_type()
    {
        $installationType = InstallationType::create(['item' => 'Telhado']);

        $response = $this->deleteJson("/api/install_type/{$installationType->id}");

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('installation_types', ['id' => $installationType->id]);
    }
}
