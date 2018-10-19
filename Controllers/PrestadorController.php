<?php

namespace App\Http\Controllers;

use App\Prestador;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PrestadorController extends Controller
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
        $prestadores = [];
        $prestadoresTemp = Prestador::select('prestadors.*')->join('users','users.id','=','prestadors.usuario')
            ->orderBy('users.name')->get();
        foreach ($prestadoresTemp as $prestador) {
            $prestador->usuario = User::find($prestador->usuario);
            array_push($prestadores, $prestador);
        }
        return View::make('prestador.index')->with('prestadores', $prestadores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('prestador.create');
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
            return Redirect::to('prestador/create')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $file = Input::file('foto');
            $filename = NULL;
            if($file != NULL) {
                $extencao = $file->getClientOriginalExtension();
                $time = time();
                $filename = $time . "." . $file->getClientOriginalExtension();
                if (!$file->move("upload/foto_prestador/", $filename)) {
                    Session::flash('danger', 'Falha no envio do arquivo.');
                    return Redirect::to('prestador/create')->withErrors($validator)->withInput(Input::except('password'));
                }
                $foto = NULL;
                if ($extencao == "jpeg" || $extencao == "jpg") {
                    $foto = imagecreatefromjpeg('upload/foto_prestador/' . $filename);
                } else if ($extencao == "png") {
                    $foto = imagecreatefrompng('upload/foto_prestador/' . $filename);
                } else if ($extencao == "gif") {
                    $foto = imagecreatefromgif('upload/foto_prestador/' . $filename);
                }
                if ($foto != NULL) {
                    $newLargura = 500;
                    $newAltura = 500;
                    list($largura, $altura) = getimagesize('upload/foto_prestador/' . $filename);
                    $new_foto = imagecreatetruecolor($newLargura, $newAltura);
                    imagecopyresampled($new_foto, $foto, 0, 0, 0, 0, $newLargura, $newAltura, $largura, $altura);
                    if ($extencao == "jpeg" || $extencao == "jpg") {
                        imagejpeg($new_foto, 'upload/foto_prestador/' . $time.".".$extencao, 100);
                    } else if ($extencao == "png") {
                        imagepng($new_foto, 'upload/foto_prestador/' . $time.".".$extencao, 8);
                    } else if ($extencao == "gif") {
                        imagegif($new_foto, 'upload/foto_prestador/' . $time.".".$extencao, 100);
                    }
                }
            }
            $senha = "";
            $telefoneCampo = Input::get('telefone');
            for($t=0; $t<strlen($telefoneCampo); $t++){
                if(is_numeric($telefoneCampo[$t])) {
                    $senha .= $telefoneCampo[$t];
                }
            }
            $usuario = new User();
            $usuario->name = Input::get('nome');
            $usuario->email = Input::get('email');
            $usuario->password = bcrypt($senha);
            $usuario->nivel = "PRESTADOR";
            $usuario->status = TRUE;
            $usuario->save();
            $prestador = new Prestador();
            $prestador->telefone = Input::get('telefone');
            $prestador->cep = Input::get('cep');
            $prestador->logradouro = Input::get('logradouro');
            $prestador->numero = Input::get('numero');
            $prestador->complemento = Input::get('complemento');
            $prestador->bairro = Input::get('bairro');
            $prestador->cidade = Input::get('cidade');
            $prestador->uf = Input::get('uf');
            $prestador->foto = $filename;
            $prestador->usuario = $usuario->id;
            $prestador->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('prestador/create');
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
        $prestador = Prestador::find($id);
        $usuario = User::find($prestador->usuario);
        $prestador->nome = $usuario->name;
        $prestador->email = $usuario->email;
        return View::make('prestador.show')->with('prestador',$prestador);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prestador = Prestador::find($id);
        $usuario = User::find($prestador->usuario);
        $prestador->nome = $usuario->name;
        $prestador->email = $usuario->email;
        $prestador->status = $usuario->status;
        return View::make('prestador.edit')->with('prestador',$prestador);
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
        $prestador = Prestador::find($id);
        $usuario = User::find($prestador->usuario);
        $rules = [
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$usuario->id,
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
            return Redirect::to('prestador/'.$id.'/edit')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $file = Input::file('foto');
            $filename = NULL;
            if($file != NULL) {
                $extencao = $file->getClientOriginalExtension();
                $time = time();
                $filename = $time . "." . $file->getClientOriginalExtension();
                if (!$file->move("upload/foto_prestador/", $filename)) {
                    Session::flash('danger', 'Falha no envio do arquivo.');
                    return Redirect::to('prestador/'.$id.'/edit')->withErrors($validator)->withInput(Input::except('password'));
                }
                $foto = NULL;
                if ($extencao == "jpeg" || $extencao == "jpg") {
                    $foto = imagecreatefromjpeg('upload/foto_prestador/' . $filename);
                } else if ($extencao == "png") {
                    $foto = imagecreatefrompng('upload/foto_prestador/' . $filename);
                } else if ($extencao == "gif") {
                    $foto = imagecreatefromgif('upload/foto_prestador/' . $filename);
                }
                if ($foto != NULL) {
                    $newLargura = 500;
                    $newAltura = 500;
                    list($largura, $altura) = getimagesize('upload/foto_prestador/' . $filename);
                    $new_foto = imagecreatetruecolor($newLargura, $newAltura);
                    imagecopyresampled($new_foto, $foto, 0, 0, 0, 0, $newLargura, $newAltura, $largura, $altura);
                    if ($extencao == "jpeg" || $extencao == "jpg") {
                        imagejpeg($new_foto, 'upload/foto_prestador/' . $time.".".$extencao, 100);
                    } else if ($extencao == "png") {
                        imagepng($new_foto, 'upload/foto_prestador/' . $time.".".$extencao, 8);
                    } else if ($extencao == "gif") {
                        imagegif($new_foto, 'upload/foto_prestador/' . $time.".".$extencao, 100);
                    }
                }
            }
            $usuario->name = Input::get('nome');
            $usuario->email = Input::get('email');
            $usuario->save();
            $prestador->telefone = Input::get('telefone');
            $prestador->cep = Input::get('cep');
            $prestador->logradouro = Input::get('logradouro');
            $prestador->numero = Input::get('numero');
            $prestador->complemento = Input::get('complemento');
            $prestador->bairro = Input::get('bairro');
            $prestador->cidade = Input::get('cidade');
            $prestador->uf = Input::get('uf');
            if(!is_null($filename)) {
                $prestador->foto = $filename;
            }
            $prestador->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('prestador/'.$id.'/edit');
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
        $prestador = Prestador::find($id);
        $usuario = User::find($prestador->usuario);
        $usuario->delete();
        Session::flash('success', 'REGISTRO APAGADO COM SUCESSO');
        return Redirect::to('prestador');
    }

    public function status($id)
    {
        $prestador = Prestador::find($id);
        $usuario = User::find($prestador->usuario);
        $usuario->status = !$usuario->status;
        $usuario->save();
        Session::flash('success', 'REGISTRO '.(!$usuario->status ? 'BLOQUEADO' : 'DESBLOQUEADO').' COM SUCESSO');
        return Redirect::to('prestador/'.$id.'/edit');
    }
}
