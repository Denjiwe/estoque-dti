@props(['titulo', 'body', 'footer'])

<div class="box mb-4" style="width: 100%;">
    <div class="box-header"><h2 class="mt-2">{{$titulo}}</h2></div>

    <div class="box-body">
        {{$body}}
    </div>

    <div class="box-footer">
        {{ $footer ?? ''}}
    </div>
</div>

<style>
    .box {
        width: 100%;
        background-color: white;
        border-radius: 10px;
        border: 1px solid #dbdbdb;
        box-shadow: 1px black solid;
        padding: 15px;
    }
</style>