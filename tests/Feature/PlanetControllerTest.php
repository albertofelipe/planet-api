<?php

namespace Tests\Feature;

use App\Models\Planet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestCase;

class PlanetControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_can_list_planets() 
    {
        Planet::factory()->count(3)->create();

        $response = $this->getJson('/api/planets');

        $response->assertOk()
                 ->assertJsonCount(3)
                 ->assertJsonStructure([
                    '*' => ['id', 'name', 'climate', 'terrain'] 
                 ]);
    }

    public function test_bring_filtered_data_successfully()
    {
        Planet::factory()->count(2)->create([
            'name' => 'tatooine',
            'climate' => 'arid'
        ]);

        Planet::factory()->count(1)->create([
            'name' => 'ignorated',
        ]);

        $response = $this->getJson('/api/planets?name[eq]=tatooine&climate[eq]=arid');

        $response->assertOk()
                 ->assertJsonCount(2)
                 ->assertJsonFragment([
                    'name' => Planet::first()->name,
                    'climate' => Planet::first()->climate
                 ]);
    }

    public function test_bring_filtered_data_returns_empty_array()
    {
        Planet::factory()->count(3)->create([
            'name' => 'tatooine'
        ]);

        $response = $this->getJson('/api/planets?name[eq]=filter');

        $response->assertOk()
                 ->assertExactJson([]);
    }

    public function test_can_create_planet() 
    {
        $data = [
            'name' => 'tatooine',
            'climate' => 'arid',
            'terrain' => 'arid'
        ];

        $response = $this->postJson('/api/planets', $data);

        $response->assertCreated()
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('planets', [
            'name' => $data['name']
        ]);
    }

    public function test_cannot_create_planet_with_invalid_data()
    {
        $data = [
            'name' => 'tatooine',
            'climate' => '',
        ];

        $response = $this->postJson('/api/planets', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['climate']);
        
        $this->assertDatabaseMissing('planets', [
            'name' => 'tatooine'
        ]);
    }

    public function test_can_bring_single_planet()
    {
        $planet = Planet::factory()->create();

        $response = $this->getJson("/api/planets/{$planet->id}");

        $response->assertOk()
                 ->assertJsonFragment([
                    'name' => $planet->name
                 ]);
    }

    public function test_cannot_bring_single_planet_returns_not_found() 
    {
        $nonExistentId = 999;

        $response = $this->getJson("/api/planets/{$nonExistentId}");

        $response->assertNotFound();
    }

    public function test_can_update_planet()
    {
        $planet = Planet::factory()->create();

        $updateData = [
            'name' => 'Alderaan',
            'climate' => 'temperate',
            'terrain' => 'mountains'
        ];

        $response = $this->putJson("/api/planets/{$planet->id}", $updateData);

        $response->assertOk()
                ->assertJsonFragment($updateData);

        $this->assertDatabaseHas('planets', [
            'id' => $planet->id,
            'name' => 'Alderaan',
            'climate' => 'temperate',
            'terrain' => 'mountains'
        ]);
    }

    public function test_cannot_update_planet_with_invalid_data()
    {
        $planet = Planet::factory()->create();

        $invalidData = [
            'name' => '',
            'climate' => '',
            'terrain' => 'desert'
        ];

        $response = $this->putJson("/api/planets/{$planet->id}", $invalidData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name', 'climate']);

        $this->assertDatabaseHas('planets', [
            'id' => $planet->id,
            'name' => $planet->name,
            'climate' => $planet->climate,
            'terrain' => $planet->terrain
        ]);
    }

    public function test_can_delete_planet()
    {
        $planet = Planet::factory()->create();

        $response = $this->deleteJson("/api/planets/{$planet->id}");

        $response->assertNoContent(); // HTTP 204

        $this->assertDatabaseMissing('planets', [
            'id' => $planet->id
        ]);
    }

    public function test_cannot_delete_nonexistent_planet()
    {
        $nonExistentId = 999;

        $response = $this->deleteJson("/api/planets/{$nonExistentId}");

        $response->assertNotFound();
    }

}
