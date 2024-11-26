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
        if ($request->ajax()) {
            $routes = Route::select('id', 'name as nombre', 'status')
                ->get();

            return DataTables::of($routes)
                ->addColumn('actions', function ($route) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>                        
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item btnEditar" id="' . $route->id . '"><i class="fas fa-edit"></i> Editar</button>
                                <form action="' . route('admin.routes.destroy', $route->id) . '" method="POST" class="frmEliminar d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </div>
                        </div>';
                })
                ->addColumn('status', function ($route) {
                    return $route->status == 1 ? '<div style="color: green"><i class="fas fa-check"></i> Activo</div>' : '<div style="color: red"><i class="fas fa-times"></i> Inactivo</div>';
                })
                ->addColumn('gps', function ($route) {
                    return '<a href="' . route('admin.routes.show', $route->id) . '" class="btn btn-danger btn-sm"><i class="fas fa-map-marked-alt"></i></a>';
                })
                ->rawColumns(['actions', 'status', 'gps'])
                ->make(true);
        }

        return view('admin.routes.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.routes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude_start' => 'required|numeric',
            'longitude_start' => 'required|numeric',
            'latitude_end' => 'required|numeric',
            'longitude_end' => 'required|numeric',
            'status' => 'nullable|boolean',
        ]);

        // Crear una nueva ruta
        Route::create([
            'name' => $request->name,
            'latitude_start' => $request->latitude_start,
            'longitude_start' => $request->longitude_start,
            'latitude_end' => $request->latitude_end,
            'longitude_end' => $request->longitude_end,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.routes.index')->with('success', 'Ruta creada exitosamente');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $route = Route::findOrFail($id);

        $routezones = DB::select("
        SELECT 
            z.id AS zone_id,
            z.name AS zona, 
            z.area AS area 
        FROM routezones r2
        INNER JOIN zones z ON z.id = r2.zone_id
        WHERE r2.route_id = ?
    ", [$id]);

        $zonesMap = DB::table('zones')
            ->leftJoin('zonecoords', 'zones.id', '=', 'zonecoords.zone_id')
            ->whereIn('zones.id', function ($query) use ($id) {
                $query->select('zone_id')
                    ->from('routezones')
                    ->where('route_id', $id);
            })
            ->select('zones.name as zone', 'zonecoords.latitude', 'zonecoords.longitude')
            ->get();

        // Agrupa las coordenadas por zona
        $groupedZones = $zonesMap->groupBy('zone');

        $perimeter = $groupedZones->map(function ($zone) {
            $coords = $zone->map(function ($item) {
                return [
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                ];
            })->toArray();

            return [
                'name' => $zone[0]->zone,
                'coords' => $coords,
            ];
        })->values();

        return view('admin.routes.show', compact('route', 'routezones', 'perimeter'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Recupera la ruta de la base de datos
        $route = Route::findOrFail($id);
        return view("admin.routes.edit", compact("route"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos del formulario
        $request->validate([
            "name" => "required|unique:routes,name," . $id,
            "latitude_start" => "required|numeric",
            "longitude_start" => "required|numeric",
            "latitude_end" => "required|numeric",
            "longitude_end" => "required|numeric",
        ]);

        // Obtener la ruta que vamos a actualizar
        $route = Route::findOrFail($id);

        // Actualizar los datos de la ruta
        $route->update([
            'name' => $request->name,
            'latitude_start' => $request->latitude_start,
            'longitude_start' => $request->longitude_start,
            'latitude_end' => $request->latitude_end,
            'longitude_end' => $request->longitude_end,
            'status' => $request->has('status') ? 1 : 0, // Verificar el estado
        ]);

        return redirect()->route('admin.routes.index')->with('success', 'Ruta actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $route = Route::findOrFail($id);
            $route->delete();
            return response()->json(['message' => 'Ruta eliminada correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en la eliminación: ' . $th->getMessage()], 500);
        }
    }
}
