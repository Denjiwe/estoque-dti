@extends('adminlte::page')

@section('title', 'Cadastrar Produto')

@section('content_header')
    <h1>Cadastro de Produtos</h1>
@endsection

@section('content')
    <Box titulo="Cadastro">
        <template v-slot:body>
            @include('produto.components.form_create_edit')
        </template>
    </Box>
@stop