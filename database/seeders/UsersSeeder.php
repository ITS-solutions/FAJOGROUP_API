<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'lastname' => '',
            'identification' => 123456789,
            'password' => Hash::make('12345'),
            'email' => 'admin@mail.com',
            'phone_number' => 123456789,
            'address' => null,
            'type_identification_id' => 1
        ]);

        $user->assignRole('admin');
    }
}
