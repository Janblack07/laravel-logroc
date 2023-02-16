<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\BoletoSala;
use App\Models\Cliente;
use App\Models\Pelicula;
use App\Models\SalaPelicula;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public $rulesCliente=array(
        'nombreC'=>'required|string|max:255|min:2|regex:/^[\pL\s]+$/u',
        'apellidoC'=>'required|max:255|min:2|regex:/^[\pL\s]+$/u',
        'cedulaC'=>'required|numeric|digits:10|unique:clientes',
        'correoC'=>'required|email|unique:clientes'
    );
    public $mensajesCliente=array(
        'nombreC.required' => 'Se requiere el nombre del cliente',
        'nombreC.regex' => 'Solo letras',
        'nombreC.max' => 'Excedio el maximo de caracteres',
        'nombreC.min' => 'El nombre tiene que tener minimo 2 caracteres',
        'apellidoC.required' => 'Se requiere el apellido del cliente',
        'apellidoC.regex' => 'Solo letras',
        'apellidoC.max' => 'Excedio el maximo de caracteres',
        'apellidoC.min' => 'El apellido tiene que tener minimo 2 caracteres',
        'cedulaC.required' => 'Se requiere la cedula del cliente',
        'cedulaC.numeric' => 'Solo se permite numero',
        'cedulaC.digits' => 'Solo se permite 10 numeros',
        'cedulaC.unique' => 'No debe de existir dos numeros de cedula iguales',
        'correoC.required' => 'Se requiere el correo electronico del cliente',
        'correoC.email' => 'Se requiere el correo electronico del cliente en formato email',
        'correoC.unique' => 'No debe de existir dos direcciones de correo electronico iguales',
    );
    public $rulesVenta=array(
        'sala_pelicula_id'=>'required',


    );
    public $mensajesVenta=array(
        'salapelicula_id.required' => 'Se requiere el id de salapelicula'


    );
    public function index()
    {
        //
        $venta = Venta::with('Usuario','Cliente','SalaPelicula',
        'SalaPelicula.Sala','SalaPelicula.Pelicula')->get();

        return response()->json([
            'Ventas'=>[$venta]
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator=Validator::make($request->all(),$this->rulesCliente,$this->mensajesCliente);
        if($validator -> fails()){
            $messages=$validator->getMessageBag();
            return response()->json([
                'messages'=>$messages
            ],500);
        }
        $usuario = auth()->user();
        $cliente = Cliente::create([
            'nombreC' => $request->nombreC,
            'apellidoC' => $request->apellidoC,
            'cedulaC' => $request->cedulaC,
            'correoC' => $request->correoC
        ]);
        $sala=SalaPelicula::find($request->sala_pelicula_id);
        $validator=Validator::make($request->all(),$this->rulesVenta,$this->mensajesVenta);
        if($validator -> fails()){
            $messages=$validator->getMessageBag();
            return response()->json([
                'messages'=>$messages
            ],500);
        }
        $ventas = Venta::create([
            'precioTotal' => $sala->Pelicula->precioP,
            'cliente_id' => $cliente->id,
            'usuario_id' => $usuario->id,
            'sala_pelicula_id' => $sala->id,
            'fechaV' =>  date('Y-m-d')
        ]);

        Boleto::create([
            "boletosala_id" => $request->asientos,
            "venta_id" => $ventas->id
        ]);
        $boleto=BoletoSala::find($request->asientos);
        $boleto->estado=false;
        $boleto->save();
        return response()->json([
            "message" => "boleto creado"
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $usuario = auth()->user();
        $usu = $usuario;
        $venta = Venta::find($id);
        $cli=$venta->Cliente;
        $sa = $venta->SalaPelicula->Sala;
        return response()->json([
            'Datos de Usuario' => $usu,
            'Datos de Cliente' => $cli,
            'Datos de la Sala' => $sa
        ]);


    }
    public function listado(){
        $boleto = Boleto::with('Venta','Venta.Cliente')->get();
        return response()->json([
            'Listado'=>$boleto
        ]);

    }
    public function ventaDiaria(){
      /*   $ventas = Venta::get();
        return response()->json([
            'VentasDiaria'=>$ventas
        ]); */
        $ventasMes = Venta::all()
                ->groupBy('fechaV')
                ->map(function ($ventasDia) {
                    return $ventasDia->reduce(function ($total, $venta) {
                        return $total + $venta['precioTotal'];
                    }, 0);
                })
                ->toArray();
                return response()->json([
                    'ventasMes'=>$ventasMes
                ]);
/* xd */
    }
    public function ventaDiariaUsuario(){
        $ventas = DB::table('ventas')
        ->join('usuarios','ventas.usuario_id','=','usuarios.id')
        ->select('fechaV','usuarios.nombreU','usuarios.apellidoU', DB::raw('SUM(precioTotal) as cantidad_total'))
                ->groupBy('fechaV','usuario_id','usuarios.nombreU','usuarios.apellidoU')
                ->get();
        return response()->json([
            'ventasMes'=>$ventas
        ]);
    }
}
