<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    function index (Request $request) {
            // PAR APRUENAS DE LA RUTA
        // $user= new User();
        // $user->name ='abeline';
        // $user->email ='abeline@abeline.com';

        //UTILIZAMOS ELOCUENT PARA SACAR REALMENTE LOS DATOS DE LA BD
        //ACTIVAR PRIMERO ELOQUENT EN bootstrap/app.php 
        //$app->withEloquent(); buscar este comando
        if ( $request->isJson()){
            $users = User::all();
        return response()->json($users, $status = 200);
        }
        return response()->json(['error'=> 'Unauthorized'], 401 , []);
    }

    function createUser(Request $request){
        if ( $request->isJson()){
            //  TODO: Create the user in the DB
            $data = $request->json()->all();

            $user = User::create([
                'name'      => $data['name'],
                'username'  => $data['username'],
                'email'     => $data['email'],
                'password'  => Hash::make( $data['password'] ),
                'api_token' => bin2hex(openssl_random_pseudo_bytes(30))
            ]);
            return response()->json($user, $status = 201);
        }
        return response()->json(['error'=> 'Unauthorized'], 401 , []);
    }

    function getToken(Request $request){
        if ($request->isJson()) {       
            try{
                $data = $request->json()->all();

                $user = User::where('username', $data['username'])->first();
                
                if ($user && Hash::check($data['password'], $user->password)) {
                    return response()->json($user, 200);
                }else{
                    return response()->json(['error' => 'No Content'], 406);
                }
            }catch ( ModelNotFoundException $e){
                return response()->json(['error' => 'No Content'], 406);
            }
        }

        return response()->json(['error'=> 'Unauthorized'], 401 , []);

    }
}
