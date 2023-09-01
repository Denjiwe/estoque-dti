@props(['titulo', 'header', 'body', 'footer'])

<div class="box-input mb-4" style="width: 100%;">
    <div class="box-input-header"><h2 class="mt-2">{{$titulo ?? ''}}</h2></div>

    <x-adminlte-card>
        {{$body}}

        {{ $footer ?? ''}}
    </x-adminlte-card>
</div>

<style scoped>
    .box-input {
        width: 100%;
        background-color: #9cacb9;
        border-radius: 10px;
        border: 1px solid #dbdbdb;
        box-shadow: 1px black solid;
        padding: 15px;
        box-shadow: inset 10px 11px 21px 5px rgba(0,0,0,0.29);
        max-height: 45vh;
        overflow-y: auto;
    }
</style>