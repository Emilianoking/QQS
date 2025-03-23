<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaUsuario extends Model
{
    use HasFactory;

    protected $table = 'respuestas_usuario';

    protected $fillable = ['id_usuario', 'id_pregunta', 'id_respuesta'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }

    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class, 'id_respuesta');
    }
}