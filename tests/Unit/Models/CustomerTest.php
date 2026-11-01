<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function test_model_instantiable()
    {
        $model = new Customer;
        $this->assertInstanceOf(Customer::class, $model);
    }

    public function test_fillable()
    {
        $model = new Customer([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'secret',
            'phone' => '123',
            'address' => 'addr',
            'birthdate' => '2000-01-01',
            'gender' => 'M',
        ]);
        $this->assertEquals('test', $model->name);
        $this->assertEquals('test@example.com', $model->email);
    }

    public function test_jwt_identifier()
    {
        $model = new Customer;
        $this->assertNull($model->getJWTIdentifier());
    }

    public function test_jwt_custom_claims()
    {
        $model = new Customer([
            'name' => 'test',
            'email' => 'test@example.com',
        ]);
        $claims = $model->getJWTCustomClaims();
        $this->assertArrayHasKey('email', $claims);
        $this->assertArrayHasKey('name', $claims);
        $this->assertArrayHasKey('user_type', $claims);
    }
}
