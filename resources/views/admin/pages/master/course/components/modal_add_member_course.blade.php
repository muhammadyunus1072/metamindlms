<div class="modal fade" id="add_member_course_modal" tabindex="-1" role="dialog"
    aria-labelledby="add_member_course_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="import-modal-title">Tambah Member {{ $data['ctitle'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label" for="add_member_course_member_id">Member <span class="text-danger">*</span> :</label>
                            <select name="add_member_course_member_id" id="add_member_course_member_id" class="form-control custom-select select2">
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary px-4" id="btn_store_member_course" name="btn_store_member_course">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>