<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request)
    {

        $validate = $this->validate($request, [
            'image-id' => 'integer|required',
            'content' => 'string|required'
        ]);

            $user = \Auth::user()->id;
            $image_id = $request->input('image-id');
            $contenido = $request->input('content');

            $comment = new Comment();
            $comment->user_id = $user;
            $comment->image_id = $image_id;
            $comment->content = $contenido;

            $comment->save();

            

            return redirect()->route('image.detail',['id' => $image_id])
                            ->with(['message' => 'comentario publicado']);
    }

    public function delete($id)
    {
        //conseguir datos del usuario identificado
        $user = \Auth::user();


        //conseguir objeto del comentario
        $comment = Comment::find($id);

        //comprobar si soy el dueño del comentario o publicacion

        if ($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)) {
            $comment->delete();

            return redirect()->route('image.detail',['id' => $comment->image->id])
            ->with(['message' => 'comentario eliminado']);
        }else {
            return redirect()->route('image.detail',['id' => $comment->image->id])
            ->with(['message' => 'comentario no se ha eliminado']);
        }
    }
}
