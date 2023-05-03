@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
		$list_route = array(
		    "json" => $data['croute'] . "course_member/json",
		    "export" => $data['croute'] . "course_member/export",

		    "search_member" => $data['croute'] . "search_member",
		    "search_course" => $data['croute'] . "search_course",
		);
    ?>

    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">{{ $data["ctitle"] . ' ' . $data['title_course_member'] }}</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item">
                            {{ $data["ctitle"] }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $data["title_course_member"] }}
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <div class="page__container page-section">

        <div class="card">
			<div class="card-header">
				<div class="d-flex justify-content-between">
					<h4 class="card-title my-auto">List Data {{ $data["ctitle"] . ' ' . $data['title_course_member'] }}</h4>

					<a onclick="export_course_member()" class="btn btn-success"><i class="fas fa-file-excel mr-2"></i> Export</a>
				</div>
			</div>
			<div class="card-body">

				<div class="row mb-2">
					<div class="col">
						<div class="form-group">
							<label class="form-label" for="date">Tanggal Bergabung :</label>
							<input type="text" class="form-control" id="daterange" name="daterange"
								value="" autocomplete="false" />
						</div>
					</div>

					<div class="col">
						<div class="form-group">
							<label class="form-label" for="date">Member :</label>
							<select name="member_id" id="member_id" class="form-control custom-select select2">
                            </select>
						</div>
					</div>

					<div class="col">
						<div class="form-group">
							<label class="form-label" for="date">Kursus :</label>
							<select name="course_id" id="course_id" class="form-control custom-select select2">
                            </select>
						</div>
					</div>

					<div class="col">
						<div class="form-group">
							<label class="form-label" for="date">Rating :</label>
							<select name="rating" id="rating" class="form-control custom-select select2">
								<option value="">Semua</option>
								@foreach ($list_rating as $k=>$v)
									<option value="{{ $k }}">{{ $v }}</option>
								@endforeach
                            </select>
						</div>
					</div>

					<div class="col">
						<div class="form-group">
							<label class="form-label" for="date">Progress :</label>
							<select name="progress" id="progress" class="form-control custom-select select2">
								<option value="">Semua</option>
								@foreach ($list_progress as $k=>$v)
									<option value="{{ $k }}">{{ $v }}</option>
								@endforeach
                            </select>
						</div>
					</div>
				</div>

				<table id="master-table" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>No</th>
							<th>Kursus</th>
							<th>Member</th>
							<th>Rating</th>
							<th>Progress</th>
							<th>Tanggal Bergabung</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>

    </div>

    <!-- // END Page Content -->

@stop

@push('js')

<script>
	$('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		data_table.ajax.reload(null, false);
	});

	$("#member_id, #course_id, #rating, #progress").change(function() {
		data_table.ajax.reload(null, false);
	});
	
    var data_table = $("#master-table").DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: "{{ $list_route['json'] }}",
			data: function(d) {
				d.daterange = $('#daterange').val();
				d.member_id = $('#member_id').val();
				d.course_id = $('#course_id').val();
				d.rating = $('#rating').val();
				d.progress = $('#progress').val();
			},
		},
		order: [
			[1, 'desc']
			],
		columns: [{
			"data": null,
			"sortable": false,
			searchable: false,
			render: function(data, type, row, meta) {
				return meta.row + meta.settings._iDisplayStart + 1;
			}
		},
		{
			data: "course_title"
		},
		{
			data: "member_name"
		},
		{
			data: "vrating"
		},
		{
			data: "vprogress",
		},
		{
			data: "created_date",
		},
		],
	});
</script>

<script>
    $('#member_id').select2({
        placeholder: "Pilih Member",
        ajax: {
            url: "{{ $list_route['search_member'] }}",
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
                            "text": item.vname,
                            "id": item.enc_id,
                        }
                    })
                };
            },
            error: function(xhr, res, result) {
                // alert_error("hide", xhr);
            }
        },
        cache: true
    });

	$('#course_id').select2({
        placeholder: "Pilih Kursus",
        ajax: {
            url: "{{ $list_route['search_course'] }}",
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
                            "text": item.vname,
                            "id": item.enc_id,
                        }
                    })
                };
            },
            error: function(xhr, res, result) {
                // alert_error("hide", xhr);
            }
        },
        cache: true
    });
</script>

<script>
	function export_course_member() {
		var daterange = $("#daterange").val();
		var member_id = $("#member_id").val() ? $("#member_id").val() : '';
		var course_id = $("#course_id").val() ? $("#course_id").val() : '';
		var rating = $('#rating').val();
		var progress = $('#progress').val();
		var search_text = $('.dataTables_filter input').val();

		var url = "{{ $list_route['export'] }}?" + 'daterange=' + daterange + "&member_id=" + member_id + "&course_id=" + course_id + "&rating=" + rating + "&progress=" + progress + "&search=" + search_text;
		window.open(url, '_blank');
	}
</script>
    
@endpush