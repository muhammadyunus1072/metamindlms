<div class="modal fade" id="add_section_modal" tabindex="-1" role="dialog"
    aria-labelledby="add_section_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form-add-section" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="import-modal-title">Tambah Konten {{ $data['ctitle'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label" for="add_section_title">Judul <span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control" id="add_section_title" name="add_section_title">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="add_section_position">Urutan Ke <span class="text-danger">*</span> :</label>
                                <input type="number" class="form-control" id="add_section_position" name="add_section_position" min="1">
                            </div>
    
                            <div class="col-6">
                                <label class="form-label" for="add_section_is_actived">Status Konten :</label>
                                <select name="add_section_is_actived" id="add_section_is_actived" class="form-control custom-select">
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary px-4" id="btn_store_section" name="btn_store_section">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>