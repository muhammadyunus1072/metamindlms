<form wire:submit.prevent='store'>
    <div class="card-body">

        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label class="form-label" for="name">Nama :</label>
                    <input type="text" class="form-control" wire:model.lazy="paymend_method_name">
                </div>

                <div class="col-6">
                    <label class="form-label" for="description">Deskripsi :</label>
                    <textarea class="form-control" wire:model.lazy="paymend_method_description" rows="4"></textarea>
                </div>
                <div class="col-md-12">
                    {{-- CONTENT --}}
                    <div class="form-group" wire:ignore>
                        <label class="form-label" for="content">Instruksi :</label>
                        <div>
                            <textarea class="form-control" wire:model.lazy="paymend_method_instruction" rows="6" id="paymend_method_instruction"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-sm-12 text-right">
                <button type="button" onclick="history.back();" class="btn btn-outline-primary px-4">Kembali</button>
                <button type="submit" class="btn btn-primary px-4">Simpan</button>
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        var paymend_method_instructionEditor;
        $(() => {
            paymend_method_instructionEditor = CKEDITOR.replace('paymend_method_instruction', {
                height: '25em',
                removePlugins: 'image',
            });

            paymend_method_instructionEditor.on('change', function(evt) {
                @this.set('paymend_method_instruction', evt.editor.getData());
            });

        });
    </script>
@endpush