<?php

namespace App\Http\Controllers;

use App\Paciente;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PacienteController extends Controller
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
        $pacientes = [];
        $pacientesTemp = Paciente::select('pacientes.*')->join('users','users.id','=','pacientes.usuario')
            ->orderBy('users.name')->orderBy('pacientes.nascimento')->get();
        foreach ($pacientesTemp as $paciente) {
            $paciente->usuario = User::find($paciente->usuario);
            array_push($pacientes, $paciente);
        }
        return View::make('paciente.index')->with('pacientes', $pacientes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('paciente.create');
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
            'email' => 'required|email|max:255|unique:users',
            'nascimento' => 'required',
            'cpf' => 'required|max:25',
            'telefone' => 'required|max:25',
            'cep' => 'required|max:25',
            'numero' => 'required|max:25',
            'complemento' => 'max:255',
            'logradouro' => 'required|max:255',
            'bairro' => 'required|max:255',
            'cidade' => 'required|max:255',
            'uf' => 'required|max:255',
            'foto' => 'image'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('paciente/create')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $file = Input::file('foto');
            $filename = NULL;
            if($file != NULL) {
                $extencao = $file->getClientOriginalExtension();
                $time = time();
                $filename = $time . "." . $file->getClientOriginalExtension();
                if (!$file->move("upload/foto_paciente/", $filename)) {
                    Session::flash('danger', 'Falha no envio do arquivo.');
                    return Redirect::to('paciente/create')->withErrors($validator)->withInput(Input::except('password'));
                }
                $foto = NULL;
                if ($extencao == "jpeg" || $extencao == "jpg") {
                    $foto = imagecreatefromjpeg('upload/foto_paciente/' . $filename);
                } else if ($extencao == "png") {
                    $foto = imagecreatefrompng('upload/foto_paciente/' . $filename);
                } else if ($extencao == "gif") {
                    $foto = imagecreatefromgif('upload/foto_paciente/' . $filename);
                }
                if ($foto != NULL) {
                    $newLargura = 500;
                    $newAltura = 500;
                    list($largura, $altura) = getimagesize('upload/foto_paciente/' . $filename);
                    $new_foto = imagecreatetruecolor($newLargura, $newAltura);
                    imagecopyresampled($new_foto, $foto, 0, 0, 0, 0, $newLargura, $newAltura, $largura, $altura);
                    if ($extencao == "jpeg" || $extencao == "jpg") {
                        imagejpeg($new_foto, 'upload/foto_paciente/' . $time.".".$extencao, 100);
                    } else if ($extencao == "png") {
                        imagepng($new_foto, 'upload/foto_paciente/' . $time.".".$extencao, 8);
                    } else if ($extencao == "gif") {
                        imagegif($new_foto, 'upload/foto_paciente/' . $time.".".$extencao, 100);
                    }
                }
            }
            $senha = "";
            $nascimentoCampo = date("d/m/Y", strtotime(Input::get('nascimento')));
            for($n=0; $n<strlen($nascimentoCampo); $n++){
                if(is_numeric($nascimentoCampo[$n])) {
                    $senha .= $nascimentoCampo[$n];
                }
            }
            $usuario = new User();
            $usuario->name = Input::get('nome');
            $usuario->email = Input::get('email');
            $usuario->password = bcrypt($senha);
            $usuario->nivel = "PACIENTE";
            $usuario->status = TRUE;
            $usuario->save();
            $paciente = new Paciente();
            $paciente->nascimento = Input::get('nascimento');
            $paciente->cpf = Input::get('cpf');
            $paciente->telefone = Input::get('telefone');
            $paciente->cep = Input::get('cep');
            $paciente->logradouro = Input::get('logradouro');
            $paciente->numero = Input::get('numero');
            $paciente->complemento = Input::get('complemento');
            $paciente->bairro = Input::get('bairro');
            $paciente->cidade = Input::get('cidade');
            $paciente->uf = Input::get('uf');
            $paciente->foto = $filename;
            $paciente->usuario = $usuario->id;
            $paciente->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('paciente/create');
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
        $paciente = Paciente::find($id);
        $usuario = User::find($paciente->usuario);
        $paciente->nome = $usuario->name;
        $paciente->email = $usuario->email;
        return View::make('paciente.show')->with('paciente',$paciente);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paciente = Paciente::find($id);
        $usuario = User::find($paciente->usuario);
        $paciente->nome = $usuario->name;
        $paciente->email = $usuario->email;
        $paciente->status = $usuario->status;
        return View::make('paciente.edit')->with('paciente',$paciente);
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
        $paciente = Paciente::find($id);
        $usuario = User::find($paciente->usuario);
        $rules = [
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$usuario->id,
            'nascimento' => 'required',
            'cpf' => 'required|max:25',
            'telefone' => 'required|max:25',
            'cep' => 'required|max:25',
            'numero' => 'required|max:25',
            'complemento' => 'max:255',
            'logradouro' => 'required|max:255',
            'bairro' => 'required|max:255',
            'cidade' => 'required|max:255',
            'uf' => 'required|max:255',
            'foto' => 'image'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('paciente/'.$id.'/edit')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $file = Input::file('foto');
            $filename = NULL;
            if($file != NULL) {
                $extencao = $file->getClientOriginalExtension();
                $time = time();
                $filename = $time . "." . $file->getClientOriginalExtension();
                if (!$file->move("upload/foto_paciente/", $filename)) {
                    Session::flash('danger', 'Falha no envio do arquivo.');
                    return Redirect::to('paciente/'.$id.'/edit')->withErrors($validator)->withInput(Input::except('password'));
                }
                $foto = NULL;
                if ($extencao == "jpeg" || $extencao == "jpg") {
                    $foto = imagecreatefromjpeg('upload/foto_paciente/' . $filename);
                } else if ($extencao == "png") {
                    $foto = imagecreatefrompng('upload/foto_paciente/' . $filename);
                } else if ($extencao == "gif") {
                    $foto = imagecreatefromgif('upload/foto_paciente/' . $filename);
                }
                if ($foto != NULL) {
                    $newLargura = 500;
                    $newAltura = 500;
                    list($largura, $altura) = getimagesize('upload/foto_paciente/' . $filename);
                    $new_foto = imagecreatetruecolor($newLargura, $newAltura);
                    imagecopyresampled($new_foto, $foto, 0, 0, 0, 0, $newLargura, $newAltura, $largura, $altura);
                    if ($extencao == "jpeg" || $extencao == "jpg") {
                        imagejpeg($new_foto, 'upload/foto_paciente/' . $time.".".$extencao, 100);
                    } else if ($extencao == "png") {
                        imagepng($new_foto, 'upload/foto_paciente/' . $time.".".$extencao, 8);
                    } else if ($extencao == "gif") {
                        imagegif($new_foto, 'upload/foto_paciente/' . $time.".".$extencao, 100);
                    }
                }
            }
            $usuario->name = Input::get('nome');
            $usuario->email = Input::get('email');
            $usuario->save();
            $paciente->nascimento = Input::get('nascimento');
            $paciente->cpf = Input::get('cpf');
            $paciente->telefone = Input::get('telefone');
            $paciente->cep = Input::get('cep');
            $paciente->logradouro = Input::get('logradouro');
            $paciente->numero = Input::get('numero');
            $paciente->complemento = Input::get('complemento');
            $paciente->bairro = Input::get('bairro');
            $paciente->cidade = Input::get('cidade');
            $paciente->uf = Input::get('uf');
            if(!is_null($filename)) {
                $paciente->foto = $filename;
            }
            $paciente->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('paciente/'.$id.'/edit');
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
        $paciente = Paciente::find($id);
        $usuario = User::find($paciente->usuario);
        $usuario->delete();
        Session::flash('success', 'REGISTRO APAGADO COM SUCESSO');
        return Redirect::to('paciente');
    }

    public function status($id)
    {
        $paciente = Paciente::find($id);
        $usuario = User::find($paciente->usuario);
        $usuario->status = !$usuario->status;
        $usuario->save();
        Session::flash('success', 'REGISTRO '.(!$usuario->status ? 'BLOQUEADO' : 'DESBLOQUEADO').' COM SUCESSO');
        return Redirect::to('paciente/'.$id.'/edit');
    }
}
