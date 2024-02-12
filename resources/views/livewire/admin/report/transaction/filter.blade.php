<div class="row mb-2">
    {{-- FILTER --}}
    <div class="col-md-3 mb-2">
        <div class="form-group">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" wire:model="start_date" />
        </div>
    </div>
    <div class="col-md-3 mb-2">
        <div class="form-group">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" class="form-control" wire:model="end_date" />
        </div>
    </div>
    <div class="col-md-3 mb-2" wire:ignore>
        <label>Status</label>
        <select class="form-control" id="select2-status" multiple="multiple">
            @foreach (App\Models\TransactionStatus::STATUS_CHOICE as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 mb-2" wire:ignore>
        <label>Metode Pembayaran</label>
        <select class="form-control" id="select2-payment-method" multiple="multiple">
        </select>
    </div>
    <div class="col-md-3 mb-2" wire:ignore>
        <label>Member</label>
        <select class="form-control" id="select2-member" multiple="multiple">
        </select>
    </div>
    <div class="col-md-3 mb-2" wire:ignore>
        <label>Product</label>
        <select class="form-control" id="select2-product" multiple="multiple">
        </select>
    </div>
    <div class="col-md-3 mb-2" wire:ignore>
        <label>Kursus Online</label>
        <select class="form-control" id="select2-course" multiple="multiple">
        </select>
    </div>
    <div class="col-md-3 mb-2" wire:ignore>
        <label>Kursus Offline</label>
        <select class="form-control" id="select2-offline-course" multiple="multiple">
        </select>
    </div>

    {{-- EXPORT --}}
    <div class="row col-12 mt-2">
        <div class="col-auto">
            <label>Export Data:</label>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-success btn-sm" wire:click="$emit('export')">
                <i class="fa fa-file-excel"></i>
                Export Excel
            </button>
        </div>
    </div>
    {{-- Card Total --}}
    <div class="row col-12 d-flex align-items-stretch my-4">
        <div class="col-md-3 mb-2">
            <div class="card bg-primary">
                <div class="card-header text-white text-center">
                    <h6>Total Nilai</h6>
                </div>
                <div class="card-body text-white text-center">
                    <h3>{{ $total_price }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-danger">
                <div class="card-header text-white text-center">
                    <h6>Jumlah Transaksi</h6>
                </div>
                <div class="card-body text-white text-center">
                    <h3>{{ $total_transaction }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.emit('getTotalHeader');
        });
        $('#select2-status').select2({
            placeholder: "Seluruh Status",
        });

        $("#select2-status").on('change', async function(e) {
            let data = $('#select2-status').val();
            @this.statuses = data;
        });
        // Select2 Member
        $('#select2-member').select2({
            minimumInputLength: 1,
            width: '100%',
            theme: 'bootstrap4',
            placeholder: "Cari dan Pilih Member",
            ajax: {
                url: "{{ route('admin.report.transaction.get.member') }}",
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

        $("#select2-member").on('change', async function(e) {
            let data = $('#select2-member').val();
            @this.members = data;
        });

        // Select2 Product
        $('#select2-product').select2({
            minimumInputLength: 1,
            width: '100%',
            theme: 'bootstrap4',
            placeholder: "Cari dan Pilih Product",
            ajax: {
                url: "{{ route('admin.report.transaction.get.product') }}",
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

        $("#select2-product").on('change', async function(e) {
            let data = $('#select2-product').val();
            @this.products = data;
        });
        // Select2 Course
        $('#select2-course').select2({
            minimumInputLength: 1,
            width: '100%',
            theme: 'bootstrap4',
            placeholder: "Cari dan Pilih Kursus Online",
            ajax: {
                url: "{{ route('admin.report.transaction.get.course') }}",
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

        $("#select2-course").on('change', async function(e) {
            let data = $('#select2-course').val();
            @this.courses = data;
        });
        // Select2 Offline Course
        $('#select2-offline-course').select2({
            minimumInputLength: 1,
            width: '100%',
            theme: 'bootstrap4',
            placeholder: "Cari dan Pilih Kursus Offline",
            ajax: {
                url: "{{ route('admin.report.transaction.get.offline_course') }}",
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

        $("#select2-offline-course").on('change', async function(e) {
            let data = $('#select2-offline-course').val();
            @this.offline_courses = data;
        });
        // Select2 Payment Method
        $('#select2-payment-method').select2({
            minimumInputLength: 1,
            width: '100%',
            theme: 'bootstrap4',
            placeholder: "Cari dan Pilih Metode Pembayaran",
            ajax: {
                url: "{{ route('admin.report.transaction.get.payment_method') }}",
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

        $("#select2-payment-method").on('change', async function(e) {
            let data = $('#select2-payment-method').val();
            @this.payment_methods = data;
        });
    </script>
@endpush
