@extends('adminlte::page')

@section('title', 'Auditoria')

@section('content_header')
    <h1>Auditoria</h1>
@endsection

@section('content')
    <x-box>
        <x-slot:body>
            <x-box-input>
                <x-slot:body>
                    <div class="bg-white rounded p-3">
                        @if(count($mensagens) == 0)
                            <p>Não há registros de auditoria.</p>
                        @else
                            @foreach($mensagens as $mensagem)
                                <p>{{ $mensagem }}</p>
                            @endforeach
                        @endif
                    </div>
                </x-slot:body>
            </x-box-input>
        </x-slot:body>
        <x-slot:footer>
            <div class="mt-3 row justify-content-end">
                <div class="col-auto">
                    <a href="{{ route('auditorias.index') }}" class="btn btn-secondary me-2">Voltar</a>
                    <a href="" class="btn btn-primary">Visualização em tabela</a>
                </div>
            </div>
        </x-slot:footer>
    </x-box>
@endsection

@section('css')
    <style scoped>
        p {
            font-size: 1rem;
        }
    </style>
@endsection