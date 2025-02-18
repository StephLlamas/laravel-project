<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;
use App\Models\Comment;

class CommentController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            'auth',
            new Middleware('auth'),
        ];
    }
    
    public function save(Request $request) {
        //Conseguir usuario identificado
        $user = \Auth::user();
        
        //Validación del formulario
        $validate = $request->validate([
            'image_id' => ['required', 'integer'],
            'content' => ['required', 'string'],
        ]);
        
        //Recoger datos del formulario
        $image_id = $request->input('image_id');
        $content = $request->input('content');
        
        //Asignar valores a nuevo objeto
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        
        //Guardar
        $comment->save();
        
        //Redirección
        return redirect()->route('image.detail', ['id' => $image_id])
                         ->with(['message' => 'Comment successfully published.']);
    }
    
    public function delete($id) {
        //Conseguir usuario identificado
        $user = \Auth::user();
        
        //Conseguir objeto del comentario
        $comment = Comment::find($id);
        
        //Comprobar autoría del comentario o publicación
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();
            
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                         ->with(['message' => 'Comment successfully deleted.']);
        } else {
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                         ->with(['message' => 'Comment could not be deleted.']);
        }
    }
}
