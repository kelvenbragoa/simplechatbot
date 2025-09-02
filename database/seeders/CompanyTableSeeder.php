<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('companies')->insert([
            [
                "name"=> " Cornelder De Mocambique",
                "description"=>"Cornelder de Mocambique",
                "mobile"=>"21028991",
                "email"=>"cornelder@cornelder.co.mz",
                "address"=>"Lagos do CFM",
                "internal_company"=> 1,
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
        ]);
    }
}
