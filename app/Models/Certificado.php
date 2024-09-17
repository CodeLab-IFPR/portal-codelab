<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $fillable = ['membros_id', 'token', 'descricao', 'horas', 'data'];

    public function membro()
    {
        return $this->belongsTo(Membro::class, 'membros_id');
    }
}