<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TypeIdentification extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\TypeIdentificationFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'short_name',
        'alphanumeric',
    ];
}
