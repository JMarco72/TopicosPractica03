<?php

namespace Database\Seeders;

use App\Models\Vehiclecolor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiclecolorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $m1 = new VehicleColor();
        $m1->name = 'Rojo';
        $m1->red = 255;
        $m1->green = 0;
        $m1->blue = 0;
        $m1->description = 'Color rojo brillante.';
        $m1->save();

        $m2 = new VehicleColor();
        $m2->name = 'Verde';
        $m2->red = 0;
        $m2->green = 255;
        $m2->blue = 0;
        $m2->description = 'Color verde brillante.';
        $m2->save();

        $m3 = new VehicleColor();
        $m3->name = 'Azul';
        $m3->red = 0;
        $m3->green = 0;
        $m3->blue = 255;
        $m3->description = 'Color azul brillante.';
        $m3->save();

        $m4 = new VehicleColor();
        $m4->name = 'Blanco';
        $m4->red = 255;
        $m4->green = 255;
        $m4->blue = 255;
        $m4->description = 'Color blanco puro.';
        $m4->save();

        $m5 = new VehicleColor();
        $m5->name = 'Negro';
        $m5->red = 0;
        $m5->green = 0;
        $m5->blue = 0;
        $m5->description = 'Color negro sólido.';
        $m5->save();

        $m6 = new VehicleColor();
        $m6->name = 'Amarillo';
        $m6->red = 255;
        $m6->green = 255;
        $m6->blue = 0;
        $m6->description = 'Color amarillo vibrante.';
        $m6->save();
    }
}
