@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Detalhes de {{$usuario->nome}}</h1>
@endsection

@section('content')
    <Box titulo="Visualizar">
        <template v-slot:body>
            @include('usuario.components.user_show')
        </template>
    </Box>
@stop