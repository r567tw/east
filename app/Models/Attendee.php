<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Attendee extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['name', 'email'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
