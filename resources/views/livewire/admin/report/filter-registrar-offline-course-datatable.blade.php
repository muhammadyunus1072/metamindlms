{{-- Filter --}}
<div>
    <div class="row align-items-end">
        <div class="col-md-4" wire:ignore>
            <label for="select1" class="form-label">Kursus Offline</label>
            <select wire:model="offline_course_id" id="select_offline_course_id" class="form-control">
            </select>
        </div>
        <div class="col-md-4" wire:ignore>
            <label for="select2" class="form-label">Member</label>
            <select wire:model="member_id" id="select_member_id" class="form-control">
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-warning" type="button" id="reset">Reset</button>
        </div>
    </div>
    <hr>
</div>

@push('js')
    <script>
        $(() => {
            initSelect2();
            reset();
            // Emit Offline Course
            $('#select_offline_course_id').change(() => {
                @this.emit('registrar_filter_offline_course', $('#select_offline_course_id').val())
            });

            // Emit Member
            $('#select_member_id').change(() => {
                @this.emit('registrar_filter_member', $('#select_member_id').val())
            });
        })

        function reset() {
            $("#reset").click(function() {
                $("#select_offline_course_id").val('').trigger('change');
                $("#select_member_id").val('').trigger('change');
            })
        }

        function initSelect2() {
            // Offline Course
            $('#select_offline_course_id').select2({
                minimumInputLength: 1,
                placeholder: "Semua Kursus Offline",
                ajax: {
                    url: "{{ route('admin.report.get.offline_course') }}",
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
                                    "text": item.title,
                                    "id": item.id,
                                    "data": item
                                }
                            })
                        };
                    },
                }
            });

            // Member
            $('#select_member_id').select2({
                minimumInputLength: 1,
                placeholder: "Semua Member",
                ajax: {
                    url: "{{ route('admin.report.get.user') }}",
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
                                    "text": item.name,
                                    "id": item.id,
                                    "data": item
                                }
                            })
                        };
                    },
                }
            });
        }
    </script>
@endpush
