<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('departments')->insert([
                [
                    // 'id'=>1,
                    'name' => 'Administração (ADM)',
                    'code' => 'ADM',
                    'location'=> 'Main Office',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    // 'id'=>2,
                    'name' => 'Comercial e Marketing (DCM)',
                    'code' => 'DCM',
                    'location'=> 'Main Office',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    // 'id'=>3,
                    'name' => 'DASSO (DAS)',
                    'code' => 'DAS',
                    'location'=> 'Pousada',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    // 'id'=>4,
                    'name' => 'Finanças e Contabilidade (DFC)',
                    'code' => 'DFC',
                    'location'=> 'Main Office',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    // 'id'=>5,
                    'name' => 'Gabinete Tecnico (GT)',
                    'code' => 'GT',
                    'location'=> 'Main Office',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    // 'id'=>6,
                    'name' => 'Informática (ICT)',
                    'code' => 'ICT',
                    'location'=> 'Main Office',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    // 'id'=>7,
                    'name' => 'Manutenção (MAN)',
                    'code' => 'MAN',
                    'location'=> 'Porto',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    // 'id'=>8,
                    'name' => 'Procurement (PCT)',
                    'code' => 'PCT',
                    'location'=> 'Pousada',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    // 'id'=>9,
                    'name' => 'Recursos Humanos (DRH)',
                    'code' => 'DRH',
                    'location'=> 'Main Office',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
    }
}
