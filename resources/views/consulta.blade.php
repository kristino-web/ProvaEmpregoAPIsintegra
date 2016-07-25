@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
</div>
@endsection
