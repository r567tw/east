<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutineTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'weeks_of_month',
        'day_of_week',
        'active',
    ];

    public function getTargetDateForThisMonth(): \Carbon\Carbon
    {
        $firstDay = \Carbon\Carbon::now()->startOfMonth();

        while ($firstDay->dayOfWeek !== $this->day_of_week) {
            $firstDay->addDay();
        }

        return $firstDay->copy()->addWeeks($this->weeks_of_month - 1);
    }
}
