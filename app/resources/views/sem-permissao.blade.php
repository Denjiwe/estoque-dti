@extends('adminlte::page')

@section('title', 'Sem permissão')

@section('content_header')
    <h1>Sem permissão</h1>
@endsection

@section('content')
    {{-- Box de pesquisa --}}
    <Box titulo="">
        <template v-slot:body>
            <h4>Você não possui permissão para acessar essa página!</h4>
        </template>
        <template v-slot:footer>
            <div class="float-end">
                <a href="{{route('solicitar.index')}}"><button type="button" class="btn btn-secondary me-2">Solicitar</button></a>
                <a href="{{route('minhas-solicitacoes')}}"><button type="button" class="btn btn-primary">Minhas Solicitações</button></a>
            </div>
        </template>
    </Box>
@stop