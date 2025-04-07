<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'imagen'];

    // Relación con placas
    public function placas()
    {
        return $this->hasMany(Placa::class);
    }
}
