<?php

namespace App\Http\Controllers\Seguridad;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Seguridad\Usuario;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{

    public function catalogo()
    {
        $usuarios = Usuario::all(); // Obtén todos los usuarios
        return view("modulos.seguridad.usuario.catalogo",compact('usuarios'));
    }


    public function detalle($id)
    {
        $usuario = Usuario::find($id); 
        return view('modulos.seguridad.usuario.detalle', compact('usuario'));
    }

    public function adjuntarFotoForm($id)
    {
        $usuario = Usuario::find($id);
        return view('modulos.seguridad.usuario.adjuntar_foto', compact('usuario'));
    }

    public function adjuntarFoto(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $usuario = Usuario::find($id);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreFoto = time() . '.' . $foto->getClientOriginalExtension();
            $ruta = $foto->storeAs('fotos_usuarios', $nombreFoto, 'public');

            Session::flash('success', 'Foto adjuntada correctamente.');
            return redirect()->route('usuarios.adjuntarFotoForm', $usuario->idUsuario);
        }
        else{
            Session::flash('error', 'Solo se permiten imágenes .jpg, .jpeg o .png');
            return redirect()->route('usuarios.adjuntarFotoForm', $usuario->idUsuario);
        }
    }
}
