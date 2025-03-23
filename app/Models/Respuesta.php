<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table = 'respuestas'; // Especificamos la tabla existente
    protected $fillable = ['id_pregunta', 'texto', 'valor'];

    // Relación muchos-a-uno con Pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }
}