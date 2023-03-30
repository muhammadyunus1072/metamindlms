<form wire:submit.prevent='save'>
    <button type="submit" class="btn btn-primary px-4">
        <i class="fa fa-edit mr-3"></i>
        Simpan Perubahan
    </button>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="page-separator">
                <div class="page-separator__text">Informasi Dasar</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label" for="title">Judul :</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    wire:model.lazy="title">
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea rows="6" class="form-control" wire:model.lazy="description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <div class="custom-control custom-checkbox">
                                    <input id="can_preview" name="can_preview" type="checkbox"
                                        class="custom-control-input" wire:model.lazy='can_preview'>
                                    <label for="can_preview" class="custom-control-label">Bisa di Preview</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="page-separator">
                <div class="page-separator__text">Daftar Pertanyaan</div>
            </div>

            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-info" wire:click="addQuestion">
                        <i class="fa fa-plus mr-2"></i> Tambah Pertanyaan
                    </button>
                </div>
                <div class="card-body">
                    @foreach ($questions as $questionKey => $question)
                        <div class="border rounded p-3 mt-2 position-relative">
                            <button type="button" class="btn btn-danger btn-sm position-absolute"
                                style="top:8px; right:8px; z-index:1" wire:click='removeQuestion({{ $questionKey }})'>
                                <i class="fa fa-times"></i>
                            </button>

                            <div class="row">
                                <div class="col-12 col-sm-3 col-md-2 col-lg-1">
                                    <div class="form-group">
                                        <label>Urutan</label>
                                        <input type="number"
                                            class="form-control"wire:model.lazy='questions.{{ $questionKey }}.number'>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Pertanyaan</label>
                                        <textarea class="form-control" rows="3" wire:model.lazy='questions.{{ $questionKey }}.text'></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row mb-3">
                                        <div class="col-auto">
                                            <label>Pilihan Jawaban</label>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-info btn-sm"
                                                wire:click="addChoice({{ $questionKey }})">
                                                <i class="fa fa-plus mr-2"></i> Tambah Pilihan Jawaban
                                            </button>
                                        </div>
                                    </div>

                                    @foreach ($question['choices'] as $choiceKey => $choice)
                                        <div class="row align-items-center mt-2">
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    wire:click='removeChoice({{ $questionKey }}, {{ $choiceKey }})'>
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="col-auto">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="is_correct_{{ $questionKey }}_{{ $choiceKey }}"
                                                        wire:model="questions.{{ $questionKey }}.choices.{{ $choiceKey }}.is_correct">
                                                    <label for="is_correct_{{ $questionKey }}_{{ $choiceKey }}"
                                                        class="custom-control-label">Kunci Jawaban</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="text" class="form-control"
                                                        wire:model.lazy="questions.{{ $questionKey }}.choices.{{ $choiceKey }}.text">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</form>
