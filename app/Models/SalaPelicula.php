<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaPelicula extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='sala_peliculas';
    protected $fillable =['fecha','horaI','horaF','sala_id','pelicula_id'];

    public function Pelicula(){
        return $this->belongsTo(Pelicula::class);
    }
    public function Sala(){
        return $this->belongsTo(Sala::class);
    }
    public function Venta(){
        return $this->HasMany(Venta::class);
    }
    public function BoletoSala(){
        return $this->HasMany(BoletoSala::class);
    }

}
