<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    //
    protected $fillable = ['url', 'short', 'expires_at'];
}
