<?php

namespace Database\Seeders;

use App\Models\TypeIdentification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeIdentificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeIdentification::create([
            'name' => 'Cedula de ciudadania',
            'short_name' => 'CC',
            'alphanumeric' => false
        ]);
        TypeIdentification::create([
            'name' => 'Pasaporte',
            'short_name' => 'PS',
            'alphanumeric' => true
        ]);
    }
}
