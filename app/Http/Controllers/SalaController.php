<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaController extends Controller
{
    public $rulesSala=array(
        'numeroAsientos'=>'required|integer|min:2',
        'nombreS'=>'required|unique:salas'
    );
    public $mensajes=array(
        'numeroAsientos.required' => 'Se solicita el numero de asientos',
        'numeroAsientos.integer' => 'Se debe ingresar solo numeros enteros',
        'numeroAsientos.min' => 'Se debe colocar por sala minimo 2 asiento',
        'nombreS.required' => 'Se requiere el nombre de la sala',
        'nombreS.unique' => 'Se debe colocar nombres distintos de salas'


    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $salas = Sala::all();
        return response()->json([
            'Salas'=>$salas
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
        $validator=Validator::make($request->all(),$this->rulesSala,$this->mensajes);
        if($validator -> fails()){
            $messages=$validator->getMessageBag();
            return response()->json([
                'messages'=>$messages
            ],500);
        }
        $salas = Sala::create([
            'numeroAsientos'=>$request->numeroAsientos,
            'nombreS'=>$request->nombreS
        ]);
        return response()->json([
            'messages'=>'Se ingreso con exito'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $salas = sala::find($id);
        return response()->json([
            'Salas'=>$salas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $salas = Sala::find($id);
        $salas->update([
            'numeroAsientos'=>$request->numeroAsientos,
            'nombreS'=>$request->nombreS
        ]);
        return response()->json([
            'messages'=>'Se Modifico con exito'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $salas = sala::find($id)->delete();
        return response()->json([
            'messages'=>'Se Elimino con exito'
        ]);

    }
}
