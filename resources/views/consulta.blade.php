@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-danger" data-dismiss="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('status') }}
                </div>
            @endif
            <div class="panel panel-success">
                <div class="panel-heading">
                    Consulta
                </div>
                <div class="panel-body">

                    <form class="bs-example bs-example-form" data-example-id="input-group-multiple-buttons" method="Post" action="{{ route('get.Consulta') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input aria-label="Text input with multiple buttons" class="form-control" name="cnpj">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit">
                                                pesquisar
                                            </button>
                                        </div>
                                    </input>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            
            @if ($bat)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Resultado
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-default btn-lg"> CNPJ: {{$recepe[0]}} </button>
                                <button class="btn btn-default btn-lg"> Inscrição Estadual: {{$recepe[1]}}</button>
                                <button class="btn btn-default btn-lg"> Razão Social: {{$recepe[2]}} </button>
                                <button class="btn btn-default btn-lg"> Logradouro: {{$recepe[3]}} </button>
                                <button class="btn btn-default btn-lg"> Número: {{$recepe[4]}} </button>
                                <button class="btn btn-default btn-lg"> Complemento: {{$recepe[5]}} </button>
                                <button class="btn btn-default btn-lg"> Bairro: {{$recepe[6]}} </button>
                                <button class="btn btn-default btn-lg"> Município:: {{$recepe[7]}} </button>
                                <button class="btn btn-default btn-lg"> UF: {{$recepe[8]}} </button>
                                <button class="btn btn-default btn-lg"> CEP: {{$recepe[9]}} </button>
                                <button class="btn btn-default btn-lg"> Telefone: {{$recepe[10]}} </button>
                                <button class="btn btn-default btn-lg"> Atividade Econômica: {{$recepe[11]}} </button>
                                <button class="btn btn-default btn-lg"> Data de Inicio de Atividade: {{$recepe[12]}} </button>
                                <button class="btn btn-default btn-lg"> Situação Cadastral Vigente: {{$recepe[13]}} </button>
                                <button class="btn btn-default btn-lg"> Data desta Situação Cadastral: {{$recepe[14]}} </button>
                                <button class="btn btn-default btn-lg"> Regime de Apuração: {{$recepe[15]}} </button>
                                <button class="btn btn-default btn-lg"> Emitente de NFe desde:  {{$recepe[16]}} </button>
                            </div>
                                                        
                        </div>
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</div>
@endsection
