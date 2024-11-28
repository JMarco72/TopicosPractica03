<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Activitie;
use App\Models\Horarie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = session('horarie_id');
        $hor = Horarie::find($id);


        $actions = DB::select('SELECT AC.id, AC.date, AC.description 
        FROM actions AC
        INNER JOIN horaries H ON AC.horarie_id=H.id
        WHERE AC.horarie_id= ?', [$id]);

        return view('admin.actions.index', compact('hor', 'actions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.actions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request['horarie_id'] = session('horarie_id');
    //     Action::create($request->all());
    //     return redirect()->route('admin.actions.index')->with('success', 'Actividad registrada');
    // }

    public function store(Request $request)
    {
        $request['horarie_id'] = session('horarie_id');
        $horarie = Horarie::find($request['horarie_id']);
        $activitie = Activitie::find($horarie->activitie_id);

        // Validar que la fecha de la acción esté dentro del rango de fechas de la actividad
        if ($request->date < $activitie->startdate || $request->date > $activitie->lastdate) {
            return redirect()->route('admin.actions.index')->with('error', 'La fecha de la acción debe estar dentro del rango de fechas del mantenimiento (' . $activitie->startdate . ' a ' . $activitie->lastdate . ')');
        }

        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        Action::create($request->all());
        return redirect()->route('admin.actions.index')->with('success', 'Actividad registrada');
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
        $act = Action::find($id);
        return view('admin.actions.edit', compact('act'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $request['horarie_id'] = session('horarie_id');
    //     $actions = Action::find($id);
    //     $actions->update($request->all());
    //     return redirect()->route('admin.actions.index')->with('success', 'Actividad actualizada');

    // }

    public function update(Request $request, string $id)
    {
        $request['horarie_id'] = session('horarie_id');
        $horarie = Horarie::find($request['horarie_id']);
        $activitie = Activitie::find($horarie->activitie_id);

        // Validar que la fecha de la acción esté dentro del rango de fechas de la actividad
        if ($request->date < $activitie->startdate || $request->date > $activitie->lastdate) {
            return redirect()->route('admin.actions.index')->with('error', 'La fecha de la acción debe estar dentro del rango de fechas del mantenimiento (' . $activitie->startdate . ' a ' . $activitie->lastdate . ')');
        }

        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        $actions = Action::find($id);
        $actions->update($request->all());
        return redirect()->route('admin.actions.index')->with('success', 'Actividad actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $actions = Action::find($id);
        $actions->delete();

        return redirect()->route('admin.actions.index')->with('success', 'Actividad elimina.');
    }
}
