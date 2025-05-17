<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaffleDetail extends Model
{
    protected $fillable = [
        'number',
        'status',
        'is_winner',
        'raffle_id'
    ];

    public function raffle() {
        return $this->belongsTo(Raffle::class);
    }
}
