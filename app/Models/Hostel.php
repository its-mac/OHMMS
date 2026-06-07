<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $fillable = [
        'name',
        'type',
        'capacity',
        'status',
    ];

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
