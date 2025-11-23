<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable implements JWTSubject
{
    //
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'birthdate',
        'gender',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'user_type' => 'customer',
        ];
    }
}
