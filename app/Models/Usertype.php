<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usertype extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // IDs protegidos que corresponden a los tipos de usuario base
    private static $protectedIds = [1, 2, 3, 4];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($usertype) {
            if (in_array($usertype->id, self::$protectedIds)) {
                throw new \Exception('Este tipo de usuario es parte del sistema y no puede ser eliminado.');
            }
        });
    }

    // Método helper para verificar si un usertype está protegido
    public function isProtected()
    {
        return in_array($this->id, self::$protectedIds);
    }

    public static function isProtectedId($id)
    {
        return in_array($id, self::$protectedIds);
    }
}
