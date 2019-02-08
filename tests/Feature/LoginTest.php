<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Hash;

class LoginTest extends TestCase
{

    //admin@email.com
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(401)
            ->assertJson([
                'data' => 'Unauthorised',
            ]);
    }


    public function testUserLoginsSuccessfully()
    {

        $password = Hash::make('admin1');
        User::create([
            'name' => 'admin1',
            'email' => 'admin1@email.com',
            'password' => $password,
            'role' => User::ADMINISTRATOR
        ]);

        $payload = ['email' => 'admin1@email.com', 'password' => 'admin1'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);

    }

}
