<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='clientes';
    protected $fillable=['nombreC','apellidoC','cedulaC','correoC'];

    public function Venta(){
        return $this->hasMany(Venta::class);
    }
}
