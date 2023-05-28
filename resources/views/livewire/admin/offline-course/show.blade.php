<div class="row">
    <div wire:ignore class="col-md-6">
        <div class="page-separator">
            <div class="page-separator__text">Informasi Dasar</div>
        </div>

        <div class="card">
            <div class="card-body">
                <img class="img-fluid" src="{{ $image }}" style="max-height:300px; object-fit:contain">
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <br>
                    @foreach ($categories as $key => $name)
                        <div class="btn btn-outline-info btn-sm mt-1">{{ $name }}</div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Judul :</label>
                    <input type="text" class="form-control" wire:model.lazy="title" disabled>
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Quota :</label>
                    <input type="number" class="form-control" wire:model.lazy="quota" disabled>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="title">Tanggal dan Waktu Mulai :</label>
                            <input type="datetime-local" class="form-control" wire:model.lazy="date_time_start"
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="title">Tanggal dan Waktu Selesai :</label>
                            <input type="datetime-local" class="form-control" wire:model.lazy="date_time_end" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi :</label>
                    <textarea class="form-control" wire:model.lazy="description" rows="6" disabled></textarea>
                </div>

                {{-- ATTACHMENT --}}
                <hr>
                <div class="form-group">
                    <label class="form-label">Lampiran</label>
                    <br>
                    @foreach ($attachments as $index => $item)
                        <div class="row border rounded align-items-center p-2 ml-2 mr-2">
                            <div class="col">
                                <h5 class="p-0 m-0">{{ $index + 1 }}. {{ $item['title'] }}</h5>
                            </div>
                            <div class="col-auto">
                                <a target="_blank" href="{{ $item['file'] }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-file mr-1"></i>
                                    Buka File
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- LINK --}}
                <hr>
                <div class="form-group">
                    <label class="form-label">Materi Bacaan</label>
                    <br>
                    @foreach ($links as $index => $item)
                        <div class="row border rounded align-items-center p-2 ml-2 mr-2">
                            <div class="col">
                                <h5 class="p-0 m-0">{{ $index + 1 }}. {{ $item['title'] }}</h5>
                            </div>
                            <div class="col-auto">
                                <a target="_blank" href="{{ $item['url'] }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-link mr-1"></i>
                                    Buka Link
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- VIDEO --}}
                <hr>
                <div class="form-group">
                    <label class="form-label">Materi Video</label>
                    <br>
                    @foreach ($videos as $index => $item)
                        <div class="row border rounded align-items-center p-2 ml-2 mr-2">
                            <div class="col">
                                <h5 class="p-0 m-0">{{ $index + 1 }}. {{ $item['title'] }}</h5>
                            </div>
                            <div class="col-auto">
                                <a target="_blank" href="{{ $item['video'] }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-link mr-1"></i>
                                    Buka Link
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card dashboard-area-tabs p-relative o-hidden mb-0">
            <div class="card-header p-0 nav">
                <div class="row no-gutters" role="tablist">
                    <div class="col-auto">
                        <a href="#" data-toggle="tab" id="tab_registrar" data-target="#panel_registrar"
                            role="tab" aria-selected="true" wire:click="$set('active_tab', 'registrar')"
                            class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start {{ $active_tab == 'registrar' ? 'active' : '' }}">
                            <span class="h2 mb-0 mr-3">{{ $count_registrar }}</span>
                            <span class="flex d-flex flex-column">
                                <strong class="card-title">Pendaftar</strong>
                                <small class="card-subtitle text-50">Kursus Offline</small>
                            </span>
                        </a>
                    </div>
                    <div class="col-auto border-left border-right">
                        <a href="#" data-toggle="tab" id="tab_attendance" data-target="#panel_attendance"
                            role="tab" aria-selected="true" wire:click="$set('active_tab', 'attendance')"
                            class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start  {{ $active_tab == 'attendance' ? 'active' : '' }}">
                            <span class="h2 mb-0 mr-3">{{ $count_attendance }}</span>
                            <span class="flex d-flex flex-column">
                                <strong class="card-title">Kehadiran</strong>
                                <small class="card-subtitle text-50">Kursus Offline</small>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body tab-content">
                <div class="tab-pane text-70 {{ $active_tab == 'registrar' ? 'active' : '' }}" id="panel_registrar"
                    role="tabpanel" aria-labelledby="tab_registrar">
                    <form wire:submit.prevent="saveRegistrar">
                        <div wire:ignore class="form-group">
                            <label class="form-label">Peserta</label>
                            <select id="registrar_user_id" class="form-control custom-select select2"></select>
                        </div>

                        @error('registrar_user_id')
                            <div class='text-danger font-weight-bold'>{{ $message }}</div>
                        @enderror

                        <button type="submit" id="btn_submit_registrar" class="btn btn-primary px-4">
                            Tambah Pendaftar
                        </button>
                    </form>

                    <hr>
                    @livewire('admin.offline-course-registrar.datatable', ['offline_course_id' => $offline_course_id])
                </div>

                <div class="tab-pane text-70 {{ $active_tab == 'attendance' ? 'active' : '' }}" id="panel_attendance"
                    role="tabpanel" aria-labelledby="tab_attendance">
                    <form wire:submit.prevent="saveAttendance">
                        <div wire:ignore class="form-group">
                            <label class="form-label">Pendaftar</label>
                            <select id="attendance_user_id" class="form-control custom-select select2"></select>
                        </div>

                        @error('attendance_user_id')
                            <div class='text-danger font-weight-bold'>{{ $message }}</div>
                        @enderror

                        <button type="submit" id="btn_submit_attendance" class="btn btn-primary px-4">
                            Tambah Kehadiran
                        </button>
                    </form>

                    <hr>
                    @livewire('admin.offline-course-attendance.datatable', ['offline_course_id' => $offline_course_id])
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(() => {
            $('#registrar_user_id').select2({
                placeholder: "Pilih Peserta",
                minimumInputLength: 3,
                ajax: {
                    url: "{{ route('admin.user.select2') }}",
                    dataType: "json",
                    type: "GET",
                    data: function(params) {
                        return {
                            search: params.term,
                            role: "{{ App\Models\User::MEMBER }}",
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

            $('#btn_submit_registrar').click(() => {
                @this.set('registrar_user_id', $('#registrar_user_id').val());
                $('#registrar_user_id').val('').trigger('change');
            })

            $('#attendance_user_id').select2({
                placeholder: "Pilih Pendaftar",
                minimumInputLength: 3,
                ajax: {
                    url: "{{ route('admin.offline_course_registrar.select2') }}",
                    dataType: "json",
                    type: "GET",
                    data: function(params) {
                        return {
                            search: params.term,
                            offline_course_id: "{{ $offline_course_id }}",
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

            $('#attendance_user_id').change(() => {});

            $('#btn_submit_attendance').click(() => {
                @this.set('attendance_user_id', $('#attendance_user_id').val());
                $('#attendance_user_id').val('').trigger('change');
            })
        });
    </script>
@endpush
