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
        if ($request->ajax()) {
            $colors = Vehiclecolor::all();
            return DataTables::of($colors)
                ->addColumn('edit', function ($row) {
                    return '<button class="btn btn-primary btnEditar" id="' . $row->id . '"><i class="fa fa-edit"></i></button>';
                })
                ->addColumn('delete', function ($row) {
                    return '<form action="' . route('admin.vehiclecolors.destroy', $row->id) . '" method="POST" class="fmrEliminar">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </form>';
                })
                ->rawColumns(['edit', 'delete'])
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
        $vehiclecolor = Vehiclecolor::findOrFail($id);

        // Convertir valores RGB a formato HEX para el input de color
        $vehiclecolor->color_code = sprintf("#%02x%02x%02x", $vehiclecolor->red, $vehiclecolor->green, $vehiclecolor->blue);
    
        return view('admin.vehiclecolors.edit', compact('vehiclecolor'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'red' => 'required|integer|between:0,255',
            'green' => 'required|integer|between:0,255',
            'blue' => 'required|integer|between:0,255',
            'description' => 'nullable|string|max:255',
        ]);
    
        try {
            $vehiclecolor = Vehiclecolor::findOrFail($id);
    
            // Actualizar únicamente los campos necesarios
            $vehiclecolor->update([
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
