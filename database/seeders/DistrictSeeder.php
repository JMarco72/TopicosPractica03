<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Distritos de Chiclayo
        $d1 = new District();
        $d1->name = 'Chiclayo';
        $d1->code = '140101';
        $d1->department_id = 1;
        $d1->province_id = 1;
        $d1->save();

        $d2 = new District();
        $d2->name = 'Chongoyape';
        $d2->code = '140102';
        $d2->department_id = 1;
        $d2->province_id = 1;
        $d2->save();

        $d3 = new District();
        $d3->name = 'Eten';
        $d3->code = '140103';
        $d3->department_id = 1;
        $d3->province_id = 1;
        $d3->save();

        $d4 = new District();
        $d4->name = 'Eten Puerto';
        $d4->code = '140104';
        $d4->department_id = 1;
        $d4->province_id = 1;
        $d4->save();

        $d5 = new District();
        $d5->name = 'José Leonardo Ortiz';
        $d5->code = '140105';
        $d5->department_id = 1;
        $d5->province_id = 1;
        $d5->save();

        $d6 = new District();
        $d6->name = 'La Victoria';
        $d6->code = '140106';
        $d6->department_id = 1;
        $d6->province_id = 1;
        $d6->save();

        $d7 = new District();
        $d7->name = 'Lagunas';
        $d7->code = '140107';
        $d7->department_id = 1;
        $d7->province_id = 1;
        $d7->save();

        $d8 = new District();
        $d8->name = 'Monsefú';
        $d8->code = '140108';
        $d8->department_id = 1;
        $d8->province_id = 1;
        $d8->save();

        $d9 = new District();
        $d9->name = 'Nueva Arica';
        $d9->code = '140109';
        $d9->department_id = 1;
        $d9->province_id = 1;
        $d9->save();

        $d10 = new District();
        $d10->name = 'Oyotún';
        $d10->code = '140110';
        $d10->department_id = 1;
        $d10->province_id = 1;
        $d10->save();

        $d11 = new District();
        $d11->name = 'Patapo';
        $d11->code = '140111';
        $d11->department_id = 1;
        $d11->province_id = 1;
        $d11->save();

        $d12 = new District();
        $d12->name = 'Picsi';
        $d12->code = '140112';
        $d12->department_id = 1;
        $d12->province_id = 1;
        $d12->save();

        $d13 = new District();
        $d13->name = 'Pimentel';
        $d13->code = '140113';
        $d13->department_id = 1;
        $d13->province_id = 1;
        $d13->save();

        $d14 = new District();
        $d14->name = 'Reque';
        $d14->code = '140114';
        $d14->department_id = 1;
        $d14->province_id = 1;
        $d14->save();

        $d15 = new District();
        $d15->name = 'Santa Rosa';
        $d15->code = '140115';
        $d15->department_id = 1;
        $d15->province_id = 1;
        $d15->save();

        $d16 = new District();
        $d16->name = 'Saña';
        $d16->code = '140116';
        $d16->department_id = 1;
        $d16->province_id = 1;
        $d16->save();

        $d17 = new District();
        $d17->name = 'Cayaltí';
        $d17->code = '140117';
        $d17->department_id = 1;
        $d17->province_id = 1;
        $d17->save();

        $d18 = new District();
        $d18->name = 'Tuman';
        $d18->code = '140118';
        $d18->department_id = 1;
        $d18->province_id = 1;
        $d18->save();
    }
}

       