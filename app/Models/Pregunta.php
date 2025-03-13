<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';
    protected $fillable = ['texto', 'categoria', 'estado'];

    // Relación uno-a-muchos con Respuesta
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'id_pregunta', 'id');
    }
}