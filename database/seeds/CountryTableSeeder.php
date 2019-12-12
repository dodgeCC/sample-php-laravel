<?php

use Illuminate\Database\Seeder;
use App\Country;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = ['UK', 'Ireland', 'Netherlands', 'Belgium', 'Germany'];
        foreach ($countries as $name) {
        	$country = new Country;
        	$country->name = $name;
        	$country->save();
        }
    }
}
