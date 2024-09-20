<!-- Default Modals -->
<div id="{{ $id }}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog {{ $class ? $class : "" }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{$id}}Label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="action" id="action">
                <input type="hidden" name="id" id="id">

                {{ $slot }}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
