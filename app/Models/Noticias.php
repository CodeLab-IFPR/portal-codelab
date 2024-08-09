<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Noticias extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'autor',
        'conteudo',
        'imagem',
        'categoria',
        'alt',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($noticia) {
            $noticia->slug = Str::slug($noticia->titulo);
        });

        static::updating(function ($noticia) {
            $noticia->slug = Str::slug($noticia->titulo);
        });
    }
}
