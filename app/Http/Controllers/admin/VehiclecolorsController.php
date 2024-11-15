<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Vehiclecolor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VehiclecolorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Usamos Eloquent para obtener los datos del modelo `VehicleColor`
        $vehiclecolors = Vehiclecolor::select('id', 'name', 'red', 'green', 'blue', 'description')->get();

        if ($request->ajax()) {
            return DataTables::of($vehiclecolors)
                ->addColumn('color_code', function ($color) {
                    // Genera el código RGB en formato "rgb(r, g, b)"
                    return 'rgb(' . $color->red . ', ' . $color->green . ', ' . $color->blue . ')';
                })
                ->addColumn('actions', function ($color) {
                    // Genera el código HTML para los botones de acción directamente
                    return '
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton-' . $color->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $color->id . '">
                                <button class="dropdown-item btnEditar" id="' . $color->id . '">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <form action="' . route('admin.vehiclecolors.destroy', $color->id) . '" method="POST" class="frmEliminar" style="display:inline;">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>';
                })
                ->rawColumns(['color_code', 'actions'])
                ->make(true);
        }

        return view('admin.vehiclecolors.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vehiclecolors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'name' => 'required|string|max:100',
            'red' => 'required|integer|between:0,255',   // Validación para el valor de rojo
            'green' => 'required|integer|between:0,255', // Validación para el valor de verde
            'blue' => 'required|integer|between:0,255',  // Validación para el valor de azul
            'description' => 'nullable|string|max:255',
        ]);

        try {
            Vehiclecolor::create([
                'name' => $request->name,
                'red' => $request->red,
                'green' => $request->green,
                'blue' => $request->blue,
                'description' => $request->description,
            ]);

            return response()->json(['message' => 'Color registrado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en el registro: ' . $th->getMessage()], 500);
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
        $vehiclecolors = Vehiclecolor::find($id);
        return view('admin.vehiclecolors.edit', compact('vehiclecolors'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validación de los datos de entrada
        $request->validate([
            'name' => 'required|string|max:100',
            'red' => 'required|integer|between:0,255',   // Validación para el valor de rojo
            'green' => 'required|integer|between:0,255', // Validación para el valor de verde
            'blue' => 'required|integer|between:0,255',  // Validación para el valor de azul
            'description' => 'nullable|string|max:255',
        ]);

        try {
            $vehiclecolors = Vehiclecolor::findOrFail($id); // Utiliza findOrFail para manejar el caso de no encontrar el registro

            $vehiclecolors->update([
                'name' => $request->name,
                'red' => $request->red,
                'green' => $request->green,
                'blue' => $request->blue,
                'description' => $request->description,
            ]);

            return response()->json(['message' => 'Color actualizado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al actualizar: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $vehiclecolors = Vehiclecolor::findOrFail($id); // Utiliza findOrFail para manejar el caso de no encontrar el registro
            $vehiclecolors->delete();

            return response()->json(['message' => 'Color eliminado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error de eliminación: ' . $th->getMessage()], 500);
        }
    }
}
