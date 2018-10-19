<?php

namespace App\Http\Controllers;

use App\AgendamentoCarro;
use App\AgendamentoPaciente;
use App\Paciente;
use App\Procedimento;
use App\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class VagaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::has('prestador')){
            $vagas = Vaga::select('vagas.*')
                ->join('procedimentos', 'procedimentos.id', '=', 'vagas.procedimento')
                ->where('procedimentos.prestador', Session::get('prestador')->id)
                ->orderBy('vagas.data', 'ASC')->get();
        } else {
            $vagas = Vaga::orderBy('data', 'ASC')->get();
        }
        foreach ($vagas as $vaga) {
            if(!Session::has('prestador')){
                $vaga->agendada = Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR" ? AgendamentoPaciente::where('vaga', $vaga->id)->count() : (Auth::user()->nivel == "GESTOR MOTORISTA" ? AgendamentoCarro::where('vaga', $vaga->id)->count() : 0);
            }
            $vaga->procedimento = Procedimento::select('procedimentos.*', 'pessoas.nome as prestador_nome')
                ->join('prestadors', 'prestadors.id', '=', 'procedimentos.prestador')
                ->join('pessoas', 'pessoas.id', '=', 'prestadors.pessoa')
                ->where('procedimentos.id', $vaga->procedimento)->first();
        }
        return View::make('vaga.index')->with('vagas', $vagas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $procedimentos = [];
        $procedimentosTemp = Procedimento::where('prestador', Session::get('prestador')->id)->orderBy('nome')->get();
        foreach ($procedimentosTemp as $procedimento) {
            $procedimentos[$procedimento->id] = $procedimento->nome;
        }
        return View::make('vaga.create')->with('procedimentos', $procedimentos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'data' => 'required',
            'hora' => 'required',
            'quantidade' => 'required|integer',
            'procedimento' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('vaga/create')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $vaga = new Vaga();
            $vaga->data = Input::get('data') . " " . Input::get('hora');
            $vaga->quantidade = Input::get('quantidade');
            $vaga->procedimento = Input::get('procedimento');
            $vaga->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('vaga/create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vaga = Vaga::find($id);
        $vaga->hora = date("H:i:s", strtotime($vaga->hora));
        $vaga->data = date("Y-m-d", strtotime($vaga->data));
        $procedimentos = [];
        $procedimentosTemp = Procedimento::where('prestador', Session::get('prestador')->id)->orderBy('nome')->get();
        foreach ($procedimentosTemp as $procedimento) {
            $procedimentos[$procedimento->id] = $procedimento->nome;
        }
        return View::make('vaga.edit')->with('vaga', $vaga)->with('procedimentos', $procedimentos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'data' => 'required',
            'hora' => 'required',
            'quantidade' => 'required|integer',
            'procedimento' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('vaga/'.$id.'/edit')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            if(AgendamentoPaciente::where('vaga', $id)->count() == 0) {
                $vaga = Vaga::find($id);
                $vaga->data = Input::get('data') . " " . Input::get('hora');
                $vaga->quantidade = Input::get('quantidade');
                $vaga->procedimento = Input::get('procedimento');
                $vaga->save();
                Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
                return Redirect::to('vaga/' . $id . '/edit');
            } else {
                Session::flash('danger', "JÁ POSSUÍ PACIENTE AGENDADA A ESTA VAGA.");
                return Redirect::to('vaga/' . $id . '/edit');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(AgendamentoPaciente::where('vaga', $id)->count() == 0) {
            $vaga = Vaga::find($id);
            $vaga->delete();
            Session::flash('success', "REGISTRO APAGADO COM SUCESSO.");
            return Redirect::to('vaga');
        } else {
            Session::flash('danger', "JÁ POSSUÍ PACIENTE AGENDADA A ESTA VAGA.");
            return Redirect::to('vaga');
        }
    }
}
