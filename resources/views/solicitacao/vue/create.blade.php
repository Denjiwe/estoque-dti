<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitar</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app">
        <layout nome="{{ auth()->user()->nome }}">
            <solicitar></solicitar>
        </layout>
    </div>
</body>
</html>