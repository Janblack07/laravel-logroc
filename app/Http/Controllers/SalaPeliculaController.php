<?php

namespace App\Http\Controllers;

use App\Models\BoletoSala;
use App\Models\SalaPelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SalaPeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $rulesSalaPelicula=array(
        'fecha'=>'required|date',
        'horaI'=>'required|min:1|max:100000',
        'horaF'=>'required|min:1|max:100000|after:horaI',
        'sala_id'=>'required',
        'pelicula_id'=>'required',


    );
    public $mensajesSalaPelicula=array(
        'fecha.required' => 'Se requiere una fecha.',
        'fecha.date' => 'Se requiere una fecha valida.',
        'horaI.required' => 'Se requiere la hora de inicio',
        'horaI.min' => 'minimo 1 segundo.',
        'horaI.max' => 'maximo 10 horas.',
        'horaF.required' => 'Se requiere la hora Fin',
        'horaF.min' => 'minimo 1 segundo.',
        'horaF.max' => 'maximo 10 horas.',
        'horaF.after' => 'Se requiere que sea una hora mayor que la de inicio.',
        'sala_id.required' => 'Se requiere el id de la sala',

        'pelicula_id.required' => 'Se requiere el id de la pelicula',
    );

    public function index()
    {
        $salaPelicula = SalaPelicula::with('Pelicula','Sala')->get();
        return response()->json([
            'SalaPelicula'=>$salaPelicula
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
        $validator=Validator::make($request->all(),$this->rulesSalaPelicula,$this->mensajesSalaPelicula);
        if($validator -> fails()){
            $messages=$validator->getMessageBag();
            return response()->json([
                'messages'=>$messages
            ],500);
        }
        $salaPelicula = SalaPelicula::create([
            'fecha'=>$request->fecha,
            'horaI'=>$request->horaI,
            'horaF'=>$request->horaF,
            'sala_id'=>$request->sala_id,
            'pelicula_id'=>$request->pelicula_id
        ]);


        $asientos = $salaPelicula->Sala->numeroAsientos;
        //esta parte es mia
        for( $i = 1;$i<=$asientos;$i++){

            BoletoSala::create([
                'numeroAsientos'=>$i,
                'sala_pelicula_id'=>$salaPelicula->id,
                'estado'=>1
            ]);
        }
        return response()->json([
            'message'=>'SalaPelicula creada'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalaPelicula  $salaPelicula
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $salapelicula = SalaPelicula::with('Pelicula','Sala','BoletoSala')->where('id','=',$id)->first();
        return response()->json([
            'SalaPelicula'=>$salapelicula
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalaPelicula  $salaPelicula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalaPelicula $salaPelicula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalaPelicula  $salaPelicula
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalaPelicula $salaPelicula)
    {
        //
    }
}
