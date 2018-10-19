<?php

namespace App\Http\Controllers;

use App\AgendamentoCarro;
use App\AgendamentoPaciente;
use App\Carro;
use App\Motorista;
use App\Paciente;
use App\Pessoa;
use App\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AgendamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $vaga = Vaga::find($id);
        $statusObservacao = FALSE;
        $totalVagaCarro = 0;
        $agendamentosCarro = AgendamentoCarro::where('vaga', $id)->orderBy('data', 'ASC')->get();
        foreach ($agendamentosCarro as $ac) {
            $carro = Carro::find($ac->carro);
            $totalVagaCarro += $carro->limite_pessoas;
        }
        $agendamentos = [];
        if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR") {
            $agendamentos = AgendamentoPaciente::where('vaga', $id)->orderBy('data', 'ASC')->get();
        } else {
            $agendamentos = AgendamentoCarro::where('vaga', $id)->orderBy('data', 'ASC')->get();
        }
        $count = 0;
        foreach ($agendamentos as $agendamento) {
            if(!is_null($agendamento->observacao)){
                $statusObservacao = TRUE;
            }
            if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR") {
                $agendamento->paciente = Paciente::find($agendamento->paciente);
                $agendamento->paciente->pessoa = Pessoa::find($agendamento->paciente->pessoa);
                if($count < $vaga->quantidade) {
                    if($count < $totalVagaCarro) {
                        $agendamento->status_num = 1;
                        $agendamento->status = 'CARRO AGENDADO';
                    } else {
                        $agendamento->status_num = 0;
                        $agendamento->status = 'AGUARDANDO CARRO';
                    }
                } else {
                    $agendamento->status_num = -1;
                    $agendamento->status = 'LISTA DE ESPERA';
                    $agendamento->carro = NULL;
                }
                $count++;
            } else {
                $agendamento->motorista = Motorista::find($agendamento->motorista);
                $agendamento->motorista->pessoa = Pessoa::find($agendamento->motorista->pessoa);
                $agendamento->carro = Carro::find($agendamento->carro);
            }
        }
        return View::make('agendamento.index')->with('vaga', $vaga)->with('observacao', $statusObservacao)->with('agendamentos', $agendamentos);
    }

    public function create($id){
        $vaga = Vaga::find($id);
        $carros = [];
        $motorista = [];
        $pacientes = [];
        if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR") {
            $pacientesTemp = Paciente::select('pacientes.*', 'pessoas.nome as nome_pessoa', 'telefones.telefone')
                ->join('pessoas', 'pessoas.id', '=', 'pacientes.pessoa')
                ->join('telefones', 'telefones.id', '=', 'pacientes.telefone')
                ->orderBy('pessoas.nome', 'ASC')->get();
            foreach ($pacientesTemp as $paciente) {
                $agendamento = AgendamentoPaciente::where('paciente', $paciente->id)->where('vaga', $vaga->id)->first();
                if (is_null($agendamento)) {
                    $pacientes[$paciente->id] = $paciente->nome_pessoa . " - TELEFONE: " . $paciente->telefone;
                }
            }
        } else {
            $carrosTemp = Carro::orderBy('placa', 'ASC')->get();
            foreach ($carrosTemp as $carro) {
                $statusCarro = TRUE;
                $agendamentos = AgendamentoCarro::where('carro', $carro->id)->get();
                foreach($agendamentos as $a){
                    if(date("Y-m-d", strtotime($a->data)) == $vaga->data){
                        $statusCarro = FALSE;
                    }
                }
                if ($statusCarro) {
                    $carros[$carro->id] = $carro->modelo . " - PLACA: " . $carro->placa;
                }
            }
            $motoristaTemp = Motorista::select('motoristas.*', 'pessoas.nome as nome_pessoa', 'telefones.telefone')
                ->join('pessoas', 'pessoas.id', '=', 'motoristas.pessoa')
                ->join('telefones', 'telefones.id', '=', 'motoristas.telefone')
                ->orderBy('pessoas.nome', 'ASC')->get();
            foreach ($motoristaTemp as $motorista) {
                $statusMotorista = TRUE;
                $agendamentos = AgendamentoCarro::where('motorista', $motorista->id)->get();
                foreach($agendamentos as $a){
                    if(date("Y-m-d", strtotime($a->data)) == $vaga->data){
                        $statusMotorista = FALSE;
                    }
                }
                if ($statusMotorista) {
                    $motoristas[$motorista->id] = $motorista->nome_pessoa . " - TELEFONE: " . $motorista->telefone;
                }
            }
        }
        return View::make('agendamento.create')->with('vaga', $vaga)->with('pacientes', $pacientes)->with('carros', $carros)->with('motoristas', $motoristas);
    }

    public function store(Request $request, $id){
        if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR") {
            $rules = ['paciente' => 'required'];
        } else {
            $rules = [
                'motorista' => 'required',
                'carro' => 'required'
            ];
        }
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('agendamento/create/'.$id)->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $agendamento = NULL;
            if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR") {
                $agendamento = new AgendamentoPaciente();
            } else {
                $agendamento = new AgendamentoCarro();
            }
            $agendamento->data = date("Y-m-d H:i:s");
            $agendamento->observacao = Input::get('observacao');
            $agendamento->vaga = $id;
            if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR") {
                $agendamento->paciente = Input::get('paciente');
            } else {
                $agendamento->motorista = Input::get('motorista');
                $agendamento->carro = Input::get('carro');
            }
            $agendamento->save();
            Session::flash('success', "REGISTRO REALIZADO COM SUCESSO.");
            return Redirect::to('agendamento/create/'.$id);
        }
    }

    public function destroy($id){
        if(Auth::user()->nivel == "GESTOR PACIENTE/PRESTADOR") {
            $agendamento = AgendamentoPaciente::find($id);
        } else {
            $agendamento = AgendamentoCarro::find($id);
        }
        $vaga = $agendamento->vaga;
        $agendamento->delete();
        Session::flash('success', "REGISTRO APAGADO COM SUCESSO.");
        return Redirect::to('agendamento/'.$vaga);
    }
}
