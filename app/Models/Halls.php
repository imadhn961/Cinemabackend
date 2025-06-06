<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Halls extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function schedule()
    {
        return $this->hasMany(Schedules::class);
    }
}
