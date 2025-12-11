<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login_and_me_and_logout()
    {
        $user = User::factory()->create();
        // 登入
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $login->assertStatus(200);
        $token = $login->json('token');
        $this->assertNotEmpty($token);

        // me (需帶 token)
        $me = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/me');
        $me->assertStatus(200);
        $this->assertEquals($user->email, $me->json('email'));

        // refresh (需帶 token)
        $refresh = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/refresh');
        $refresh->assertStatus(200);
        $newToken = $refresh->json('token');
        $this->assertNotEmpty($newToken);

        // logout (需帶 token)
        $logout = $this->withHeader('Authorization', "Bearer $newToken")->postJson('/api/logout');
        $logout->assertStatus(200);
    }

    public function test_customer_register()
    {
        $email = 'customer'.Str::random(5).'@example.com';
        $response = $this->postJson('/api/customer/register', [
            'name' => 'Customer',
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(201);
    }
}
