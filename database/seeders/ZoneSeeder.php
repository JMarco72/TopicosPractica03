<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared('
        CREATE PROCEDURE `proyectoGrupal`.`sp_zones`(
            IN _operacion INT,
            IN _id BIGINT
        )
        BEGIN
            IF _operacion = 1 THEN
                SELECT z.id AS id, z.name AS name, z.area AS area, s.name AS sector, z.description AS description
                FROM zones z
                INNER JOIN sectors s ON z.sector_id = s.id;
            END IF;

            IF _operacion = 2 THEN
                SELECT z.id AS id, z.name AS name, z.area AS area, s.name AS sector, z.description AS description
                FROM zones z
                INNER JOIN sectors s ON z.sector_id = s.id
                WHERE z.id = _id;
            END IF;
        
            IF _operacion = 3 THEN
                SELECT z.name as zone, z2.latitude, z2.longitude 
                FROM zones z 
                INNER JOIN zonecoords z2 ON z2.zone_id = z.id 
                WHERE z.sector_id = _id;
            END IF;
            
        END

    ');
    }
}
