<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoletoSala extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'boleto_salas';
    protected $fillable = ['numeroAsientos','sala_pelicula_id','estado'];

    public function SalaPelicula(){
        return $this->belongsTo(SalaPelicula::class);
    }
    public function Boleto(){
        return $this->hasMany(Boleto::class);
    }
}
