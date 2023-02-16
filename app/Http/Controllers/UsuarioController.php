<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public $rulesUsuario=array(
        'nombreU'=>'required|string|max:255|min:2|regex:/^[\pL\s]+$/u',
        'apellidoU'=>'required|max:255|min:2|regex:/^[\pL\s]+$/u',
        'cedulaU'=>'required|numeric|digits:10|unique:usuarios',
        'correoU'=>'required|email|unique:usuarios',
        'passwordU'=>'required|min:8',

    );
    public $mensajes=array(
        'nombreU.required' => 'Se requiere el nombre del Usuario.',
        'nombreU.regex' => 'Solo letras',
        'nombreU.max' => 'Excedio el maximo de caracteres',
        'nombreU.min' => 'El nombre tiene que tener minimo 2 caracteres',
        'apellidoU.required' => 'Se requiere el apellido del Usuario.',
        'apellidoU.regex' => 'Solo letras',
        'apellidoU.max' => 'Excedio el maximo de caracteres',
        'apellidoU.min' => 'El apellido tiene que tener minimo 2 caracteres',
        'cedulaU.required' => 'Se requiere la cedula del Usuario.',
        'cedulaU.numeric' => 'Solo se permite numero',
        'cedulaU.digits' => 'Solo se permite 10 numeros',
        'cedulaU.unique' => 'No debe de existir dos numeros de cedula iguales',
        'correoU.required' => 'Se requiere el correo electronico del usuario.',
        'correoU.email' => 'Se requiere el correo electronico del cliente en formato email',
        'correoU.unique' => 'No debe de existir dos direcciones de correo electronico iguales',
        'passwordU.required' => 'Se requiere una contraseña valida.',
        'passwordU.min' => 'Se requiere al menos 8 caracteres',

    );
    public function register(Request $request)
    {
        //
        $validator=Validator::make($request->all(),$this->rulesUsuario,$this->mensajes);
        if($validator -> fails()){
            $messages=$validator->getMessageBag();
            return response()->json([
                'messages'=>$messages
            ],500);
        }
       $usuario=new Usuario();
       $usuario->nombreU=$request->nombreU;
       $usuario->apellidoU=$request->apellidoU;
       $usuario->cedulaU=$request->cedulaU;
       $usuario->correoU=$request->correoU;
       $usuario->passwordU=Hash::make($request->passwordU);
       $usuario->rol_id=2;
       $usuario->save();

       return response()->json([
        'messages'=>"Registro exitoso"
    ]);
    }




    public function login(Request $request)
    {

        $usuario=Usuario::where("correoU", "=", $request->correoU)->first();

        if(isset($usuario->id)){
            if(Hash::check($request->passwordU, $usuario->passwordU)){
                $token = $usuario->createToken("auth_token")->plainTextToken;
                return response()->json([
                    'messages'=>"Usuario logueado correctamente",
                    "access_token"=>$token
                 ]);
            }else
                 return response()->json([
                    'messages'=>"Password incorrecta"
                 ],500);
        }else{
            return response()->json([
                'messages'=>"Usuario no registrado"
            ] ,500);
        }

    }

    public function userProfile()
    {
        return response()->json([
            'messages'=>"Acerca del perfil de usuario",
            'data'=>auth()->user(),
            'rol'=>auth()->user()->Rol->nombreRol

         ]);

    }


    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'messages'=>"Cierre de sesion",

         ]);
    }
}
