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

    public function test_user_cannot_get_his_data_without_valid_token_validation(): void
    {
        $userData = $this->userData;
        
        $token = $this->createUserAndGetToken($userData);
        $token .= "invalidSufix";

        $user = $this->getJson('api/user', ['Authorization' => "Bearer $token"]);

        $user->assertUnauthorized();
    }

    public function test_user_can_edit_name_cpf_and_phone_number_with_valid_token_header(): void
    {
        $token = $this->createUserAndGetToken($this->userData);

        $editUserData = [
            'name'          => 'gabriel',
            'email'         => 'itwontbeedit@example.com',
            'cpf'           => '22211133344',
            'phone_number'  => '51987654321'
        ];

        $response = $this->patchJson('api/user', $editUserData, ['Authorization' => "Bearer $token"]);

        $response->assertOk()
            ->assertJson([
                'name'          => $editUserData['name'],
                'email'         => $this->userData['email'],
                'cpf'           => $editUserData['cpf'],
                'phone_number'  => $editUserData['phone_number']
            ]);
    }

    public function test_user_can_delete_his_account_using_valid_token(): void
    {
        $token = $this->createUserAndGetToken($this->userData);

        $response = $this->deleteJson('api/user', [], ['Authorization' => "Bearer $token"]);

        $response->assertOk()
            ->assertJson([
                'message'   => 'User deleted successfully',
                'status'    => 'success'
            ]);
    }

    public function test_user_cannot_delete_his_account_without_valid_token(): void
    {
        $token = $this->createUserAndGetToken($this->userData);
        $token .= 'invalidSufix';

        $response = $this->deleteJson('api/user', [], ['Authorization' => "Bearer $token"]);

        $response->assertUnauthorized();
    }

    public function test_user_can_add_new_address(): void
    {
        $token = $this->createUserAndGetToken($this->userData);

        $address = [
            'street'        => 'Rua Joãozinho da silva',
            'number'        => '238',
            'neighborhood'  => 'Bela Vista',
            'complement'    => 'casa',
            'zip_code'      => '18000000'
        ];

        $response = $this->postJson('api/user/address', $address, ['Authorization' => "Bearer $token"]);

        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'status',
                'user'
            ]);
    }

    public function test_user_can_add_new_address_without_complement(): void
    {
        $token = $this->createUserAndGetToken($this->userData);

        $address = [
            'street'        => 'Rua Joãozinho da silva',
            'number'        => '238',
            'neighborhood'  => 'Bela Vista',
            'zip_code'      => '18000000'
        ];

        $response = $this->postJson('api/user/address', $address, ['Authorization' => "Bearer $token"]);

        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'status',
                'user'
            ]);
    }

    public function test_user_cannot_add_new_address_without_street(): void
    {
        $token = $this->createUserAndGetToken($this->userData);

        $address = [
            'number'        => '238',
            'neighborhood'  => 'Bela Vista',
            'complement'    => 'casa',
            'zip_code'      => '18000000'
        ];

        $response = $this->postJson('api/user/address', $address, ['Authorization' => "Bearer $token"]);

        $response->assertBadRequest();
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
