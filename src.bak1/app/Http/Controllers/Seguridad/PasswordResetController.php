<?php

namespace App\Http\Controllers\Seguridad;

use App\Models\Seguridad\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    //region forgot_pass
    public function showEmailForm()
    {
        return view('modulos.seguridad.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $usuario = Usuario::where('usuarioEmail', $request->email)->first();

        if (!$usuario) {
            return redirect()->back()->withErrors(['email' => 'El correo ingresado no se encuentra en la base de datos.']);
        }

        $token = "1234";
        //$token = Str::random(60);
        //TODO Guardar token de reseteo
        //$usuario->reset_token = $token;
        //$usuario->save();

        //TODO Envío de correo con token de reseteo
        /*
        Mail::send('emails.password_reset', ['token' => $token, 'usuario' => $usuario], function ($message) use ($usuario) {
            $message->to($usuario->usuarioEmail);
            $message->subject('Restablecer contraseña');
        });
        */

        //return redirect()->back()->with('status', 'Se ha enviado un enlace de restablecimiento a su correo electrónico.');
        return redirect()->route('password.token.form', ['token' => $token,'email'=>$request->email]);
    }
    //endregion forgot_pass
    


    public function showTokenForm(Request $request)
    {
        $email = $request->email;
        return view('modulos.seguridad.auth.passwords.token', ['email' => $email]);
    }

    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => 'required|digits:4',
            'email' => 'required|email',
        ]);

        $token = $request->input('token');
        $email = $request->input('email');

        $usuario = Usuario::where('usuarioEmail', $email)->first();

        if (!$usuario) {
            return redirect()->back()->withErrors(['email' => 'El correo electrónico no se encuentra en la base de datos.']);
        }

        // TODO Validacion contra base de datos, pero como es contante se valida contra la cte
        if ($token != "1234") {
            return redirect()->back()->withErrors(['token' => 'El código ingresado es incorrecto.']);
        }

        return redirect()->route('password.update.form', ['email' =>  $email]);
    }

    public function showUpdatePass(Request $request)
    {
        return view('modulos.seguridad.auth.passwords.reset', ['email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $usuario = Usuario::where('usuarioEmail', $request->email)->first();

        //TODO en caso se tenga el reset token
        /*if (!$usuario || $usuario->reset_token !== $request->token) {
            return redirect()->back()->withErrors(['email' => 'Token inválido.']);
        }*/

        $usuario->usuarioPassword = md5($request->password);
        //TODO $usuario->reset_token = null; // Limpia el token
        $usuario->save();

        return redirect('/seguridad/auth/login')->with('status', 'Contraseña Restablecida.');
    }
}