<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LancamentoServico extends Model
{
    protected $fillable = ['projeto_id', 'servico_id', 'data_inicio', 'data_final', 'horas_trabalhadas', 'link'];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
}
