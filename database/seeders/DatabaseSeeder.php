<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TypeIdentificationSeeder::class,
            RolesSeeder::class,
            PermissionsSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
