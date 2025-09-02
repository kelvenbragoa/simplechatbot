<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('genders')->insert([
            [
                "name"=> " Masculino",
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
            [
                "name"=> "Feminino",
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
            [
                "name"=> " Outro",
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
        ]);
    }
}
