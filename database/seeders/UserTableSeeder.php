<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                "name"=> " Administrator System",
                "first_name"=> " Administrator",
                "last_name"=> " System",
                "email"=> " admin@cornelder.co.mz",
                "password"=> Hash::make('password'),
                "mobile" => "811234567",
                "date_of_birth" => "1997-09-18",
                "is_active"=> 1,
                "gender_id"=> 1,
                "company_id"=> 1,
                "department_id"=>1,
                "created_at"=>now(),
                "updated_at"=>now(),
            ],
        ]);
    }
}
