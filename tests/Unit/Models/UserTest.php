<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_model_instantiable()
    {
        $model = new User;
        $this->assertInstanceOf(User::class, $model);
    }

    public function test_fillable()
    {
        $model = new User([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'secret',
        ]);
        $this->assertEquals('test', $model->name);
        $this->assertEquals('test@example.com', $model->email);
    }

    public function test_jwt_identifier()
    {
        $model = new User;
        $this->assertNull($model->getJWTIdentifier());
    }

    public function test_jwt_custom_claims()
    {
        $model = new User([
            'name' => 'test',
            'email' => 'test@example.com',
        ]);
        $claims = $model->getJWTCustomClaims();
        $this->assertArrayHasKey('email', $claims);
        $this->assertArrayHasKey('name', $claims);
        $this->assertArrayHasKey('user_type', $claims);
    }
}
