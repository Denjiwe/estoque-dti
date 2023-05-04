@props(['id', 'titulo', 'alerts', 'body', 'footer'])

<!-- Modal -->
<div class="modal fade" id="{{$id}}" tabindex="-1" aria-labelledby="modal{{$id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal{{$id}}">{{ $titulo }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $alerts ?? ''}}
                {{ $body }}
            </div>
            <div class="modal-footer">
                {{ $footer ?? ''}}
            </div>
        </div>
    </div>
</div>
<!-- fim modal -->