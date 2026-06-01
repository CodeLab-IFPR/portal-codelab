<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ParametroEnum; 
class FraseInicio extends Model
{
    use HasFactory;

    protected $table = 'frase_inicio';

    protected $fillable = ['id', 'frase'];
    
    public $incrementing = false;

    public static function getParametro(int $parametro): ?string
    {
        return self::where('id', $parametro)->value('frase');
    }
}