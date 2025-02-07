<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Auth\User;
use App\Models\User as Userr;
use App\Models\Image;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            'auth',
            new Middleware('auth'),
        ];
    }
    
    public function index($search = null) {
        if(!empty($search)){
            $users = Userr::where('nick', 'LIKE', '%'.$search.'%')
                            ->orWhere('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('surname', 'LIKE', '%'.$search.'%')
                            ->orderBy('id', 'desc')
                            ->simplePaginate(5);
        }else{
            $users = Userr::orderBy('id', 'desc')->simplePaginate(5);
        }
        return view('user.index', [
            'users' => $users
        ]);
    }
    
    public function config() {
        return view('user.config');
    }
    
    public function update(Request $request) {
        //Conseguir usuario identificado
        $user = \Auth::user();
        $id = $user->id;
        
        //Validación del formulario
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', Rule::unique('users', 'nick')->ignore($id, 'id')],
            'email' => ['required', 'string', 'max:255', Rule::unique('users', 'email')->ignore($id, 'id')],
        ]);
        
        //Recoger datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
        //Asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;
        
        //Subir la imagen
        $image_path = $request->file('image_path');
        if($image_path){
            // create image manager with desired driver
            $manager = new ImageManager(new Driver());

            // read image from file system
            $resized_image = $manager->read($image_path->getRealPath());
            
            //Redimensionar imagen
            $resized_image->resize(100, 100);
           
            // Save the resized image to a temporary path
            $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.' . $image_path->getClientOriginalExtension();
            $resized_image->save($tempPath);

           
            //Poner nombre único
            $image_path_name = time().$image_path->getClientOriginalName();
                        
            //Guardar en la carpeta storage (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($tempPath));
            
            // Optionally, delete the temporary file
            unlink($tempPath);
            
            //Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }
        
        //Ejecutar consulta y cambios en la base de datos
        $user->update();
        
        return redirect()->route('config')
                         ->with(['message'=>'User successfully updated.']);
    }
    
    public function security() {
        return view('user.security');
    }
    
    public function updatePassword(Request $request){
        //Conseguir usuario identificado
        $user = User::find(auth()->user()->id);

        //Validación del formulario
        $validate = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required', 'string', 'min:8',
            'confirm_password' => 'required', 'same:new_password',
        ]);

        $data = $request->all();

        if(!\Hash::check($data['old_password'], $user->password)){

             return back()->with(['error-message' => 'You have entered wrong password']);

        }else{

           //Recoger datos del formulario
            $nueva_password = $request->input('confirm_password');

            //Asignar nuevos valores al objeto del usuario
            $password = bcrypt($nueva_password);
            $user->password = $password;

            //Ejecutar consulta y cambios en la base de datos
            $user->update();

            return redirect()->route('security')
                             ->with(['message'=>'Password successfully updated.']);

        }
    }
    
    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);
        return Response($file, 200);
    }
    
    public function profile($id) {
        //Conseguir usuario identificado
        $user = Userr::find($id);
        $images = Image::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        
        $data = ['user' => $user, 'images' => $images];
        
        return view('user.profile', $data);
    }
}
