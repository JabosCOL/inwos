<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'category1' => [
                'name' => 'Salud y belleza',
            ],
            'category2' => [
                'name' => 'Reparaciones',
            ],
            'category3' => [
                'name' => 'Servicio doméstico',
            ],
            'category4' => [
                'name' => 'Organización de eventos',
            ],
            'category5' => [
                'name' => 'Mascotas',
            ],
            'category6' => [
                'name' => 'Niñera/Cuidadora de adultos',
            ],
            'category7' => [
                'name' => 'Escritor/Editor/Traductor',
            ],
            'category8' => [
                'name' => 'Otros servicios',
            ],
        ];


        foreach ($categories as $data) {
            $category = new Category();
            $category->name = $data['name'];
            $category->save();
        }
    }
}
