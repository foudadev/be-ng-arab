<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            [
                'email' => 'admin@ng.com',
            ],
            [
                'id'       => (string)Str::uuid(),
                'name'     => 'Admin',
                'password' => bcrypt('123456'),
            ]
        );
    }
}
