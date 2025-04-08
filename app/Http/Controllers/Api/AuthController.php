<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Middleware\ValidateJwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->all();
        if ($request->email == null || $request->password == null) {
            return $this->messageError();
        }

        $user = User::where('email', $request->email)->first();

        $response = [];

        if (!$user || !Hash::check($request->password, $user->password)) {
            $response['status'] = 'error';
            $response['code'] = 401;
            $response['message'] = 'Credenciales incorrectas';
            return response()->json($response, 200);
        }

        if (!$user->is_active) {
            $response['status'] = 'error';
            $response['code'] = 403;
            $response['message'] = 'Usuario inactivo';
            return response()->json($response, 200);
        }

        $existingToken = \App\Models\TemporaryToken::where('user_id', $user->id)
        ->where('is_used', true)
        ->first();    

        if ($existingToken) {
            $existingToken->is_used = false;
            $existingToken->save();
        }

        // Generar token JWT
        $jwtMiddleware = new ValidateJwt();
        $token = $jwtMiddleware->generarJwt($user->id);

        // Guardar el token en la tabla temporary_tokens
        \App\Models\TemporaryToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => now()->addDays(1),
            'is_used' => true
        ]);

        $response['status'] = 'success';
        $response['code'] = 200;
        $response['message'] = 'Inicio de sesión exitoso';
        $response['data'] = [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ];
        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Jwt');
        \App\Models\TemporaryToken::where('token', $token)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = $this-> user($request->header('Jwt'));

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Token no válido o expirado',
                'data' => [
                    'error' => 'No se encontró una sesión activa'
                ]
            ], 401);
        }

        $request->all();
        if ($request->password == null || $request->new_password == null) {
            return $this->messageError();
        }

        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Contraseña cambiada exitosamente',
                'data' => [
                    'token' => $user->token,
                    'user' => [
                        'id' => $user->id
                    ],
                ]
            ]);
        } else {
            return response()->json([
                'status'=> 'error',
                'code'=>  401,
                'message' => 'La contraseña actual no es correcta',
                'data'=> [
                    'error'=> ''
                ],
            ]);
        }
    }

    public function me(Request $request)
    {
        try {
            $user = $this-> user($request->header('Jwt'));
                
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'code' => 401,
                    'message' => 'Token no válido o expirado',
                    'data' => [
                        'error' => 'No se encontró una sesión activa'
                    ]
                ], 401);
            }

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Usuario no encontrado',
                    'data' => [
                        'error' => 'El usuario asociado al token no existe'
                    ]
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Información del usuario obtenida exitosamente',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'is_active' => $user->is_active,
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Error al obtener información del usuario',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }
    
    public function register(Request $request)
    {
        if ($request->name == null || $request->email == null || $request->password == null) {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'message' => 'Faltan datos requeridos',
                'data' => [
                    'error' => 'Nombre, email y contraseña son obligatorios'
                ]
            ], 200);
        }

        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => 'error',
                'code' => 409,
                'message' => 'El email ya está registrado',
                'data' => [
                    'error' => 'Ya existe un usuario con este email'
                ]
            ], 200);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => User::ROLE_USER,
                'is_active' => true
            ]);

            $jwtMiddleware = new ValidateJwt();
            $token = $jwtMiddleware->generarJwt($user->id);

            \App\Models\TemporaryToken::create([
                'user_id' => $user->id,
                'token' => $token,
                'expires_at' => now()->addDays(1),
                'is_used' => true,
            ]);

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Usuario registrado exitosamente',
                'data' => [
                    'token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Error al registrar el usuario',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 200);
        }
    }

    private function messageError()
    {
        return response()->json([
            'message' => 'El token no es valido',
            'code' => 500,
            'data' => [
                'error' => ''
            ]
        ]);
    }
}
