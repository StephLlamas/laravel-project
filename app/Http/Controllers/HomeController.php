<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Image;

class HomeController extends Controller implements HasMiddleware
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public static function middleware(): array {
        return [
            'auth',
            new Middleware('auth'),
        ];
    }
    
    public function index(){
        $images = Image::orderBy('id', 'desc')->simplePaginate(5);
        
        return view('home', [
            'images' => $images,
        ]);
    }
}
