@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php
    $list_route = [
        'update_dashboard' => route('admin.dashboard.update'),
    ];
    ?>

    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Dashboard</h2>
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">
                            Dashboard
                        </li>
                    </ol>
                </div>
            </div>

            {{-- <div class="row"
                    role="tablist">
                <div class="col-auto">
                    <a href="instructor-earnings.html"
                        class="btn btn-outline-secondary">Earnings</a>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- BEFORE Page Content -->

    <!-- // END BEFORE Page Content -->

    <!-- Page Content -->

    <div class="page-section border-bottom-2">
        <div class="page__container">

            <div class="row">
                <div class="col-md-9">

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="date">Filter Tanggal :</label>
                        <input type="text" class="form-control" id="daterange" name="daterange" value=""
                            autocomplete="false" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                        <div class="card-body">
                            <h4 class="h2 mb-0"><span id="total_member">0</span></h4>
                            <div>Total Member yang Bergabung</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-1 border-left-3 border-left-primary text-center mb-lg-0">
                        <div class="card-body">
                            <h4 class="h2 mb-0"><span id="total_income">0</span></h4>
                            <div>Total Pendapatan</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-1 border-left-3 border-left-warning text-center mb-lg-0">
                        <div class="card-body">
                            <h4 class="h2 mb-0"><span id="total_course">0</span></h4>
                            <div>Total Kursus yang Diambil</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- OFFLINE COURSE --}}
            <div class="page-section">
                <div class="page-separator">
                    <div class="page-separator__text">Kursus Offline</div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h6 class="card-title">Total Pendaftaran</h6>
                            </div>
                            <div class="card-body">
                                <h3 class="p-0 m-0" id="div_registrar_sum"></h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h6 class="card-title text-white">Total Kehadiran</h6>
                            </div>
                            <div class="card-body">
                                <h3 class="p-0 m-0" id="div_attendance_sum"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title">Grafik Jumlah Pendaftar dan Kehadiran</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="chart_offline_course" style="max-height: 20rem"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- // END Page Content -->
@stop

@push('js')
    <script>
        var chart_offline_course;
        var chart_offline_course_ctx;

        $(() => {
            update_dashboard();

            $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
                update_dashboard();
            });
        })


        function update_dashboard() {
            loading("show")

            var url = "{{ $list_route['update_dashboard'] }}";

            var file_data = new FormData();
            file_data.append('daterange', $('#daterange').val());

            $.ajax({
                url: url,
                type: "POST",
                processData: false,
                contentType: false,
                cache: false,
                data: file_data,
                success: function(result) {
                    loading('hide')

                    $('#total_course').html(result.total_course);
                    $('#total_member').html(result.total_member);
                    $('#total_income').html(result.total_income);

                    draw_offline_course_chart(result.offline_course);

                },
                error: function(xhr, res, result) {
                    loading('hide')
                    alert_error("show", xhr);
                }
            });
        }


        function draw_offline_course_chart(data) {
            $('#div_registrar_sum').html(data.registrar_sum);
            $('#div_attendance_sum').html(data.attendance_sum);

            if (chart_offline_course_ctx == null) {
                chart_offline_course_ctx = document.getElementById('chart_offline_course').getContext('2d');
            }

            if (chart_offline_course == null) {
                chart_offline_course = new Chart(chart_offline_course_ctx, {
                    type: 'bar',
                    data: {
                        labels: data.chart_labels,
                        datasets: [{
                                label: 'Pendaftar',
                                data: data.registrar_data,
                                backgroundColor: '#ffc107',
                            },
                            {
                                label: 'Kehadiran',
                                data: data.attendance_data,
                                backgroundColor: '#007bff',
                            },
                        ],
                    },
                });
            } else {
                chart_offline_course.data.labels = data.chart_labels;
                chart_offline_course.data.datasets[0].data = data.registrar_data;
                chart_offline_course.data.datasets[1].data = data.attendance_data;
                chart_offline_course.update();
            }
        }
    </script>
@endpush
