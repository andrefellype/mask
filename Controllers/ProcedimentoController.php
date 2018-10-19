<?php

namespace App\Http\Controllers;

use App\Procedimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ProcedimentoController extends Controller
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
        $procedimentos = Procedimento::orderBy('nome')->get();
        return View::make('procedimento.index')->with('procedimentos', $procedimentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $complexidades = [0 => 'BAIXA', 1 => 'MÉDIA', 2 => 'ALTA'];
        return View::make('procedimento.create')->with('complexidades', $complexidades);
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
            'nome' => 'required|max:255',
            'complexidade' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('procedimento/create')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $procedimento = new Procedimento();
            $procedimento->nome = Input::get('nome');
            $procedimento->complexidade = Input::get('complexidade');
            $procedimento->descricao = Input::get('descricao');
            $procedimento->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('procedimento/create');
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
        $procedimento = Procedimento::find($id);
        $complexidades = [0 => 'BAIXA', 1 => 'MÉDIA', 2 => 'ALTA'];
        return View::make('procedimento.edit')->with('procedimento',$procedimento)->with('complexidades', $complexidades);
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
            'nome' => 'required|max:255',
            'complexidade' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('procedimento/'.$id.'/edit')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $procedimento = Procedimento::find($id);
            $procedimento->nome = Input::get('nome');
            $procedimento->complexidade = Input::get('complexidade');
            $procedimento->descricao = Input::get('descricao');
            $procedimento->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('procedimento/'.$id.'/edit');
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
        $procedimento = Procedimento::find($id);
        $procedimento->delete();
        Session::flash('success', 'REGISTRO APAGADO COM SUCESSO');
        return Redirect::to('procedimento');
    }
}
