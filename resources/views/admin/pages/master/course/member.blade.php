@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
		$data["csub_title"] = "Member";

		$list_route = array(
		    "store_member_course" => $data["croute"] . "store_member_course/" . enc($results_data->id),
		    "json_member_course" => $data['croute'] . "json_member_course/" . enc($results_data->id),
		    "search_member" => $data["croute"] . "search_member",
		);
    ?>

    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">{{ $data["csub_title"] }}</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">
                            {{ $data["ctitle"] }}
                        </li>
						<li class="breadcrumb-item active">
                            {{ $data["csub_title"] }}
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row"
                    role="tablist">
				<div class="col-auto">
					<a href="{{ $data['croute'] }}"class="btn btn-outline-danger">
						Kembali
					</a>
				</div>
                <div class="col-auto">
					<a id="btn_add_member_course" name="btn_add_member_course" class="btn btn-outline-secondary"
						data-target="#add_member_course_modal" data-toggle="modal">
						Tambah
					</a>
                </div>
            </div>

        </div>
    </div>

    <div class="page__container page-section">

        <div class="card">
			<div class="card-header">
				<h4 class="card-title mb-1">{{ $results_data->code . ' | ' . $results_data->title }}</h4>
				<span class="text-muted">List Data {{ $data['csub_title'] . ' ' . $data['ctitle'] }}</span>
			</div>
			<div class="card-body">
				<table id="master-table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>No</th>
							<th>Aksi</th>
							<th>Kode</th>
							<th>{{ $data["csub_title"] }}</th>
							<th>Email</th>
							<th>Nomor Telepon</th>
							<th>Dibuat Oleh</th>
							<th>Dibuat</th>
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

@section('modal')
    @include('admin.pages.master.course.components.modal_add_member_course')
@endsection

@section('js')

@include('admin.pages.master.course.components.js_select2_member')

<script>
    var data_table = $("#master-table").DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: "{{ $list_route['json_member_course'] }}"
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
			className: "text-center",
			data: "action",
			searchable: false,
			"sortable": false
		},
		{
			data: "code"
		},
		{
			data: "member_name"
		},
		{
			data: "member_email"
		},
		{
			data: "member_phone",
		},
		{
			data: "admins_name"
		},
		{
			data: "created_date",
		},
		],
	});

    $('#master-table tbody').on('click', '#btn_dl', function() {
		var data = data_table.row($(this).parents('tr')).data();
		if (data === undefined) {
			data = data_table.row($(this)).data();
		}

		var file_data = new FormData();
		vstatus_text = "Apakah anda yakin ingin menghapus member {{ $data['ctitle'] }} " + data['member_name'] + " ?";
		r_action_table(file_data, vstatus_text, data['dl'], 'table', data_table);
	});
</script>

<script>
	$("#btn_store_member_course").click(function() {

        var url = "{{ $list_route['store_member_course'] }}";

		var file_data = new FormData();
		file_data.append('member_id', $('#add_member_course_member_id').val());

		r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
    });
</script>
    
@stop