<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_projeto');
    }
    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'users_projeto');
    }

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class);
    }
}

