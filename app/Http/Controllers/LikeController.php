<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Like;

class LikeController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            'auth',
            new Middleware('auth'),
        ];
    }
    
    public function index() {
        //Recoger datos del usuario
        $user = \Auth::user();
        
        $likes = Like::where('user_id', $user->id)
                       ->orderBy('id', 'desc')
                       ->simplePaginate(5);
        
        return view('like.index', [
            'likes' => $likes,
        ]);
    }
    
    public function like($image_id) {
        //Recoger datos del usuario e imagen
        $user = \Auth::user();
        
        //Condición para no repetir likes
        $isset_like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->exists();
        if(!$isset_like){
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id; //Checando el var_dump la variable aparecia como string, por lo cual se casteó a int

            //Guardar
            $like->save();
            
            return response()->json([
                'like' => $like
            ]);
        }else{
            return response()->json([
                'message' => 'Like already exists.'
            ]);
        }
    }
    
    public function dislike($image_id) {
        //Recoger datos del usuario e imagen
        $user = \Auth::user();
        
        //Condición para no repetir likes
        $like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->first();
        if($like){
            //Eliminar
            $like->delete();
            
            return response()->json([
                'like' => $like,
                'message' => 'You have disliked.'
            ]);
        }else{
            return response()->json([
                'message' => 'The like does not exists.'
            ]);
        }
    }
}
