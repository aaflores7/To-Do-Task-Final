<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TodoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_their_todos()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Todo::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/todos');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_user_cannot_see_others_todos()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Todo::factory()->create(['user_id' => $user2->id, 'title' => 'User 2 Task']);

        Sanctum::actingAs($user1);

        $response = $this->getJson('/api/todos');

        $response->assertStatus(200)
                 ->assertJsonCount(0); // Should be empty for User 1
    }

    public function test_user_can_create_todo()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $payload = [
            'title' => 'New Task',
            'description' => 'Task description',
            'due_date' => now()->addDay()->toDateTimeString(),
        ];

        $response = $this->postJson('/api/todos', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'New Task']);

        $this->assertDatabaseHas('todos', [
            'title' => 'New Task',
            'user_id' => $user->id
        ]);
    }

    public function test_search_functionality()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Todo::factory()->create(['user_id' => $user->id, 'title' => 'Buy Milk']);
        Todo::factory()->create(['user_id' => $user->id, 'title' => 'Walk Dog']);

        $response = $this->getJson('/api/todos?search=Milk');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['title' => 'Buy Milk']);
    }

    public function test_filter_by_status()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Todo::factory()->create(['user_id' => $user->id, 'is_completed' => true]);
        Todo::factory()->create(['user_id' => $user->id, 'is_completed' => false]);

        $response = $this->getJson('/api/todos?status=completed');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['is_completed' => true]); // FIX: Changed 1 to true
    }
}