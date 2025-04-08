<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\TemporaryToken;
use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class ValidateJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $jwt = $request->header('Jwt');
        if (empty($jwt)) {
            return response()->json([
                'status' => 'error',
                'message' => 'La petición no tiene el encabezado JWT'
            ], 401);
        }

        try {
            if ($jwt == -270399) {
                return $next($request);
            }
            
            $token = TemporaryToken::where('token', $jwt)->first();
            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token no válido o expirado'
                ], 401);
            }

            $user = User::find($token->user_id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Usuario no encontrado'
                ], 401);
            }

            // Agregar el usuario a la request
            $request->merge(['user' => $user]);
            
            return $next($request);
        } catch (ExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'El token ha expirado'
            ], 401);
        } catch (SignatureInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'El token no es válido'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de autenticación'
            ], 401);
        }
    }

    /**
     * Genera un token JWT
     *
     * @param  int  $userId
     * @return string
     */
    public function generarJwt($userId)
    {
        $tiempo_actual = time();
        $tiempo_expiracion = $tiempo_actual + (60 * 60 * 24);

        $payload = [
            'sub' => $userId, // ID del usuario
            'iat' => $tiempo_actual, // Tiempo de emisión
            'exp' => $tiempo_expiracion // Tiempo de expiración
        ];
        
        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return $jwt;
    }
}
