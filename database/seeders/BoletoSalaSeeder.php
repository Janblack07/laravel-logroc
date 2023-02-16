<?php

namespace Database\Seeders;

use App\Models\Boleto;
use App\Models\Cliente;
use App\Models\Pelicula;
use App\Models\Sala;
use App\Models\SalaPelicula;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Venta;

class BoletoSalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'nombreU'=>'jandry',
            'apellidoU'=>'zambrano',
            'cedulaU'=>'1314064601',
            'correoU'=>'admin@gmail.com',
            'passwordU'=>bcrypt('admin123'),
            'rol_id'=>1
        ]);
        Usuario::create([
            'nombreU'=>'jacob',
            'apellidoU'=>'chavez',
            'cedulaU'=>'1314064602',
            'correoU'=>'empleado@gmail.com',
            'passwordU'=>bcrypt('empleado123'),
            'rol_id'=>2
        ]);
        Pelicula::create([
            'nombreP'=>"asdasdas",
            'precioP'=>30,
            'url_imagenP'=>"http://t1.gstatic.com/licensed-image?q=tbn:ANd9GcRRv9ICxXjK-LVFv-lKRId6gB45BFoNCLsZ4dk7bZpYGblPLPG-9aYss0Z0wt2PmWDb",
            'id_imagenP'=>"123",
            'nombreGP'=>"asdsa",
            'duracionP'=>"21312",
            'estrenoP'=>"2023-11-11"
        ]);
        Sala::create([
            'numeroAsientos'=>30,
            'nombreS'=>"asdasd"
        ]);

    }
}
