@extends('adminlte::page')

@section('title', 'Sem permissão')

@section('content_header')
    <h1>Sem permissão</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <x-box titulo="">
        <x-slot:body>
            <h4>Você não possui permissão para acessar essa página!</h4>
        </x-slot:body>
        <x-slot:footer>
            <div class="row justify-content-end">
                <div class="col-auto">
                    <a href="{{route('solicitacoes.store')}}"><button type="button" class="btn btn-secondary me-2">Solicitar</button></a>
                    <a href="{{route('minhas-solicitacoes')}}"><button type="button" class="btn btn-primary">Minhas Solicitações</button></a>
                </div>
            </div>
        </x-slot:footer>
    </x-box>
@stop