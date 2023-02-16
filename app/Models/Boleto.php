<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
    use HasFactory;

   public $timestamps = false;
   protected $table = 'boletos';
   protected $fillable = ['boletosala_id','venta_id'];

   public function Venta(){
       return $this->belongsTo(Venta::class);
   }
   public function BoletoSala(){
       return $this->belongsTo(BoletoSala::class);
   }
}
