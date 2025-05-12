<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $table = 'lotteries';
    
    protected $fillable = [
        'name',
        'image',
    ];
}
