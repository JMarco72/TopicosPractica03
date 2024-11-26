<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $m1 = new Brand();
        $m1->name = 'Toyota';
        $m1->description = 'Marca japonesa reconocida.';
        $m1->logo = null; // Si no tienes un logo, puedes dejarlo como null
        $m1->save();

        $m2 = new Brand();
        $m2->name = 'Ford';
        $m2->description = 'Fabricante estadounidense.';
        $m2->logo = null;
        $m2->save();

        $m3 = new Brand();
        $m3->name = 'Chevrolet';
        $m3->description = 'Marca de General Motors.';
        $m3->logo = null;
        $m3->save();

        $m1 = new Brand();
        $m1->name = 'Volvo Trucks';
        $m1->description = 'Fabricante sueco de camiones pesados.';
        $m1->logo = null;
        $m1->save();

        $m2 = new Brand();
        $m2->name = 'Scania';
        $m2->description = 'Fabricante sueco especializado en camiones y autobuses.';
        $m2->logo = null;
        $m2->save();

        $m6 = new Brand();
        $m6->name = 'Mercedes-Benz Trucks';
        $m6->description = 'Fabricante alemán líder en vehículos pesados.';
        $m6->logo = null;
        $m6->save();
    }
}
