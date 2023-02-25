<div class="modal fade" id="add_learn_description_modal" tabindex="-1" role="dialog"
    aria-labelledby="add_learn_description_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="import-modal-title">Tambah Poin Pembelajaran {{ $data['ctitle'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label" for="add_learn_description_description">Deskripsi <span class="text-danger">*</span> :</label>
                            <input type="text" class="form-control" id="add_learn_description_description" name="add_learn_description_description">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary px-4" id="btn_store_learn_description" name="btn_store_learn_description">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>