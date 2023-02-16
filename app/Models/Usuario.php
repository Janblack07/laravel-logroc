<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;
    public $timestamps = false;
    protected $table = 'usuarios';
    protected $fillable=['nombreU','apellidoU','cedulaU','correoU','passwordU'];

    public function Venta(){
        return $this->hasMany(Venta::class);
    }

    public function Rol(){
        return $this->belongsTo(Rol::class);
    }
}
