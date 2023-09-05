@extends('adminlte::page')

@section('title', 'Auditoria')

@section('content_header')
    <h1>Auditoria</h1>
@endsection

@section('content')
    <x-adminlte-card theme="primary" theme-mode="outline">
        <x-box-input>
            <x-slot:body>
                <div id="log" class="rounded p-3">
                    @if(count($mensagens) == 0)
                        <p>Não há registros de auditoria.</p>
                    @else
                        @foreach($mensagens as $mensagem)
                            <p>{{ $mensagem }}</p>
                        @endforeach
                    @endif
                </div>

                <div id="tabela" class="rounded p-3" style="display: none">
                    @if(count($mensagens) == 0)
                        <p>Não há registros de auditoria.</p>
                    @else
                        <x-adminlte-datatable id="table" :heads="$heads" :config="$config" compressed/>
                    @endif
                </div>
            </x-slot:body>
        </x-box-input>

        <div class="mt-3 row justify-content-end">
            <div class="col-auto">
                <a href="{{ route('auditorias.index') }}" class="btn btn-secondary me-2">Voltar</a>
                @if(count($mensagens) != 0)
                    <button onclick="toggle()" id="btn-toggle" class="btn btn-primary">Visualização em tabela</button>
                @endif
            </div>
        </div>
    </x-adminlte-card>
@endsection

@section('js')
    <script>
        var log = document.getElementById('log');
        var tabela = document.getElementById('tabela');
        var button = document.getElementById('btn-toggle');
        
        function toggle() {
            if (log.style.display == 'none') {
                button.innerHTML = 'Visualização em tabela';
                log.style.display = 'block';
                tabela.style.display = 'none';
            } else {
                button.innerHTML = 'Visualização em log';
                log.style.display = 'none';
                tabela.style.display = 'block';
            }
        }
    </script>
@endsection
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('css')
    <style scoped>
        p {
            font-size: 1rem;
        }

        .box-input {
            max-height: 55vh !important;
        }

        .justify-content-end {
            padding-bottom: 1rem !important;
        }
    </style>
@endsection