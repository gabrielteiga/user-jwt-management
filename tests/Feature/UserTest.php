<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
