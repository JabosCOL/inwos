<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'role1' => [
                'name' => 'admin'
            ],
            'role2' => [
                'name' => 'user'
            ],
        ];

        foreach ($roles as $data) {
            $role = new Role();
            $role->name = $data['name'];
            $role->save();
        }
    }
}
