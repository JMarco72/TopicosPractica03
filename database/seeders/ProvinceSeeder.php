<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $p1 = new Province();
        $p1->name = 'Chiclayo';
        $p1->code = '140101';
        $p1->department_id = 1;
        $p1->save();

        $p2 = new Province();
        $p2->name = 'Lambayeque';
        $p2->code = '140201';
        $p2->department_id = 1;
        $p2->save();

        $p3 = new Province();
        $p3->name = 'Ferreñafe';
        $p3->code = '140301';
        $p3->department_id = 1;
        $p3->save();
    }
}
