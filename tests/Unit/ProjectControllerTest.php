<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Client;
use App\Models\InstallationType;
use Illuminate\Http\Response;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_lists_projects_with_filters()
    {
        $client = Client::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@test.com',
            'phone' => '123456789',
            'document' => '12345678901'
        ]);

        $installType = InstallationType::create([
            'item' => 'Tipo Instalação Teste'
        ]);

        // Criar projetos
        $project1 = Project::create([
            'name' => 'Projeto 1',
            'client_id' => $client->id,
            'install_type_id' => $installType->id,
            'region' => 'SP'
        ]);

        $response = $this->getJson('/api/projects?region=SP');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    [
                        'id' => $project1->id,
                        'name' => 'Projeto 1',
                        'client_id' => $client->id,
                        'install_type_id' => $installType->id,
                        'region' => 'SP'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_stores_a_project()
    {
        $client = Client::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@test.com',
            'phone' => '123456789',
            'document' => '12345678901'
        ]);

        $installType = InstallationType::create([
            'item' => 'Tipo Instalação Teste'
        ]);

        $data = [
            'name' => 'Projeto Teste',
            'client_id' => $client->id,
            'install_type_id' => $installType->id,
            'region' => 'SP',
            'equipment' => [
                ['id' => 1, 'amount' => 10],
                ['id' => 2, 'amount' => 5]
            ]
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['message' => 'New project created!']);

        $this->assertDatabaseHas('projects', [
            'name' => 'Projeto Teste',
            'client_id' => $client->id,
            'install_type_id' => $installType->id,
            'region' => 'SP'
        ]);

        $project = Project::where('name', 'Projeto Teste')->first();
        $this->assertNotNull($project);
        $this->assertDatabaseHas('project_equipment', [
            'project_id' => $project->id,
            'equipment_id' => 1,
            'amount' => 10
        ]);
        $this->assertDatabaseHas('project_equipment', [
            'project_id' => $project->id,
            'equipment_id' => 2,
            'amount' => 5
        ]);
    }

    /**
     * @test
     */
    public function it_shows_a_project()
    {
        $client = Client::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@test.com',
            'phone' => '123456789',
            'document' => '12345678901'
        ]);

        $installType = InstallationType::create([
            'item' => 'Tipo Instalação Teste'
        ]);

        $project = Project::create([
            'name' => 'Projeto Teste',
            'client_id' => $client->id,
            'install_type_id' => $installType->id,
            'region' => 'SP'
        ]);

        $project->equipment()->attach([
            1 => ['amount' => 10],
            2 => ['amount' => 5]
        ]);

        $response = $this->getJson('/api/projects/' . $project->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'id' => $project->id,
                'name' => 'Projeto Teste',
                'client_id' => $client->id,
                'install_type_id' => $installType->id,
                'region' => 'SP',
                'equipment' => [
                    [
                        'id' => 1,
                        'item' => 'Módulo',
                        'pivot' => [
                            'amount' => 10,
                        ]
                    ],
                    [
                        'id' => 2,
                        'item' => 'Inversor',
                        'pivot' => [
                            'amount' => 5,
                        ]
                    ]
                ],
                'client' => [
                    'id' => $client->id,
                    'name' => 'Cliente Teste',
                    'email' => 'cliente@test.com',
                    'phone' => '123456789',
                    'document' => '12345678901'
                ]
            ]);
    }


    /**
     * @test
     */
    public function it_updates_a_project()
    {

        $client = Client::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@test.com',
            'phone' => '123456789',
            'document' => '12345678901'
        ]);

        $installType = InstallationType::create([
            'item' => 'Tipo Instalação Teste'
        ]);

        $project = Project::create([
            'name' => 'Projeto Teste',
            'client_id' => $client->id,
            'install_type_id' => $installType->id,
            'region' => 'SP'
        ]);

        $project->equipment()->attach([
            1 => ['amount' => 10]
        ]);

        $data = [
            'name' => 'Projeto Atualizado',
            'client_id' => $client->id,
            'install_type_id' => $installType->id,
            'region' => 'RJ',
            'equipment' => [
                ['id' => 1, 'amount' => 20],
                ['id' => 2, 'amount' => 15]
            ]
        ];

        $response = $this->putJson('/api/projects/' . $project->id, $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Project updated!']);

        $this->assertDatabaseHas('projects', [
            'name' => 'Projeto Atualizado',
            'client_id' => $client->id,
            'install_type_id' => $installType->id,
            'region' => 'RJ'
        ]);

        $this->assertDatabaseHas('project_equipment', [
            'project_id' => $project->id,
            'equipment_id' => 1,
            'amount' => 20
        ]);
        $this->assertDatabaseHas('project_equipment', [
            'project_id' => $project->id,
            'equipment_id' => 2,
            'amount' => 15
        ]);
    }

    /**
     * @test
     */
    public function it_deletes_a_project()
    {
        $client = Client::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@test.com',
            'phone' => '123456789',
            'document' => '12345678901'
        ]);

        $installType = InstallationType::create([
            'item' => 'Tipo Instalação Teste'
        ]);

        $project = Project::create([
            'name' => 'Projeto Teste',
            'client_id' => $client->id,
            'install_type_id' => $installType->id,
            'region' => 'SP'
        ]);

        $project->equipment()->attach([
            1 => ['amount' => 10]
        ]);

        $response = $this->deleteJson('/api/projects/' . $project->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Project deleted!']);

        $this->assertSoftDeleted('projects', [
            'id' => $project->id
        ]);
    }
}
