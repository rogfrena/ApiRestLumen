<?php

namespace App\Http\Controllers;
use App\User;

class UsersController extends Controller
{
    function index () {
            // PAR APRUENAS DE LA RUTA
        // $user= new User();
        // $user->name ='abeline';
        // $user->email ='abeline@abeline.com';

        //UTILIZAMOS ELOCUENT PARA SACAR REALMENTE LOS DATOS DE LA BD
        //ACTIVAR PRIMERO ELOQUENT EN bootstrap/app.php 
        //$app->withEloquent(); buscar este comando

        $users = User::all();
        return response()->json($users, $status = 200);
    }
}
