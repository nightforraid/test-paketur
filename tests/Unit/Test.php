<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Test extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test to check if the user can register successfully.
     */
    public function testUserCanRegister()
    {
        // Send a POST request to the /api/register endpoint with required data.
        $response = $this->postJson('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone_number'=> '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123', // Ensure passwords match
            'address' => 'Test Address',
        ]);
    
        // Check if the response status is 201 and if the token is returned.
        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'token']);
    }
}
