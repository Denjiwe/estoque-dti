@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>Bem-vindo, {{ explode(' ', auth()->user()->nome)[0] }}!</h1>
@endsection

@section('content')
<div class="row ms-1 me-1">
    <div class="col-12 col-xl-8">
        <div class="row">
            <div class="col-6 col-lg-3">
                <x-adminlte-info-box title="Entregas" text="{{ $entregas }}" icon="fas fa-lg fa-clipboard-check text-dark" theme="gradient-teal" icon-theme="white"/>
            </div>
            <div class="col-6 col-lg-3">
                <x-adminlte-info-box title="Solicitações" text="{{ $solicitacoes }}" icon="fas fa-lg fa-clipboard text-dark" theme="danger" icon-theme="white"/>
            </div>
            <div class="col-6 col-lg-3">
                <x-adminlte-info-box title="Usuários" text="{{ $usuarios }}" icon="fas fa-lg fa-user text-dark" theme="gradient-primary" icon-theme="white"/>
            </div>
            <div class="col-6 col-lg-3">
                <x-adminlte-info-box title="Produtos" text="{{ $produtos }}" icon="fas fa-lg fa-kaaba text-dark" theme="gradient-secondary" icon-theme="white"/>
            </div>
        </div>
        <x-adminlte-card theme="purple" icon="fas fa-lg fa-chart-area mt-2">
            <div id="solicitacoes_chart"></div>
        </x-adminlte-card>
    </div>
    <div class="col-12 col-xl-4">
        <x-adminlte-profile-widget name="{{ auth()->user()->nome }}" theme="primary">
            <x-adminlte-profile-col-item class="text-primary border-right" icon="fas fa-lg fa-clipboard-check"
            title="Entregas" text="{{ $entregasUserCount }}" size=6 badge="primary"/>
            <x-adminlte-profile-col-item class="text-success" icon="fas fa-lg fa-clipboard-list" title="Chamados Encerrados"
            text="{{ $solicitacoesUserCount }}" size=6 badge="success"/>
        </x-adminlte-profile-widget>
        <x-adminlte-card theme="warning" icon="fas fa-lg fa-chart-bar mt-2">
            <div id="entregas_chart"></div>
        </x-adminlte-card>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Dia');
        data.addColumn('number', 'Abertas');
        data.addColumn('number', 'Liberadas');
        data.addColumn('number', 'Aguardando');
        data.addColumn('number', 'Encerradas');
        
        data.addRows([{!! $solicitacoesChart !!}]);
    
    var options = {
        chart: {
            title: 'Solicitações do mês',
            subtitle: 'Últimos 30 dias',
        },
        hAxis: {
            format: 'dd/mM/yy',
            gridlines: {count: 1},
        },
        vAxis: {
            viewWindow: {
                max: 10,
            },
        },
        height: 620,
        
    };

        var chart = new google.charts.Line(document.getElementById('solicitacoes_chart'));

        chart.draw(data, google.charts.Line.convertOptions(options));
    }
</script>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Produto", "Quantidade"],
            {!! $entregasFormatadas !!},
        ]);

        var view = new google.visualization.DataView(data);

        var options = {
            title: "Produtos mais entregues neste mês",
            height: 412.5,
            legend: { position: "none" },
            hAxis: {
                viewWindow: {
                    max: 30,
                },
            },
            vAxis: {
                viewWindow: {
                    max: 10,
                },
            },
        };
        var chart = new google.visualization.BarChart(document.getElementById("entregas_chart"));
        chart.draw(view, options);
    }
</script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection