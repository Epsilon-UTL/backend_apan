<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = [
            User::ROLE_ADMIN => 'Administrador',
            User::ROLE_USER => 'Usuario'
        ];
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:' . User::ROLE_ADMIN . ',' . User::ROLE_USER,
            'is_active' => 'boolean'
        ]);
        
        $isActive = ($request->is_active === 'on' || $request->is_active == 1) ? 1 : 0;

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->role = $request->role;
        $usuario->is_active = $isActive;
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente');
    }

    public function edit(User $usuario)
    {
        $roles = [
            User::ROLE_ADMIN => 'Administrador',
            User::ROLE_USER => 'Usuario'
        ];
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:' . User::ROLE_ADMIN . ',' . User::ROLE_USER,
            'is_active' => 'required'
        ]);

        $isActive = ($request->is_active === 'on' || $request->is_active == 1) ? 1 : 0;

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        if ($request->password) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->role = $request->role;
        $usuario->is_active = $isActive;
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente');
    }
}
