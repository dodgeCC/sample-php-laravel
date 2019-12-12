<?php

use Illuminate\Database\Seeder;
use App\City;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = ['London'=>1, 'Cardiff'=>1, 'Dublin'=>2, 'Amsterdam'=>3, 'Brussels'=>4, 'Berlin'=>5];
        foreach ($cities as $name => $country_id) {
        	$city = new City;
        	$city->name = $name;
        	$city->country_id = $country_id;
        	$city->save();
        }
    }
}
