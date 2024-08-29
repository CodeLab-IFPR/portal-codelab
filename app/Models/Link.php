<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['link', 'membro_id'];

    public function membro()
    {
        return $this->belongsTo(Membro::class);
    }
}
