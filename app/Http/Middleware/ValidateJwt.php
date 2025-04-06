<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsuariosToken;
use App\Models\TemporaryToken;
use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidateJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $controller = new Controller();
        $controller->insertarBitacora($request);

        if (!$request->bearerToken()) {
            return response()->json(['message' => 'Token no proporcionado'], 401);
        }

        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        $user = Auth::guard('sanctum')->user();
        if (!$user->is_active) {
            return response()->json(['message' => 'Usuario inactivo'], 403);
        }

        return $next($request);
    }

    public function generarJwt($usuario_id)
    {
        $tiempo_actual = time();
        $expiracion = $tiempo_actual + 3600; 

        $payload = [
            'sub' => $usuario_id,
            'iat' => $tiempo_actual,
            'exp' => $expiracion,
            'role' => User::find($usuario_id)->role 
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return $jwt;
    }

    /**
     * Genera un token temporal (para usos específicos como recuperación de contraseña)
     */
    public function generarTokenTemporal($usuario_id, $minutos_validez = 30)
    {
        $token = bin2hex(random_bytes(32)); 
        
        TemporaryToken::create([
            'user_id' => $usuario_id,
            'token' => $token,
            'expires_at' => now()->addMinutes($minutos_validez),
            'is_used' => false
        ]);

        return $token;
    }
}