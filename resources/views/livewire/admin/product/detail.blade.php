<form wire:submit.prevent="save">
    <div class="row">
        <div class="col-md-12">
            <div class="page-separator">
                <div class="page-separator__text">Informasi Dasar</div>
            </div>

            <div class="card">
                <div class="card-body">

                    {{-- NAME --}}
                    <div class="form-group">
                        <label class="form-label" for="name">Nama Produk :</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            wire:model.lazy="name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{-- PRICE --}}
                            <div class="form-group">
                                <label class="form-label" for="title">Harga :</label>
                                <input type="number" class="form-control  @error('price') is-invalid @enderror "
                                    wire:model.lazy="price" step="0.01" min="0">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- PRICE BEFORE DISCOUNT --}}
                            <div class="form-group">
                                <label class="form-label" for="title">Harga Sebelum Diskon :</label>
                                <input type="number" class="form-control  @error('price_before_discount') is-invalid @enderror "
                                    wire:model.lazy="price_before_discount" step="0.01" min="0">
                                @error('price_before_discount')
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

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-info" type="button" wire:click="addCourse">
                                <i class="fa fa-plus"></i>
                                Tambah Kursus Online
                            </button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-success" type="button" wire:click="addOfflineCourse">
                                <i class="fa fa-plus"></i>
                                Tambah Kursus Offline
                            </button>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="card w-100 mx-auto">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table text-nowrap">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Nama Kursus</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($courses as $index => $course)
                                                        <tr>
                                                            <td>
                                                                <div class="form-group mb-2" wire:ignore>
                                                                    <select class="form-control select2-course"
                                                                        data-index="{{ $index }}" data-new="1">
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-outline-danger"
                                                                    wire:click="removeCourse('{{ $index }}', true)"><i
                                                                        class='fa fa-trash mr-2'></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tbody>
                                                    @foreach ($course_olds as $index => $course)
                                                        <tr>
                                                            <td>
                                                                <div class="form-group mb-2" wire:ignore>
                                                                    <select class="form-control select2-course"
                                                                        data-index="{{ $index }}" data-new="0">
                                                                        <option value="{{$course['course_id']}}" selected>{{$course['title']}}</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-outline-danger"
                                                                    wire:click="removeCourse('{{ $index }}', false, '{{ $course['id'] }}')"><i
                                                                        class='fa fa-trash mr-2'></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="card w-100 mx-auto">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table text-nowrap">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Nama Kursus</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($offline_courses as $index => $offline_course)
                                                        <tr>
                                                            <td>
                                                                <div class="form-group mb-2" wire:ignore>
                                                                    <select class="form-control select2-offline-course"
                                                                        data-index="{{ $index }}" data-new="1">
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-outline-danger"
                                                                    wire:click="removeOfflineCourse('{{ $index }}', true)"><i
                                                                        class='fa fa-trash mr-2'></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tbody>
                                                    @foreach ($offline_course_olds as $index => $offline_course)
                                                        <tr>
                                                            <td>
                                                                <div class="form-group mb-2" wire:ignore>
                                                                    <select class="form-control select2-course"
                                                                        data-index="{{ $index }}" data-new="0">
                                                                        <option value="{{$offline_course['course_id']}}" selected>{{$offline_course['title']}}</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-outline-danger"
                                                                    wire:click="removeOfflineCourse('{{ $index }}', false, '{{ $offline_course['id'] }}')"><i
                                                                        class='fa fa-trash mr-2'></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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


    </div>
</form>

@push('js')
    <script>
        document.addEventListener('livewire:load', function() {
            initSelect2()
            window.livewire.on('reInitSelect2', () => {
                initSelect2()
            });
            function initSelect2() {
                $('.select2-course').select2({
                    minimumInputLength: 1,
                    width: '100%',
                    theme: 'bootstrap4',
                    placeholder: "Cari dan Pilih Kursus Online",
                    ajax: {
                        url: "{{ route('admin.product.get.course') }}",
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
                                        "id": item.id,
                                        "text": item.text,
                                    }
                                })
                            };
                        },
                    }
                });

                $(".select2-course").on("select2:select", (e) => {
                    let index = $(e.target).attr('data-index');
                    let is_new = $(e.target).attr('data-new');
                    let data = e.params.data.id;

                    @this.call('setCourse', index, data, is_new);
                })

                $('.select2-offline-course').select2({
                    minimumInputLength: 1,
                    width: '100%',
                    theme: 'bootstrap4',
                    placeholder: "Cari dan Pilih Kursus Offline",
                    ajax: {
                        url: "{{ route('admin.product.get.offline_course') }}",
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
                                        "id": item.id,
                                        "text": item.text,
                                    }
                                })
                            };
                        },
                    }
                });

                $(".select2-offline-course").on("select2:select", (e) => {
                    let index = $(e.target).attr('data-index');
                    let is_new = $(e.target).attr('data-new');
                    let data = e.params.data.id;

                    @this.call('setOfflineCourse', index, data, is_new);
                })
            }
        });
    </script>
@endpush
