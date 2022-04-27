<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            'city1' => [
                'name' => 'Bogotá',
            ],
            'city2' => [
                'name' => 'Medellin',
            ],
            'city3' => [
                'name' => 'Cali',
            ],
        ];

        foreach ($cities as $data) {
            $city = new City();
            $city->name = $data['name'];
            $city->save();
        }
    }
}
