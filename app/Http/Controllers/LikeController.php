<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function like($image_id){
        //recorger datos del usuario y el id de la imagen

        $user = \Auth::user();

        //ver si ya le di like y no duplicar

        $issetLike = Like::where('user_id', $user->id)
                        ->where('image_id', $image_id)
                        ->count();

        if($issetLike == 0){
            $like = new Like();
            $like->user_id = (int)$user->id;
            $like->image_id = (int)$image_id;

            $like->save();

            return response()->json([
                'like' => $like
            ]);
        }else{
            return response()->json([
                'message' => 'ya diste like'
            ]);
        }

    }

    public function dislike($image_id){
        $user = \Auth::user();

        $like = Like::where('user_id',$user->id)->where('image_id',$image_id)->first();

        if ($like) {
            $like->delete();

            return response()->json([
                'like' => $like,
                'message' => 'quitaste el like'
            ]);
        }else{
            return response()->json([
                'message' => 'ya no existe el like'
            ]);
        }
    }

    public function likes()
    {
        $user = \Auth::user();
        $likes = Like::where('user_id',$user->id)->OrderBy('id', 'desc')->paginate(5);

        return view('like.likes',[
            'likes' => $likes
        ]);
    }
}
