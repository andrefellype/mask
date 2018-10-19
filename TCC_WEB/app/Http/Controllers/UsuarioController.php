<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        return View::make('usuario.edit')->with('usuario', $usuario);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'password' => 'required|min:3|max:10|confirmed'
        ];
        $messages = [
            'name.required'=>'O campo nome é obrigatório.',
            'name.max'=>'Nome não deve ter mais que :max caracteres.',
            'password.required'=>'O campo senha é obrigatório.',
            'password.min'=>'Senha deve ter no mínimo :min caracteres.',
            'password.max'=>'Senha não deve ter mais que :max caracteres.',
            'password.confirmed'=>'A confirmação da senha não confere.'
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::to('usuario/'.$id.'/edit')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $usuario = User::find($id);
            $usuario->name = Input::get('name');
            $usuario->email = Input::get('email');
            $usuario->password = bcrypt(Input::get('password'));
            $usuario->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('usuario/'.$id.'/edit');
        }
    }
}
