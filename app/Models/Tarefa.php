<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'status', 'projeto_id', 'membro_id'];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function membro()
    {
        return $this->belongsTo(Membro::class);
    }
    public function atividades()
    {
        return $this->hasMany(Atividade::class);
    }
}
