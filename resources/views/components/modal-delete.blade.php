<div class="modal fade" id="{{$action}}Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center my-4">Anda yakin ingin hapus {{$action}} ini ?</div>
                    <form action="" id="modal-{{$action}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-around w-100">
                            <button type="button" onclick="cancelDeleteModal(this, 'modal-{{$action}}')" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel
                            </button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>