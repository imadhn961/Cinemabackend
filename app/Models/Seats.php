<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function schedule()
    {
        return $this->belongsTo(Schedules::class);
    }
    public function booking()
    {
        return $this->belongsTo(Bookings::class);
    }
}
