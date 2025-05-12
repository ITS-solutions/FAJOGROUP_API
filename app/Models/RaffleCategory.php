<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaffleCategory extends Model
{
    protected $table = 'raffle_categories';

    protected $fillable = [
        'name',
        'description',
        'icon',
        'status',
    ];
}
