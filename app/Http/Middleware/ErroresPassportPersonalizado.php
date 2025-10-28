<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ErroresPassportPersonalizado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (in_array($response->getStatusCode(), [400, 401]) && $response->getContent()) {
            $content = json_decode($response->getContent(), true);
    
            if (isset($content['error']) &&
                in_array($content['error'], ['invalid_credentials', 'invalid_grant'])) {
    
                $body = json_decode($request->getContent(), true);
                $email = $body['email'] ?? $body['username'] ?? null;
                $password = $body['password'] ?? null;
    
                $user = User::where('email', $email)->first();
    
                if (!$user) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'El usuario no se encuentra en el sistema.'
                    ], 404);
                }
    
                if (!Hash::check($password, $user->password)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'La contraseña es incorrecta.'
                    ], 401);
                }
    
                return response()->json([
                    'status' => 'error',
                    'message' => 'Credenciales inválidas.'
                ], 401);
            }
        }
    
        return $response;
    }

}

