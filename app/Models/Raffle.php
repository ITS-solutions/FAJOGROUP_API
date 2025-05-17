<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'tickets_number',
        'price',
        'status',
        'end_date',
        'sale_type',
        'initial_number',
        'raffle_category_id',
        'lottery_id'
    ];

    protected function casts(): array {
        return [
            'end_date' => 'datetime'
        ];
    }

    public function category() {
        return $this->belongsTo(RaffleCategory::class, 'raffle_category_id');
    }

    public function lottery() {
        return $this->belongsTo(Lottery::class);
    }

    public function details() {
        return $this->hasMany(RaffleDetail::class);
    }
}