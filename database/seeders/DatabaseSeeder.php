<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(VehicletypeSeeder::class); // no eliminamos este seeder porque ahi datos de prioridad en el sistema
        $this->call(RouteStatusSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(SectorSeeder::class);

        $this->call(UsertypesSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(VehicleSeeder::class);              // crear el procedure: sp_vehicles()
        $this->call(ZoneSeeder::class);              // crear el procedure: sp_zones()
    }
}
