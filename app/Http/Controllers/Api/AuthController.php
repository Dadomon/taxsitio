<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;



class AuthController extends Controller{

    public function index(){
        return response()->json(
            [   'status' => 200,
                'mensaje' => 'simple prueba',

            ],200);
    }

    public function Registro(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'mensaje' =>$validator->errors()
                ],400);
        }

        if (User::where('email',$request->email)->exists()) {
            return response()->json(
                [   'status' => 400,
                    'mensaje' => 'Este usuario ya esta registrado'
                ],400);
        }

        $usuario = new User;
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return response()->json(
            [   'status' => 200,
                'mensaje' => 'Usuario registrado',

            ],200);
    }

    public function LoginToken(Request $request){
        
        $validator = Validator::make($request->all(),[
            'device_name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'mensaje' =>$validator->errors()
                ],400);
        }
    
        $user = User::where('email', $request->email)->first();

        $user->tokens()->delete();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'status' => 401,
                    'mensaje' =>'Usuario y/o contraseña incorrecta.'
                ],401);
        }
        return response()->json(
            [
                'status' => 200,
                'token' =>$user->createToken($request->device_name,['User:conductor'])->plainTextToken
            ],200);
    }
}
