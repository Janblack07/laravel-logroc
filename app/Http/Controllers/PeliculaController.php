<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PeliculaController extends Controller
{
    public $rulesPelicula=array(
        'nombreP' => 'required|unique:peliculas',
        'nombreGP' => 'required',
        'imagenP' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'precioP' => 'required|numeric|min:1',
        'duracionP' => 'required|min:1|max:100000',
        'estrenoP' => 'required|date|after:yesterday'
);
    public $mensajes=array(
        'nombreP.required' => 'El nombre de la pelicula ses requerido',
        'nombreP.unique' => 'El nombre de la pelicula ya esta en uso',
        'nombreGP.required' => 'Se requiere el genero de la pelicula',
        'precioP.required' => 'Se requiere el precio de la pelicula',
        'precioP.numeric' => 'Solo numeros',
        'precioP.min'=>'Minimo 1 centavo',
        'imagenP.required' => 'Se requiere una imagen',
        'imagenP.image' => 'Solo se permite imagenes',
        'imagenP.mimes' => 'Tipo de imagen no valido',
        'duracionP.required'=>'Se requiere la duracion de la pelicula',
        'duracionP.min'=>'El minimo es de 1 segundo',
        'duracionP.max'=>'EL maximo es de 10 horas',
        'estrenoP.required'=>'Se requiere la estreno de la pelicula',
        'estrenoP.date'=>'Se requiere una fecha valida',
        'estrenoP.after'=>'No se puede colocar fecha anterior',

    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $peliculas =Pelicula::all();
        return response()->json([
            'Peliculas'=>$peliculas
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
        $validator=Validator::make($request->all(),$this->rulesPelicula,$this->mensajes);
        if($validator -> fails()){
            $messages=$validator->getMessageBag();
            return response()->json([
                'messages'=>$messages
            ],500);
        }
          $file = request()->file('imagenP');
              $obj = Cloudinary::upload($file->getRealPath(),['folder'=>'peliculas']);
              $public_id = $obj->getPublicId();
              $url = $obj->getSecurePath();

              Pelicula::create([

                'nombreP'=>$request->nombreP,
                'precioP'=>$request->precioP,
                'url_imagenP'=>$url,
                'id_imagenP'=>$public_id,
                'nombreGP'=>$request->nombreGP,
                'duracionP'=>$request->duracionP,
                'estrenoP'=>$request->estrenoP

              ]);

        return response()->json([
            'messages'=>"Se creo  correctamente"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelicula  $pelicula
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $peliculas = Pelicula::find($id);
        return response()->json([
            'Peliculas'=>$peliculas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelicula  $pelicula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $peliculas = Pelicula::findOrFail($id);
        $url = $peliculas->url_imagenP;
        $public_id = $peliculas->id_imagenP;

        if($request->hasFile('imagenP')){
            Cloudinary::destroy($public_id);
            $file = request()->file('imagenP');
            $obj = Cloudinary::upload($file->getRealPath(),['folder'=>'peliculas']);
            $url = $obj->getSecurePath();
            $public_id = $obj->getPublicId();
        }

        $peliculas->update([
                'nombreP'=>$request->nombreP,
                'precioP'=>$request->precioP,
                'url_imagenP'=>$url,
                'id_imagenP'=>$public_id,
                'nombreGP'=>$request->nombreGP,
                'duracionP'=>$request->duracionP,
                'estrenoP'=>$request->estrenoP
        ]);

        return response()->json([
            'messages'=>"Se actualizo correctamente"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelicula  $pelicula
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $peliculas = Pelicula::find($id);
        $public_id = $peliculas->id_imagenP;
        Cloudinary::destroy($public_id);
        Pelicula::destroy($id);

        return response()->json([
            'messages'=>"Se elimino correctamente"
        ]);
    }
}
