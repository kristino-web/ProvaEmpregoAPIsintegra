@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" data-dismiss="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('status') }}
                </div>
            @endif
            <div class="panel panel-success">
                <div class="panel-heading">
                    Minhas Consultas
                </div>
                <div class="panel-body">

                   <table class="table table-hover">
                       <thead>
                           <tr>
                               <th>id</th>
                               <th>cnpj</th>
                               <th>resultado json</th>
                               <th>Ação</th>
                           </tr>
                       </thead>
                       <tbody>
                            @foreach ($consulta as $c)
                            <tr>
                               <td> {{$c->id}} </td>
                               <td> {{$c->cnpj}} </td>
                               <td> {{$c->resultado_json}} </td>
                               <td>
                                    <form class="bs-example bs-example-form"  method="DELETE" action="{{ route('get.destroy', $c->id) }}">
                                    <button type="submit" class="btn btn-danger"> delete </button>
                                    </form>
                               </td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>

                </div>
            </div>
            
            
            
        </div>
    </div>
</div>
@endsection
