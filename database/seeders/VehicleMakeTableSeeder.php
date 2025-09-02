<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleMakeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('vehicle_makes')->insert([
            ["name" => "Toyota", "created_at" => now(), "updated_at" => now()],
            ["name" => "Mazda", "created_at" => now(), "updated_at" => now()],
            ["name" => "Honda", "created_at" => now(), "updated_at" => now()],
            ["name" => "Nissan", "created_at" => now(), "updated_at" => now()],
            ["name" => "Mitsubishi", "created_at" => now(), "updated_at" => now()],
            ["name" => "Suzuki", "created_at" => now(), "updated_at" => now()],
            ["name" => "Ford", "created_at" => now(), "updated_at" => now()],
            ["name" => "Chevrolet", "created_at" => now(), "updated_at" => now()],
            ["name" => "Hyundai", "created_at" => now(), "updated_at" => now()],
            ["name" => "Kia", "created_at" => now(), "updated_at" => now()],
            ["name" => "Volkswagen", "created_at" => now(), "updated_at" => now()],
            ["name" => "BMW", "created_at" => now(), "updated_at" => now()],
            ["name" => "Mercedes-Benz", "created_at" => now(), "updated_at" => now()],
            ["name" => "Audi", "created_at" => now(), "updated_at" => now()],
            ["name" => "Subaru", "created_at" => now(), "updated_at" => now()],
            ["name" => "Isuzu", "created_at" => now(), "updated_at" => now()],
            ["name" => "Peugeot", "created_at" => now(), "updated_at" => now()],
            ["name" => "Renault", "created_at" => now(), "updated_at" => now()],
            ["name" => "Fiat", "created_at" => now(), "updated_at" => now()],
            ["name" => "Land Rover", "created_at" => now(), "updated_at" => now()],
            ["name" => "Jeep", "created_at" => now(), "updated_at" => now()],
            ["name" => "Volvo", "created_at" => now(), "updated_at" => now()],
            ["name" => "Daihatsu", "created_at" => now(), "updated_at" => now()],
            ["name" => "Tata", "created_at" => now(), "updated_at" => now()],
            ["name" => "Chery", "created_at" => now(), "updated_at" => now()],
            ["name" => "Great Wall", "created_at" => now(), "updated_at" => now()],
            ["name" => "Geely", "created_at" => now(), "updated_at" => now()],
            ["name" => "MAN", "created_at" => now(), "updated_at" => now()],
            ["name" => "Scania", "created_at" => now(), "updated_at" => now()],
            ["name" => "Hino", "created_at" => now(), "updated_at" => now()],
        ]);
    }
}
