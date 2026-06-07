<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessMenu extends Model
{
    protected $fillable = [
        'meal_session_id',
        'menu_date',
        'menu_items',
    ];

    public function mealSession()
    {
        return $this->belongsTo(MealSession::class);
    }
}
