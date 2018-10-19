<?php

namespace App\Http\Controllers;

use App\Motorista;
use App\Paciente;
use App\Prestador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->nivel == "PACIENTE"){
            $paciente = Paciente::where('usuario', Auth::id())->first();
            Session::put('paciente', $paciente);
        }
        if(Auth::user()->nivel == "MOTORISTA"){
            $motorista = Motorista::where('usuario', Auth::id())->first();
            Session::put('motorista', $motorista);
        }
        if(Auth::user()->nivel == "PRESTADOR"){
            $prestador = Prestador::where('usuario', Auth::id())->first();
            Session::put('prestador', $prestador);
        }
        return View::make('home');
    }
}
