<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ventas';
    protected $fillable = ['fechaV','sala_pelicula_id','precioTotal','usuario_id','cliente_id'];

    public function SalaPelicula(){
        return $this->belongsTo(SalaPelicula::class);
    }

    public function Usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function Cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function Boleto(){
        return $this->hasMany(Boleto::class);
    }

}
