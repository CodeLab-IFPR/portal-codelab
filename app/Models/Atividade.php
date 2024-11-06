<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;

    protected $fillable = ['data_inicio', 'data_final', 'horas_trabalhadas', 'link', 'tarefa_id'];

    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class);
    }
}
