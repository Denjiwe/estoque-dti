@props(['titulo', 'header', 'body', 'footer', 'id'])

<div class="box" id="{{ $id ?? '' }}" >
    <div class="box-header"><h2>{{$titulo ?? ''}}</h2>
        {{$header ?? ''}}
    </div>

    <div class="box-body">
        {{$body}}
    </div>

    <div class="box-footer">
        {{ $footer ?? ''}}
    </div>
</div>

<style scoped>
    .box {
        background-color: white;
        border-radius: 10px;
        border: 1px solid #dbdbdb;
        box-shadow: 1px black solid;
        padding: 15px;
        padding-bottom: 1rem;
        display: flex;
        flex-direction: column;
    }

    .box-footer {
        margin-top: auto;
    }
    
    #searchBox {
        height: 15vh;
        margin-bottom: 1rem;
    }

    #main {
        height: 69vh;
        padding-bottom: 0 !important;
    }

    @media (max-height: 940px) {
        #searchBox {
            height: 18vh;
        }

        #main {
            height: 71vh;
        }
    }
</style>