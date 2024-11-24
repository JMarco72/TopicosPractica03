<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicleroutes extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function programming()
    {
        return $this->belongsTo(Programming::class, 'programming_id');
    }
}
