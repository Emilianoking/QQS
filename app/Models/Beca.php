<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beca extends Model
{
    protected $fillable = ['nombre', 'entidad', 'descripcion', 'requisitos', 'estado'];
}