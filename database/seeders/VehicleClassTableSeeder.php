<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('vehicle_classes')->insert([
            [
                "name"=> " Ligeiro",
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
            [
                "name"=> " Pesado",
                "created_at"=>now(),
                "updated_at"=>now(),
            ]
        ]);
    }
}
