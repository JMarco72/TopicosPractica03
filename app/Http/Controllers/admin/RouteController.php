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
                    return '<a href="' . route('admin.routes.show', $routes->id) . '" class="btn btn-danger btn-sm"><i class="fas fa-map-marked-alt"></i></a> ';
                })
                ->rawColumns(['actions', 'status', 'gps'])  // Declarar columnas que contienen HTML
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

        // Redirigir o devolver respuesta
        return redirect()->route('admin.routes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Obtener la ruta principal desde la base de datos
        $routes = DB::select("
            SELECT 
                r.id, 
                r.name AS nombre, 
                r.latitude_start AS lat_start, 
                r.longitude_start AS lng_start, 
                r.latitude_end AS lat_end, 
                r.longitude_end AS lng_end, 
                r.status 
            FROM routes r
            WHERE r.id = ?
        ", [$id]);

        // Verificar si se encontró la ruta
        if (empty($routes)) {
            abort(404, 'Ruta no encontrada');
        }

        // Mapear la ruta
        $route = [
            'id' => $routes[0]->id,
            'name' => $routes[0]->nombre,
            'lat_start' => $routes[0]->lat_start,
            'lng_start' => $routes[0]->lng_start,
            'lat_end' => $routes[0]->lat_end,
            'lng_end' => $routes[0]->lng_end,
        ];

        // Obtener las zonas relacionadas con la ruta
        $routezones = DB::select("
            SELECT 
                z.id AS zone_id,
                z.name AS zona, 
                z.area AS area 
            FROM routezones r2
            INNER JOIN zones z ON z.id = r2.zone_id
            WHERE r2.route_id = ?
        ", [$id]);

        // Pasar los datos a la vista
        return view('admin.routes.show', [
            'route' => $route,          // Información principal de la ruta
            'routezones' => $routezones // Zonas relacionadas
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Recupera la ruta de la base de datos (asumiendo que el modelo se llama "Route")
        $route = Route::findOrFail($id);

        // De ser necesario, puedes recuperar información adicional aquí (si tienes relaciones, por ejemplo)
        // Pasar los datos a la vista
        return view("admin.routes.edit", compact("route"));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                "name" => "unique:routes,name," . $id,
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

            return response()->json(['message' => 'Ruta actualizada correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en la actualización: ' . $th->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $routes = Route::find($id);
            $routes->delete();
            return response()->json(['message' => 'Vehículo eliminado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error la eliminación: ' . $th->getMessage()], 500);
        }
    }
}
