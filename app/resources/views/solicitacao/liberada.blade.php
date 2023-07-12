<x-mail::message>
    {{ $saudacao }}, {{ $nome }}! sua solicitação #{{ $id }} foi liberada e está disponível para retirada. <br><br>
    Atenciosamente, <br> 
    {{ config('app.name') }}
</x-mail::message>