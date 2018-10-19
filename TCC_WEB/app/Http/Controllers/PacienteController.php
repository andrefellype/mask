<?php

namespace App\Http\Controllers;

use App\Endereco;
use App\Paciente;
use App\Pessoa;
use App\Telefone;
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
        $pacientesTemp = Paciente::select('pacientes.*')->join('pessoas','pessoas.id','=','pacientes.pessoa')
            ->orderBy('pessoas.nome')->orderBy('pacientes.nascimento')->get();
        foreach ($pacientesTemp as $paciente) {
            $paciente->pessoa = Pessoa::find($paciente->pessoa);
            $paciente->telefone = Telefone::find($paciente->telefone);
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
            'email' => 'required|email|max:255|unique:pessoas',
            'nascimento' => 'required',
            'cpf' => 'required|max:25',
            'rg' => 'required|max:25',
            'telefone' => 'required|max:25',
            'celular' => 'max:25',
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
            $pessoa = new Pessoa();
            $pessoa->nome = Input::get('nome');
            $pessoa->email = Input::get('email');
            $pessoa->foto = $filename;
            $pessoa->save();
            $endereco = new Endereco();
            $endereco->cep = Input::get('cep');
            $endereco->logradouro = Input::get('logradouro');
            $endereco->numero = Input::get('numero');
            $endereco->complemento = Input::get('complemento');
            $endereco->bairro = Input::get('bairro');
            $endereco->cidade = Input::get('cidade');
            $endereco->uf = Input::get('uf');
            $endereco->save();
            $telefone = new Telefone();
            $telefone->telefone = Input::get('telefone');
            $telefone->celular = Input::get('celular');
            $telefone->save();
            $paciente = new Paciente();
            $paciente->nascimento = Input::get('nascimento');
            $paciente->cpf = Input::get('cpf');
            $paciente->rg = Input::get('rg');
            $paciente->pessoa = $pessoa->id;
            $paciente->endereco = $endereco->id;
            $paciente->telefone = $telefone->id;
            $paciente->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('paciente/create');
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
        $paciente = Paciente::find($id);
        $pessoa = Pessoa::find($paciente->pessoa);
        if(!is_null($pessoa)) {
            $paciente->nome = $pessoa->nome;
            $paciente->email = $pessoa->email;
            $paciente->foto = $pessoa->foto;
        }
        $endereco = Endereco::find($paciente->endereco);
        if(!is_null($endereco)) {
            $paciente->cep = $endereco->cep;
            $paciente->logradouro = $endereco->logradouro;
            $paciente->numero = $endereco->numero;
            $paciente->complemento = $endereco->complemento;
            $paciente->bairro = $endereco->bairro;
            $paciente->cidade = $endereco->cidade;
            $paciente->uf = $endereco->uf;
        }
        $telefone = Telefone::find($paciente->telefone);
        if(!is_null($telefone)) {
            $paciente->telefone = $telefone->telefone;
            $paciente->celular = $telefone->celular;
        }
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
            'email' => 'required|email|max:255|unique:pessoas,email,'.$paciente->pessoa,
            'nascimento' => 'required',
            'cpf' => 'required|max:25',
            'rg' => 'required|max:25',
            'telefone' => 'required|max:25',
            'celular' => 'max:25',
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
            $pessoa = Pessoa::find($paciente->pessoa);
            $pessoa->nome = Input::get('nome');
            $pessoa->email = Input::get('email');
            if(!is_null($filename)) {
                $pessoa->foto = $filename;
            }
            $pessoa->save();

            $endereco = Endereco::find($paciente->endereco);
            $endereco->cep = Input::get('cep');
            $endereco->logradouro = Input::get('logradouro');
            $endereco->numero = Input::get('numero');
            $endereco->complemento = Input::get('complemento');
            $endereco->bairro = Input::get('bairro');
            $endereco->cidade = Input::get('cidade');
            $endereco->uf = Input::get('uf');
            $endereco->save();

            $telefone = Telefone::find($paciente->telefone);
            $telefone->telefone = Input::get('telefone');
            $telefone->celular = Input::get('celular');
            $telefone->save();

            $paciente->nascimento = Input::get('nascimento');
            $paciente->cpf = Input::get('cpf');
            $paciente->rg = Input::get('rg');
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
        $pessoa = Pessoa::find($paciente->pessoa);
        $telefone = Telefone::find($paciente->telefone);
        $endereco = Endereco::find($paciente->endereco);
        if(!is_null($pessoa)){
            $pessoa->delete();
        }
        if(!is_null($telefone)){
            $telefone->delete();
        }
        if(!is_null($endereco)){
            $endereco->delete();
        }
        Session::flash('success', 'REGISTRO APAGADO COM SUCESSO');
        return Redirect::to('paciente');
    }
}
