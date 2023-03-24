<form wire:submit.prevent="save">
    <div class="row">
        <div class="col-md-8">
            <div class="page-separator">
                <div class="page-separator__text">Informasi Dasar</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="title">Judul :</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            wire:model.lazy="title">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="title">Quota :</label>
                        <input type="number" class="form-control  @error('quota') is-invalid @enderror "
                            wire:model.lazy="quota">
                        @error('quota')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="title">Tanggal dan Waktu Mulai :</label>
                                <input type="datetime-local"
                                    class="form-control  @error('date_time_start') is-invalid @enderror"
                                    wire:model.lazy="date_time_start">
                                @error('date_time_start')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="title">Tanggal dan Waktu Selesai :</label>
                                <input type="datetime-local"
                                    class="form-control  @error('date_time_end') is-invalid @enderror"
                                    wire:model.lazy="date_time_end">
                                @error('date_time_end')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Deskripsi :</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" wire:model.lazy="description" rows="6"></textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="image">Foto :</label>
                                <div class="custom-file">
                                    <input type="file" wire:model.lazy="image"
                                        class="custom-file-input  @error('image') is-invalid @enderror">
                                    <label for="image" class="custom-file-label">
                                        <div wire:loading.remove wire:target="image">
                                            @if ($image)
                                                {{ $image->getClientOriginalName() }}
                                            @else
                                                Pilih Gambar
                                            @endif
                                        </div>
                                        <div wire:loading wire:target="image">
                                            Uploading...
                                        </div>
                                    </label>
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                @if ($image && empty($errors->get('image')))
                                    <img class="img-fluid" src="{{ $image->temporaryUrl() }}"
                                        style="width: 300px; height:auto">
                                @elseif($oldImage != null)
                                    <img class="img-fluid" src="{{ $oldImage }}" style="width: 300px; height:auto">
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button wire:loading.remove wire:target="save" type="button" onclick="history.back();"
                                class="btn btn-outline-primary px-4">
                                Kembali
                            </button>
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="page-separator">
                <div class="page-separator__text">Kategori</div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div wire:ignore class="form-group">
                        <label class="form-label">Kategori</label>
                        <select id="categories" multiple="multiple" class="form-control custom-select select2">
                            @foreach ($oldCategories as $key => $name)
                                <option value="{{ $key }}" selected>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('categories')
                        <div class='text-danger font-weight-bold'>{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</form>

@push('js')
    <script>
        $(() => {
            $('#categories').select2({
                placeholder: "Pilih Kategori",
                ajax: {
                    url: "{{ route('admin.offline_course.select2.category') }}",
                    dataType: "json",
                    type: "GET",
                    data: function(params) {
                        return {
                            search: params.term,
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    "text": item.text,
                                    "id": item.id,
                                }
                            })
                        };
                    },
                    error: function(xhr, res, result) {
                        alert_error("hide", xhr);
                    }
                },
                cache: true
            });

            $('#categories').change(() => {
                let data = $('#categories').val();
                @this.set('categories', data);
            });

        });
    </script>
@endpush
