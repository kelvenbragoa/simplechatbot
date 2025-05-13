<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $courses = [
            ['name' => 'Engenharia Civil', 'code' => 'ENGCIV', 'department' => 'Engenharia'],
            ['name' => 'Engenharia Elétrica', 'code' => 'ENGELET', 'department' => 'Engenharia'],
            ['name' => 'Engenharia Mecânica', 'code' => 'ENGMEC', 'department' => 'Engenharia'],
            ['name' => 'Engenharia de Produção', 'code' => 'ENGPROD', 'department' => 'Engenharia'],
            ['name' => 'Ciência da Computação', 'code' => 'CCOMP', 'department' => 'Tecnologia'],
            ['name' => 'Sistemas de Informação', 'code' => 'SINFO', 'department' => 'Tecnologia'],
            ['name' => 'Engenharia de Software', 'code' => 'ENGSW', 'department' => 'Tecnologia'],
            ['name' => 'Matemática', 'code' => 'MAT', 'department' => 'Exatas'],
            ['name' => 'Física', 'code' => 'FIS', 'department' => 'Exatas'],
            ['name' => 'Administração', 'code' => 'ADM', 'department' => 'Negócios'],
            ['name' => 'Economia', 'code' => 'ECO', 'department' => 'Negócios'],
            ['name' => 'Ciências Contábeis', 'code' => 'CONT', 'department' => 'Negócios'],
            ['name' => 'Direito', 'code' => 'DIR', 'department' => 'Direito'],
            ['name' => 'Jornalismo', 'code' => 'JOR', 'department' => 'Comunicação'],
            ['name' => 'Publicidade e Propaganda', 'code' => 'PUB', 'department' => 'Comunicação'],
            ['name' => 'Relações Internacionais', 'code' => 'RELINT', 'department' => 'Humanas'],
            ['name' => 'Medicina', 'code' => 'MED', 'department' => 'Saúde'],
            ['name' => 'Enfermagem', 'code' => 'ENF', 'department' => 'Saúde'],
            ['name' => 'Farmácia', 'code' => 'FARM', 'department' => 'Saúde'],
            ['name' => 'Odontologia', 'code' => 'ODONTO', 'department' => 'Saúde'],
            ['name' => 'Fisioterapia', 'code' => 'FISIO', 'department' => 'Saúde'],
            ['name' => 'Psicologia', 'code' => 'PSI', 'department' => 'Saúde'],
            ['name' => 'Nutrição', 'code' => 'NUT', 'department' => 'Saúde'],
            ['name' => 'História', 'code' => 'HIS', 'department' => 'Humanas'],
            ['name' => 'Geografia', 'code' => 'GEO', 'department' => 'Humanas'],
            ['name' => 'Filosofia', 'code' => 'FIL', 'department' => 'Humanas'],
            ['name' => 'Sociologia', 'code' => 'SOC', 'department' => 'Humanas'],
            ['name' => 'Pedagogia', 'code' => 'PED', 'department' => 'Educação'],
            ['name' => 'Letras – Português', 'code' => 'LETPOR', 'department' => 'Linguagens'],
            ['name' => 'Letras – Inglês', 'code' => 'LETING', 'department' => 'Linguagens'],
            ['name' => 'Arquitetura e Urbanismo', 'code' => 'ARQURB', 'department' => 'Artes e Arquitetura'],
            ['name' => 'Design Gráfico', 'code' => 'DESGRA', 'department' => 'Artes'],
            ['name' => 'Educação Física', 'code' => 'EDFIS', 'department' => 'Educação'],
            ['name' => 'Biomedicina', 'code' => 'BIOMED', 'department' => 'Saúde'],
            ['name' => 'Análise e Desenvolvimento de Sistemas', 'code' => 'ADS', 'department' => 'Tecnologia']
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
