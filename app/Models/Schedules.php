<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedules extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function movie()
    {
        return $this->belongsTo(Movies::class);
    }
    public function hall()
    {
        return $this->belongsTo(Halls::class);
    }
    public function seats(): HasMany
    {
        return $this->hasMany(Seats::class);
    }
}
