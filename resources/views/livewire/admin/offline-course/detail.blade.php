<form wire:submit.prevent="save">
    <div class="row">
        <div class="col-md-12">
            <div class="page-separator">
                <div class="page-separator__text">Informasi Dasar</div>
            </div>

            <div class="card">
                <div class="card-body">

                    {{-- TITLE --}}
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

                    {{-- CATEGORIES --}}
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

                    {{-- QUOTA --}}
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

                    {{-- DATE TIME --}}
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

                    {{-- DESCRIPTION --}}
                    <div class="form-group">
                        <label class="form-label" for="description">Deskripsi Singkat :</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" wire:model.lazy="description" rows="6"></textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- URL ONLINE MEET --}}
                    <div class="form-group" wire:ignore>
                        <label class="form-label" for="url_online_meet">Online Meet (Zoom / Google Meet) :</label>
                        <div>
                            <textarea class="form-control" wire:model.lazy="url_online_meet" rows="4" id="url_online_meet"></textarea>
                        </div>
                    </div>

                    {{-- CONTENT --}}
                    <div class="form-group" wire:ignore>
                        <label class="form-label" for="content">Konten :</label>
                        <div>
                            <textarea class="form-control" wire:model.lazy="content" rows="6" id="content"></textarea>
                        </div>
                    </div>

                    {{-- IMAGE --}}
                    <div class="form-group">
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

                    {{-- ATTACHMENT --}}
                    <hr>
                    <div class="form-group">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <label class="form-label">Lampiran:</label>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-info btn-sm" wire:click="addAttachment">
                                    <i class='fa fa-plus mr-1'></i>
                                    Tambah Lampiran
                                </button>
                            </div>
                        </div>

                        @foreach ($attachments as $index => $item)
                            <div class="row align-items-end mb-3">
                                <div class="col-md-auto">
                                    <button type="button" class="btn btn-danger"
                                        wire:click="deleteAttachment('{{ $item['id'] }}')">
                                        <i class='fa fa-times'></i>
                                    </button>
                                </div>
                                <div class="col-md-7">
                                    <label>Judul</label>
                                    <input type="text" class="form-control"
                                        wire:model.lazy="attachments.{{ $index }}.title">
                                </div>
                                <div class="col-md">
                                    <label>File</label>
                                    <div class="custom-file">
                                        <input type="file" wire:model.lazy="attachments.{{ $index }}.file"
                                            class="custom-file-input">
                                        <label class="custom-file-label">
                                            <div wire:loading.remove
                                                wire:target="attachments.{{ $index }}.file">
                                                @if ($attachments[$index]['file'])
                                                    @if ($attachments[$index]['file'] instanceof Livewire\TemporaryUploadedFile)
                                                        {{ $attachments[$index]['file']->getClientOriginalName() }}
                                                    @else
                                                        {{ $attachments[$index]['file_name'] }}
                                                    @endif
                                                @else
                                                    Pilih File
                                                @endif
                                            </div>
                                            <div wire:loading wire:target="attachments.{{ $index }}.file">
                                                Uploading...
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- LINKS --}}
                    <hr>
                    <div class="form-group">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <label class="form-label">Materi Bacaan:</label>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-info btn-sm" wire:click="addLink">
                                    <i class='fa fa-plus mr-1'></i>
                                    Tambah Materi Bacaan
                                </button>
                            </div>
                        </div>

                        @foreach ($links as $index => $item)
                            <div class="row align-items-end mb-3">
                                <div class="col-md-auto">
                                    <button type="button" class="btn btn-danger"
                                        wire:click="deleteLink('{{ $item['id'] }}')">
                                        <i class='fa fa-times'></i>
                                    </button>
                                </div>
                                <div class="col-md">
                                    <label>Judul</label>
                                    <input type="text" class="form-control"
                                        wire:model.lazy="links.{{ $index }}.title">
                                </div>
                                <div class="col-md">
                                    <label>URL / Link</label>
                                    <input type="text" class="form-control"
                                        wire:model.lazy="links.{{ $index }}.url">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- VIDEO --}}
                    <hr>
                    <div class="form-group">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <label class="form-label">Materi Video:</label>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-info btn-sm" wire:click="addVideo">
                                    <i class='fa fa-plus mr-1'></i>
                                    Tambah Materi Video
                                </button>
                            </div>
                        </div>

                        @foreach ($videos as $index => $item)
                            <div class="row align-items-end mb-3">
                                <div class="col-md-auto">
                                    <button type="button" class="btn btn-danger"
                                        wire:click="deleteVideo('{{ $item['id'] }}')">
                                        <i class='fa fa-times'></i>
                                    </button>
                                </div>
                                <div class="col-md">
                                    <label>Judul</label>
                                    <input type="text" class="form-control"
                                        wire:model.lazy="videos.{{ $index }}.title">
                                </div>
                                <div class="col-md">
                                    <label>URL / Link</label>
                                    <input type="text" class="form-control"
                                        wire:model.lazy="videos.{{ $index }}.video">
                                </div>
                            </div>
                        @endforeach
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


    </div>
</form>

@push('js')
    <script>
        var contentEditor;
        var urlOnlineMeetEditor;
        $(() => {
            contentEditor = CKEDITOR.replace('content', {
                height: '25em',
                removePlugins: 'image',
            });

            urlOnlineMeetEditor = CKEDITOR.replace('url_online_meet', {
                height: '25em',
                removePlugins: 'image',
            });

            contentEditor.on('change', function(evt) {
                @this.set('content', evt.editor.getData());
            });

            urlOnlineMeetEditor.on('change', function(evt) {
                @this.set('url_online_meet', evt.editor.getData());
            });

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
