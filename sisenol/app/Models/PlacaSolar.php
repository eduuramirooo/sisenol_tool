<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Placa extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id', 'tipo_panel', 'potencia', 'peso', 'fecha_instalacion'];

    // Relación con producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}


