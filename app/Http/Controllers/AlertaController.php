<?php

namespace App\Http\Controllers;

use App\Events\AlertaEnviada;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function enviarAlerta(Request $request)
    {
        broadcast(new AlertaEnviada($request->mensaje));
        return response()->json(['message' => 'Alerta enviada']);
    }
}
