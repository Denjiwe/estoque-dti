<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo')</title>

    @vite(['resources/js/app.js'])

</head>
<body style="background-color: gainsboro">
    <div id="app">
        @include('_layouts._partials.navAdm')
        <main class="py-4">
            @yield('conteudo')
        </main>
    </div>
</body>
</html>