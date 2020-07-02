<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function config()
    {

        return view('user.config');
    }

    public function update(Request $request)
    {
        $user = \Auth::user();
        $id = $user->id;

        //validaciones
        $validate = $this->validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        //recogiendo datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        //asignando nuevos valores al objeto usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //Subir la imagen
        $image_path = $request->file('image_path');

        if ($image_path) {
            //poner nombre unico
            $image_path_name = time() . $image_path->getClientOriginalName();
            //guardar en la carpeta del storage (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            //settear el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        //ejecutar la consulta y cambios en la BD
        $user->update();

        return redirect()->route('config')->with(['message' => 'Usuario actualizado correctamente']);
    }

    public function getImage($fileName)
    {
        $file = Storage::disk('users')->get($fileName);

        return new Response($file, 200);
    }


    public function profile($id)
    {
        $user = User::find($id);

        return view('user.profile', [
            'user' => $user
        ]);
    }

    public function search($value = null)
    {
        if (!empty($value)) {
            $user = User::Where('nick','LIKE','%'.$value.'%')
            ->orWhere('name','LIKE', '%'.$value.'%') 
            ->orWhere('surname','LIKE', '%'.$value.'%')            
            ->OrderBy('id', 'desc')
            ->paginate(5);
        } else {
            $user = User::OrderBy('id', 'desc')->paginate(5);
        }


        return view('user.search', [
            'users' => $user
        ]);
    }
}
