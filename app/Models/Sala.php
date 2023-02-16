<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table ='salas';
    protected $fillable=['numeroAsientos','nombreS'];

    public function SalaPelicula(){
        return $this->hasMany(SalaPelicula::class);
    }
}
