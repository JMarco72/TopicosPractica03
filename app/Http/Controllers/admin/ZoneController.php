<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Sector;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\select;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $zones = DB::select('CALL sp_zones');

        if ($request->ajax()) {

            return DataTables::of($zones)

                ->addColumn('actions', function ($zones) {
                    return '
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>                        
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item btnEditar" id="' . $zones->id . '"><i class="fas fa-edit"></i>  Editar</button>
                            <form action="' . route('admin.zones.destroy', $zones->id) . '" method="POST" class="frmEliminar d-inline">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                            </form>
                        </div>
                    </div>';
                })
                ->rawColumns(['logo', 'actions'])  // Declarar columnas que contienen HTML
                ->make(true);
        } else {
            return view('admin.zones.index', compact('zones'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $district = District::pluck('name','id');
        $sector = Sector::pluck('name','id');

        return view('admin.zones.create', compact("district","sector"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Zone::create($request->all());
            return response()->json(['message' => 'Zona registrada'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al registrar la zona'], 500);
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
