<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ShortUrl extends Model
{
    use HasFactory;

    //
    protected $fillable = ['url', 'short', 'user_id', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
