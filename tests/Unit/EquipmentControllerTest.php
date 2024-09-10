<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class EquipmentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_equipment()
    {
        Equipment::create(['item' => 'Estrutura']);

        $response = $this->getJson('/api/equipment');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'item' => 'Estrutura',
        ]);
    }

    /** @test */
    public function it_can_create_a_new_equipment()
    {
        $data = ['item' => 'Fita de Aterramento'];

        $response = $this->postJson('/api/equipment', $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('equipment', $data);
    }

    /** @test */
    public function it_can_show_a_specific_equipment()
    {
        $equipment = Equipment::create(['item' => 'Parafusos']);

        $response = $this->getJson("/api/equipment/{$equipment->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['item' => 'Parafusos']);
    }

    /** @test */
    public function it_can_update_an_equipment()
    {
        $equipment = Equipment::create(['item' => 'Estrutura']);

        $data = ['item' => 'Parafusos'];

        $response = $this->putJson("/api/equipment/{$equipment->id}", $data);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('equipment', $data);
    }

    /** @test */
    public function it_can_delete_an_equipment()
    {
        $equipment = Equipment::create(['item' => 'Fita de Aterramento']);

        $response = $this->deleteJson("/api/equipment/{$equipment->id}");

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('equipment', ['id' => $equipment->id]);
    }
}
