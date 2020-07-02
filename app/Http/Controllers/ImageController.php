<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

use App\Image;
use App\Comment;
use App\Like;

class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('image.create');
    }

    public function save(Request $request)
    {
        //validacion
        $validate = $this->validate($request, [
            'desc' => 'required',
            'image_path' => 'required|image'
        ]);

        //recoger los datos
        $desc = $request->input('desc');
        $image_path = $request->file('image_path');

        //asignar los valores al nuevo objeto
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->image_path = null;
        $image->description = $desc;

        //subir la imagen
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')->with([
            'message' => 'foto subida correctamente'
        ]);
    }

    public function getImage($fileName)
    {
        //seleccionar el disco donde esta la imagen
        $file = Storage::disk('images')->get($fileName);

        return new Response($file, 200);
    }

    public function details($id)
    {
        $image = Image::find($id);

        return view('image.detail', [
            'imagen' => $image
        ]);
    }

    public function deleteImage($id)
    {
        $user = \Auth::user();
        $image = Image::find($id);
        $comment = Comment::where('image_id', $id)->get();
        $like = Like::where('image_id', $id)->get();

        if ($user && $image && $image->user->id == $user->id) {
            //eliminar comentarios
            if ($comment && count($comment) >= 1) {
                foreach ($comment as $comments) {
                    $comments->delete();
                }
            }

            //eliminar likes 

            if ($like && count($like) >= 1) {
                foreach ($like as $likes) {
                    $likes->delete();
                }
            }

            //eliminar fichero de imagen

            Storage::disk('images')->delete($image->image_path);

            //eliminar registro e la imagen

            $image->delete();

            $message = array(
                'message' => 'borrado correcto'
            );

            return redirect()->route('home')->with($message);

        }else{
                $message = array(
                    'message' => 'error al borrar'
                );
        }   
     }


     public function edit($id)
     {
         $user = \Auth::user();
         $imagen = Image::find($id);

         if ($user && $imagen && $user->id == $imagen->user->id) {
             return view('image.edit',[
                 'image' => $imagen
             ]);
         }
         else{
             return redirect()->route('home');
         }
     }


     public function update(Request $request)
     {
        $validate = $this->validate($request,[
            'desc' => 'required',
            'image_path' => 'image'
        ]);

         $image_id = (int)$request->input('image_id');
         $image_path = $request->file('image_path');
         $description = $request->input('desc');

         //conseguir el objeto image
         $image = Image::find($image_id);
         $image->description = $description;

         //subir la imagen
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        //actulizar registro

        $image->update();

        return redirect()->route('image.detail',['id' => $image_id])->with(['message' => 'Se actualizo correctamente']);
             }
}
