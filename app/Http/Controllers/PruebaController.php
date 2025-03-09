<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PruebaController extends Controller
{
    function saludar(){

        $datos = [];
        $dato['nombre'] = 'Juan';
        $dato['apellido'] = 'Perez';
        $dato['edad'] = 25;

        $datos[] = $dato;
        $dato = [];
        $dato['nombre'] = 'Maria';
        $dato['apellido'] = 'Gomez';
        $dato['edad'] = 30;

        $datos[] = $dato;
        
        return view('welcome', compact('datos'));
    }
}
