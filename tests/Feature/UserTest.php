<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;    

    protected $userData = [
        'name'          => 'gabriel test',
        'email'         => 'teste@gabriel.com',
        'password'      => 'testegabriel',
        'cpf'           => '03303303394',
        'phone_number'  => '55998765432'
    ];

    public function test_can_create_user_with_all_data(): void
    {
        $response = $this->postJson('/api/user', $this->userData);

        $response->assertStatus(201);
        $response->assertJson([
            'status' => 'success'
        ]);
    }

    public function test_cannot_create_user_without_email_field(): void
    {
        $user = $this->userData;
        unset($user['email']);

        $response = $this->postJson('/api/user', $user);

        $response->assertStatus(400);
    }

    public function test_user_can_get_data_using_valid_token_validation(): void
    {
        $userData = $this->userData;
        
        $token = $this->createUserAndGetToken($userData);

        $user = $this->getJson('api/user', ['Authorization' => "Bearer $token"]);

        $user->assertOk()
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'cpf',
                    'phone_number',
                    'addresses'
                ]
            ]);
    }

    private function createUserAndGetToken(array $userData): string
    {
        $user = $this->postJson('api/user', $userData);

        $user->assertCreated();
        
        $token = $this->postJson('api/auth', [
            'email'     => $userData['email'],
            'password'  => $userData['password']
        ]);

        $token->assertOk();

        return $token->json('access_token');
    }
}
