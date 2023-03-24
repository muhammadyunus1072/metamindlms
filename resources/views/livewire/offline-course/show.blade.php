<div class="row">
    <div wire:ignore class="col-md-6">
        <div class="page-separator">
            <div class="page-separator__text">Informasi Dasar</div>
        </div>

        <div class="card">
            <div class="card-body">
                <img class="img-fluid" src="{{ $image }}" style="max-height:300px; object-fit:contain">
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

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <br>
                    @foreach ($categories as $key => $name)
                        <div class="btn btn-outline-primary btn-sm mt-1">{{ $name }}</div>
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
                            role="tab" aria-selected="true"
                            class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start active">
                            <span class="h2 mb-0 mr-3">{{ $count_registrar }}</span>
                            <span class="flex d-flex flex-column">
                                <strong class="card-title">Pendaftar</strong>
                                <small class="card-subtitle text-50">Kursus Offline</small>
                            </span>
                        </a>
                    </div>
                    <div class="col-auto border-left border-right">
                        <a href="#" data-toggle="tab" id="tab_attendance" data-target="#panel_attendance"
                            role="tab" aria-selected="true"
                            class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start">
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
                <div class="tab-pane active text-70" id="panel_registrar" role="tabpanel"
                    aria-labelledby="tab_registrar">
                    @livewire('offline-course-registrar.datatable', ['offline_course_id' => $offline_course_id])
                </div>

                <div class="tab-pane text-70" id="panel_attendance" role="tabpanel" aria-labelledby="tab_attendance">
                    @livewire('offline-course-attendance.datatable', ['offline_course_id' => $offline_course_id])
                </div>
            </div>
        </div>
    </div>
</div>

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
