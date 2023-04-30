@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Cadastro de Usuários</h1>
@endsection

@section('content')
    <Box titulo="Cadastro">
        <template v-slot:body>
            @include('usuario.components.form_create_edit')
        </template>
    </Box>
@stop