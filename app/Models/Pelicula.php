<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table ='peliculas';
    protected $fillable =['nombreP','url_imagenP','id_imagenP','nombreGP','precioP','estrenoP','duracionP'];

    public function SalaPelicula(){
        return $this->hasMany(SalaPelicula::class);
    }
}
