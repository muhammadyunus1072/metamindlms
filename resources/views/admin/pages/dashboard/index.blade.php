@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $list_route = array(
            "update_dashboard" => route('admin.dashboard.update')
        );
    ?>

    <div class="pt-32pt">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
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
        <div class="container page__container">

            <div class="row">
                <div class="col-md-9">

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="date">Filter Tanggal :</label>
                        <input type="text" class="form-control" id="daterange" name="daterange"
                            value="" autocomplete="false" />
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

        </div>
    </div>

    <!-- // END Page Content -->
@stop

@push('js')

    <script>
        update_dashboard();

        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            update_dashboard();
        });

        function update_dashboard(){
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

                },
                error: function(xhr, res, result) {
                    loading('hide')
                    alert_error("show", xhr);
                }
            });
        }
    </script>
    
@endpush