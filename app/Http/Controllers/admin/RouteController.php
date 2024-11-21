<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $routes = DB::select("
        SELECT 
            r.id, 
            r.name as nombre, 
            r.latitude_start, 
            r.longitude_start, 
            r.latitude_end, 
            r.longitude_end,
            r.status 
        FROM routes r
        ");


        if ($request->ajax()) {

            return DataTables::of($routes)
                ->addColumn('actions', function ($routes) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>                        
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item btnEditar" id="' . $routes->id . '"><i class="fas fa-edit"></i>  Editar</button>
                                <form action="' . route('admin.routes.destroy', $routes->id) . '" method="POST" class="frmEliminar d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </div>
                        </div>';
                })
                ->addColumn('status', function ($routes) {
                    return $routes->status == 1 ? '<div style="color: green"><i class="fas fa-check"></i> Activo</div>' : '<div style="color: red"><i class="fas fa-times"></i> Inactivo</div>';
                })
                ->addColumn('gps', function ($routes) {
                    return '<button class="btn btn-danger btn-sm btnMap" id=' . $routes->id . '><i class="fas fa-map-marked-alt"></i></button>';
                })
                ->rawColumns(['actions','status','gps'])  // Declarar columnas que contienen HTML
                ->make(true);
        } else {
            return view('admin.routes.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Obtener las rutas de la base de datos
        $routes = DB::select("
            SELECT 
                r.id, 
                r.name as nombre, 
                r.latitude_start as lat_start, 
                r.longitude_start as lng_start, 
                r.latitude_end as lat_end, 
                r.longitude_end as lng_end,
                r.status 
            FROM routes r
            WHERE r.id = ?
        ", [$id]);
    
        // Mapear las rutas a un formato de inicio y fin
        $points = collect($routes)->map(function ($route) {
            return [
                'id' => $route->id,
                'name' => $route->nombre,
                'start' => [
                    'lat' => $route->lat_start,
                    'lng' => $route->lng_start,
                ],
                'end' => [
                    'lat' => $route->lat_end,
                    'lng' => $route->lng_end,
                ],
            ];
        });
    
        // Pasar los puntos a la vista
        return view('admin.routes.show', compact('points'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
