<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('activities')->insert([
            [
                "name"=> "Reparação de máquinas",
                "description"=> "Reparação de máquinas",
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
            [
                "name"=> "Entrega de material",
                "description"=> "Entrega de material",
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
            [
                "name"=> "Visita",
                "description"=> "Visita",
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
        ]);
    }
}
