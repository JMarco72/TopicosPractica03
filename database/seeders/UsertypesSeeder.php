<?php

namespace Database\Seeders;

use App\Models\Usertype;
use App\Models\Usertypes;

use Illuminate\Database\Seeder;

class UsertypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $u1 = new Usertype();
        $u1->name = 'Administrador';
        $u1->description = '';
        $u1->save();

        $u2 = new Usertype();
        $u2->name = 'Conductor';
        $u2->description = '';
        $u2->save();

        $u3 = new Usertype();
        $u3->name = 'Recolector';
        $u3->description = '';
        $u3->save();

        $u4 = new Usertype();
        $u4->name = 'Ciudadano';
        $u4->description = '';
        $u4->save();
    }
}
