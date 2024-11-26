<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Programming;
use App\Models\Route;
use App\Models\Routestatus;
use App\Models\Vehicle;
use App\Models\Vehicleroutes;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgrammingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::pluck('name', 'id');
        $routes = Route::pluck('name', 'id');
        $programmings = [];

        return view('admin.programming.index', compact('programmings', 'vehicles', 'routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routes = Route::pluck('name', 'id');
        return view('admin.programming.create', compact('routes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $p = [
            'startdate' => $request->startdate,
            'lastdate' => $request->lastdate,
            'vehicle_id' => $request->vehicle_id,
            'route_id' => $request->route_id
        ];
        if ($this->searchifexist($p) == 0) {
            $p = Programming::create([
                'startdate' => $request->startdate,
                'lastdate' => $request->lastdate,
                'starttime' => $request->starttime
            ]);

            $begin = new DateTime($request->startdate);
            //$end = new DateTime($request->lastdate);
            $fechafinal = date($request->lastdate);
            $final = date("d-m-Y", strtotime($fechafinal . '+ 1 days'));

            // echo $final;

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, new DateTime($final));

            foreach ($period as $dt) {
                Vehicleroutes::create([
                    'date_route' => $dt->format("Y-m-d"),
                    'description' => '',
                    'vehicle_id' => $request->vehicle_id,
                    'route_id' => $request->route_id,
                    'routestatus_id' => 1,
                    'programming_id' => $p->id
                ]);
            }

            return redirect()->route('admin.programming.index')->with('success', 'Programacion registrada'); 
        } else {
            return redirect()->route('admin.programming.index')->with('error', 'Ya existe una programación con entre esos días, ruta y vehículo, por favor verifique');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vr = Vehicleroutes::with('programming')->find($id);;
        $vehicles = Vehicle::pluck('name', 'id');
        $routes = Route::pluck('name', 'id');
        $routestatus = Routestatus::pluck('name', 'id');
        if (!$vr) {
            return redirect()->route('admin.programming.index')->with('error', 'Programación no encontrada.');
        }
        return view('admin.programming.edit', compact('vr', 'vehicles', 'routes', 'routestatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        // Buscar el registro en vehicleroutes con la relación programming
    $vr = Vehicleroutes::with('programming')->find($id);

    if (!$vr) {
        return redirect()->route('admin.programming.index')->with('error', 'Programación no encontrada.');
    }

    // Actualizar la hora en la tabla programmings (relación)
    if ($vr->programming) {
        $vr->programming->update([
            'starttime' => $request->starttime,
        ]);
    }

    // Actualizar los valores de vehicleroutes
    $vr->update([
        'description' => $request->description,
        'routestatus_id' => $request->routestatus_id,
    ]);
        return redirect()->route('admin.programming.index')->with('success', 'Programacion actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $programming = Vehicleroutes::find($id);
        $programming->delete();
        return redirect()->route('admin.programming.index')->with('success', 'Programacion eliminada');
    }

    public function searchprogramming(Request $request)
    {
        $listado = DB::select(
            'SELECT 
                vr.id, 
                vr.date_route AS fecha, 
                p.starttime AS hora, -- Obtiene la hora desde la tabla programmings
                rs.name AS estado, 
                v.name AS vehiculo, 
                r.name AS ruta, 
                vr.description
            FROM vehicleroutes vr
            INNER JOIN routes r ON vr.route_id = r.id
            INNER JOIN vehicles v ON vr.vehicle_id = v.id
            INNER JOIN programmings p ON vr.programming_id = p.id -- Relación con programmings
            INNER JOIN routestatus rs ON vr.routestatus_id = rs.id
            WHERE vr.vehicle_id = ? 
            AND vr.route_id = ? 
            AND vr.date_route BETWEEN ? AND ?',
            [
                $request->vehicle_id, 
                $request->route_id, 
                $request->startdate, 
                $request->lastdate,
            ]
        );
    
        return view('admin.programming.list', compact('listado'));
    }

    public function searchifexist($p)
    {
        $programacion = DB::select(
            'select * from vehicleroutes where vehicle_id=? and route_id=? and date_route between ? and ?',
            [
                $p['vehicle_id'],
                $p['route_id'],
                $p['startdate'],
                $p['lastdate']
            ]
        );
        $exist = count($programacion);
        if ($exist > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}
