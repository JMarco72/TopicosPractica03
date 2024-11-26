<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Routezone;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RoutezoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($route_id)
    {
        $route = Route::find($route_id); // Obtén la ruta por ID
        $zones = Zone::all()->pluck('name', 'id'); // Asumiendo que tienes un modelo `Zone`

        return view('admin.routezones.create', compact('route', 'zones'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'route_id' => 'required|exists:routes,id',
                'zone_id' => 'required|exists:zones,id',
            ]);

            Routezone::create([
                'route_id' => $validated['route_id'],
                'zone_id' => $validated['zone_id'],
            ]);

            return response()->json(['message' => 'Zona agregada correctamente']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al agregar la zona', 'error' => $th->getMessage()], 500);
        }
    }


    public function show(Request $request, string $id)
    {
        // Obtener las zonas relacionadas con la ruta usando el id correcto
        $routezones = DB::select("
            SELECT 
                rz.id AS routezone_id,
                z.name AS zone_name
            FROM routes r 
            INNER JOIN routezones rz ON r.id = rz.route_id 
            INNER JOIN zones z ON z.id = rz.zone_id 
            WHERE r.id = ?
        ", [$id]);

        if ($request->ajax()) {
            return DataTables::of($routezones)
                ->addColumn('actions', function ($routezone) {
                    // Formulario para eliminar la relación entre la ruta y la zona
                    return '      
                        <form action="' . route('admin.routezones.destroy', $routezone->routezone_id) . '" method="POST" class="frmEliminar d-inline">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        // Pasar 'perimeter' a la vista
        return view('admin.routezones.show', compact('routezones'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

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
    public function destroy($id)
    {
        try {
            // Busca la relación por la clave primaria de Routezone
            $rz = Routezone::find($id);

            if (!$rz) {
                // Si no la encuentra, lanza error.
                return response()->json(['message' => 'Routezone no encontrada'], 404);
            }

            // Elimina la zona de la ruta
            $rz->delete();

            return response()->json(['message' => 'Zona eliminada correctamente de la ruta'], 200);
        } catch (\Throwable $th) {
            // Captura el error y muestra el mensaje.
            return response()->json(['message' => 'Error en la eliminación: ' . $th->getMessage()], 500);
        }
    }
}
