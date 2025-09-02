<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(VehicleMakeTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(VehicleClassTableSeeder::class);
        $this->call(ActivityTableSeeder::class);
        $this->call(ActivityAreaTableSeeder::class);
        $this->call(RolesPermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CompanyTableSeeder::class);

    }
}
