<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicletype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class VehicletypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehicletypes = DB::select('select id, name, description from vehicletypes');

        if ($request->ajax()) {

            return DataTables::of($vehicletypes)

                ->addColumn('actions', function ($Vehicletype) {
                    return '
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>                        
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item btnEditar" id="' . $Vehicletype->id . '"><i class="fas fa-edit"></i>  Editar</button>
                            <form action="' . route('admin.vehicletypes.destroy', $Vehicletype->id) . '" method="POST" class="frmEliminar d-inline">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                            </form>
                        </div>
                    </div>';
                })
                ->make(true);
        } else {
            return view('admin.vehicletypes.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vehicletypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Vehicletype::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            return response()->json(['message' => 'Marca registra correctamente'], 200);
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
        $vehicletypes = Vehicletype::find($id);
        return view('admin.vehicletypes.edit', compact('vehicletypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $vehicletypes = Vehicletype::find($id);

            $vehicletypes->update([
                    'name' => $request->name,
                    'description' => $request->description
                ]);
            
            return response()->json(['message' => 'Marca actualizada correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error actualizar: ' . $th->getMessage()], 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $vehicletypes = Vehicletype::find($id);
            $vehicletypes->delete();

            return response()->json(['message' => 'Marca eliminada'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error de eliminación'], 500);
        }

    }
}
