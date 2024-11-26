<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleOccupant extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'vehicleoccupants';

    // Permitir asignación masiva
    protected $guarded = [];

    // Relación con el modelo Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
