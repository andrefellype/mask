<?php

namespace App\Http\Controllers;

use App\Carro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CarroController extends Controller
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
        $carros = Carro::orderBy('placa')->orderBy('limite_pessoas')->get();
        return View::make('carro.index')->with('carros', $carros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('carro.create');
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
            'modelo' => 'required|max:255',
            'placa' => 'required|max:255',
            'cor' => 'required',
            'limite_pessoas' => 'required|integer'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('carro/create')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $carro = new Carro();
            $carro->modelo = Input::get('modelo');
            $carro->placa = Input::get('placa');
            $carro->cor = Input::get('cor');
            $carro->limite_pessoas = Input::get('limite_pessoas');
            $carro->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('carro/create');
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
        $carro = Carro::find($id);
        return View::make('carro.edit')->with('carro',$carro);
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
            'modelo' => 'required|max:255',
            'placa' => 'required|max:255',
            'cor' => 'required',
            'limite_pessoas' => 'required|integer'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('carro/'.$id.'/edit')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $carro = Carro::find($id);
            $carro->modelo = Input::get('modelo');
            $carro->placa = Input::get('placa');
            $carro->cor = Input::get('cor');
            $carro->limite_pessoas = Input::get('limite_pessoas');
            $carro->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('carro/'.$id.'/edit');
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
        $carro = Carro::find($id);
        $carro->delete();
        Session::flash('success', 'REGISTRO APAGADO COM SUCESSO');
        return Redirect::to('carro');
    }
}
