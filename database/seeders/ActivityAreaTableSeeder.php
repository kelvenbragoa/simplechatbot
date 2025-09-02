<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityAreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('activity_areas')->insert([
            [
                "name"=> "Manutenção",
                "description"=> "",
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
            [
                "name"=> "Cais 10",
                "description"=> "Cais 10",
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
            [
                "name"=> "Terminal de contentores",
                "description"=> "Terminal de contentores",
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
        ]);
    }
}
