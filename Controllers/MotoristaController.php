<?php

namespace App\Http\Controllers;

use App\Motorista;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class MotoristaController extends Controller
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
        $motoristas = [];
        $motoristasTemp = Motorista::select('motoristas.*')->join('users','users.id','=','motoristas.usuario')
            ->orderBy('users.name')->orderBy('motoristas.admissao')->get();
        foreach ($motoristasTemp as $motorista) {
            $motorista->usuario = User::find($motorista->usuario);
            array_push($motoristas, $motorista);
        }
        return View::make('motorista.index')->with('motoristas', $motoristas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('motorista.create');
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
            'admissao' => 'required',
            'foto' => 'image'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('motorista/create')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $file = Input::file('foto');
            $filename = NULL;
            if($file != NULL) {
                $extencao = $file->getClientOriginalExtension();
                $time = time();
                $filename = $time . "." . $file->getClientOriginalExtension();
                if (!$file->move("upload/foto_motorista/", $filename)) {
                    Session::flash('danger', 'Falha no envio do arquivo.');
                    return Redirect::to('motorista/create')->withErrors($validator)->withInput(Input::except('password'));
                }
                $foto = NULL;
                if ($extencao == "jpeg" || $extencao == "jpg") {
                    $foto = imagecreatefromjpeg('upload/foto_motorista/' . $filename);
                } else if ($extencao == "png") {
                    $foto = imagecreatefrompng('upload/foto_motorista/' . $filename);
                } else if ($extencao == "gif") {
                    $foto = imagecreatefromgif('upload/foto_motorista/' . $filename);
                }
                if ($foto != NULL) {
                    $newLargura = 500;
                    $newAltura = 500;
                    list($largura, $altura) = getimagesize('upload/foto_motorista/' . $filename);
                    $new_foto = imagecreatetruecolor($newLargura, $newAltura);
                    imagecopyresampled($new_foto, $foto, 0, 0, 0, 0, $newLargura, $newAltura, $largura, $altura);
                    if ($extencao == "jpeg" || $extencao == "jpg") {
                        imagejpeg($new_foto, 'upload/foto_motorista/' . $time.".".$extencao, 100);
                    } else if ($extencao == "png") {
                        imagepng($new_foto, 'upload/foto_motorista/' . $time.".".$extencao, 8);
                    } else if ($extencao == "gif") {
                        imagegif($new_foto, 'upload/foto_motorista/' . $time.".".$extencao, 100);
                    }
                }
            }
            $senha = "";
            $admissaoCampo = date("d/m/Y", strtotime(Input::get('admissao')));
            for($a=0; $a<strlen($admissaoCampo); $a++){
                if(is_numeric($admissaoCampo[$a])) {
                    $senha .= $admissaoCampo[$a];
                }
            }
            $usuario = new User();
            $usuario->name = Input::get('nome');
            $usuario->email = Input::get('email');
            $usuario->password = bcrypt($senha);
            $usuario->nivel = "MOTORISTA";
            $usuario->status = TRUE;
            $usuario->save();
            $motorista = new Motorista();
            $motorista->telefone = Input::get('telefone');
            $motorista->admissao = Input::get('admissao');
            $motorista->foto = $filename;
            $motorista->usuario = $usuario->id;
            $motorista->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('motorista/create');
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
        $motorista = Motorista::find($id);
        $usuario = User::find($motorista->usuario);
        $motorista->nome = $usuario->name;
        $motorista->email = $usuario->email;
        return View::make('motorista.show')->with('motorista',$motorista);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $motorista = Motorista::find($id);
        $usuario = User::find($motorista->usuario);
        $motorista->nome = $usuario->name;
        $motorista->email = $usuario->email;
        $motorista->status = $usuario->status;
        return View::make('motorista.edit')->with('motorista',$motorista);
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
        $motorista = Motorista::find($id);
        $usuario = User::find($motorista->usuario);
        $rules = [
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$usuario->id,
            'telefone' => 'required|max:25',
            'admissao' => 'required',
            'foto' => 'image'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('motorista/'.$id.'/edit')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $file = Input::file('foto');
            $filename = NULL;
            if($file != NULL) {
                $extencao = $file->getClientOriginalExtension();
                $time = time();
                $filename = $time . "." . $file->getClientOriginalExtension();
                if (!$file->move("upload/foto_motorista/", $filename)) {
                    Session::flash('danger', 'Falha no envio do arquivo.');
                    return Redirect::to('motorista/'.$id.'/edit')->withErrors($validator)->withInput(Input::except('password'));
                }
                $foto = NULL;
                if ($extencao == "jpeg" || $extencao == "jpg") {
                    $foto = imagecreatefromjpeg('upload/foto_motorista/' . $filename);
                } else if ($extencao == "png") {
                    $foto = imagecreatefrompng('upload/foto_motorista/' . $filename);
                } else if ($extencao == "gif") {
                    $foto = imagecreatefromgif('upload/foto_motorista/' . $filename);
                }
                if ($foto != NULL) {
                    $newLargura = 500;
                    $newAltura = 500;
                    list($largura, $altura) = getimagesize('upload/foto_motorista/' . $filename);
                    $new_foto = imagecreatetruecolor($newLargura, $newAltura);
                    imagecopyresampled($new_foto, $foto, 0, 0, 0, 0, $newLargura, $newAltura, $largura, $altura);
                    if ($extencao == "jpeg" || $extencao == "jpg") {
                        imagejpeg($new_foto, 'upload/foto_motorista/' . $time.".".$extencao, 100);
                    } else if ($extencao == "png") {
                        imagepng($new_foto, 'upload/foto_motorista/' . $time.".".$extencao, 8);
                    } else if ($extencao == "gif") {
                        imagegif($new_foto, 'upload/foto_motorista/' . $time.".".$extencao, 100);
                    }
                }
            }
            $usuario->name = Input::get('nome');
            $usuario->email = Input::get('email');
            $usuario->save();
            $motorista->telefone = Input::get('telefone');
            $motorista->admissao = Input::get('admissao');
            if(!is_null($filename)) {
                $motorista->foto = $filename;
            }
            $motorista->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('motorista/'.$id.'/edit');
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
        $motorista = Motorista::find($id);
        $usuario = User::find($motorista->usuario);
        $usuario->delete();
        Session::flash('success', 'REGISTRO APAGADO COM SUCESSO');
        return Redirect::to('motorista');
    }

    public function status($id)
    {
        $motorista = Motorista::find($id);
        $usuario = User::find($motorista->usuario);
        $usuario->status = !$usuario->status;
        $usuario->save();
        Session::flash('success', 'REGISTRO '.(!$usuario->status ? 'BLOQUEADO' : 'DESBLOQUEADO').' COM SUCESSO');
        return Redirect::to('motorista/'.$id.'/edit');
    }
}
