<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeIdentification extends Model
{
    /** @use HasFactory<\Database\Factories\TypeIdentificationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'alphanumeric',
    ];
}
