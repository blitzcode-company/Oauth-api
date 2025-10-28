<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function register(Request $request){

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'fecha_de_nacimiento' => 'required|date',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'Ya existe un usuario con este correo electrónico.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'fecha_de_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_de_nacimiento.date' => 'El formato de la fecha no es válido.',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Errores de validación.',
                'errors' => $validation->errors()
            ], 422);
        }

        return $this->createUser($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario registrado exitosamente',
            'user' => $user
        ], 201);
        
    }

    private function createUser($request){
        $user = new User();
        $user -> name = $request -> post("name");
        $user -> email = $request -> post("email");
        $user -> fecha_de_nacimiento = $request -> post("fecha_de_nacimiento");
        $user -> password = Hash::make($request -> post("password"));   
        $user -> save();
        return $user;
    }

    public function validarToken(Request $request){
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token inválido o no autenticado'
            ], 401);
        }

        return auth('api')->user();

    }

    public function logout(Request $request){
        $user = auth('api')->user();

        if ($user) {
            $request->user()->token()->revoke();
            return response()->json([
                'status' => 'success',
                'message' => 'Sesión cerrada exitosamente'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No hay usuario autenticado'
        ], 401);
        
        
    }

}
