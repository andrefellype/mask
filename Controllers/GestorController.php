<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class GestorController extends Controller
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
        $gestores = [];
        $gestoresTemp = User::where('nivel','GESTOR')->orderBy('name')->get();
        foreach ($gestoresTemp as $gestor) {
            if($gestor->id != Auth::id()) {
                array_push($gestores, $gestor);
            }
        }
        return View::make('gestor.index')->with('gestores', $gestores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('gestor.create');
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
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
            return Redirect::to('gestor/create')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $usuario = new User();
            $usuario->name = Input::get('name');
            $usuario->email = Input::get('email');
            $usuario->password = bcrypt(Input::get('password'));
            $usuario->nivel = "GESTOR";
            $usuario->status = TRUE;
            $usuario->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('gestor/create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gestor = User::find($id);
        return View::make('gestor.show')->with('gestor', $gestor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = User::find($id);
        $usuario->delete();
        Session::flash('success', 'REGISTRO APAGADO COM SUCESSO');
        return Redirect::to('gestor');
    }

    public function status($id)
    {
        $usuario = User::find($id);
        $usuario->status = !$usuario->status;
        $usuario->save();
        Session::flash('success', 'REGISTRO '.(!$usuario->status ? 'BLOQUEADO' : 'DESBLOQUEADO').' COM SUCESSO');
        return Redirect::to('gestor/'.$id);
    }
}
