<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->name = 'adminInwos';
        $admin->email = 'adminInwos@gmail.com';
        $admin->password = Hash::make('admin');
        $admin->role_id = '1';
        $admin->save();
    }
}
