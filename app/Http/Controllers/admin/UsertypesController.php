<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Usertype;
use Illuminate\Http\Request;

class UsertypesController extends Controller
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
    public function destroy(Usertype $usertype)
    {
        if ($usertype->isProtected()) {
            return response()->json([
                'message' => 'Este tipo de usuario es parte del sistema y no puede ser eliminado.'
            ], 403);
        }
    
        $usertype->delete();
        return response()->json(['message' => 'Tipo de usuario eliminado con éxito']);
    }


//     @if(!$usertype->isProtected())
//     <button onclick="deleteUsertype({{ $usertype->id }})">Eliminar</button>
// @endif
    
}
