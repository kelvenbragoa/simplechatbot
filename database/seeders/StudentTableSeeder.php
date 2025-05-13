<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create('pt_PT');

        $academicStatuses = ['Regular', 'Trancado', 'Formado', 'Cancelado'];
        $financialStatuses = ['Regular', 'Em atraso', 'Isento'];

        for ($i = 0; $i < 20; $i++) {
            Student::create([
                'name' => $faker->name,
                'student_number' => '9012025' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'academic_status' => $faker->randomElement($academicStatuses),
                'financial_status' => $faker->randomElement($financialStatuses),
            ]);
        }
    }
}
