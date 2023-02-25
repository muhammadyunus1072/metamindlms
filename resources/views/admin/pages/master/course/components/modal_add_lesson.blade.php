<div class="modal fade" id="add_lesson_modal" tabindex="-1" role="dialog"
    aria-labelledby="add_lesson_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form-add-lesson" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="import-modal-title">Tambah Pelajaran {{ $data['ctitle'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="add_lesson_section_id" id="add_lesson_section_id">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label" for="add_lesson_title">Judul <span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control" id="add_lesson_title" name="add_lesson_title">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="add_lesson_position">Urutan Ke <span class="text-danger">*</span> :</label>
                                <input type="number" class="form-control" id="add_lesson_position" name="add_lesson_position" min="1">
                            </div>
    
                            <div class="col-6">
                                <label class="form-label" for="add_lesson_type">Jenis Pelajaran :</label>
                                <select name="add_lesson_type" id="add_lesson_type" class="form-control custom-select">
                                    <option value="video" selected>{{ master_string('video') }}</option>
                                    <option value="quiz">{{ master_string('quiz') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary px-4" id="btn_store_lesson" name="btn_store_lesson">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>