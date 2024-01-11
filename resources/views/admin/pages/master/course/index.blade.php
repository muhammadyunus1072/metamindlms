@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
		$list_route = array(
		    "create" => $data["croute"] . "create",
		    "json" => $data['croute'] . "json",
		);
    ?>

    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">{{ $data["ctitle"] }}</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">
                            {{ $data["ctitle"] }}
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row"
                    role="tablist">
                <div class="col-auto">
                    <a href="{{ $list_route['create'] }}"
                        class="btn btn-outline-secondary">Tambah</a>
                </div>
            </div>

        </div>
    </div>

    <div class="page__container page-section">

        <div class="card">
			<div class="card-header">
				<h4 class="card-title">List Data {{ $data["ctitle"] }}</h4>
			</div>
			<div class="card-body">
				<table id="master-table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>No</th>
							<th>Aksi</th>
							<th>Nama</th>
							<th>Level</th>
							<th>Harga</th>
							<th>Harga Sebelum Diskon</th>
							<th>Status</th>
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

@push('js')

<script>
    var data_table = $("#master-table").DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: "{{ $list_route['json'] }}"
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
			data: "vname"
		},
		{
			data: "vlevel"
		},
		{
			data: "vprice"
		},
		{
			data: "vprice_before_discount"
		},
		{
			data: "vstatus",
		},
		{
			data: "admins_name"
		},
		{
			data: "created_date",
		},
		],
	});

	$('#master-table tbody').on('click', '#btn_m', function() {
		var data = data_table.row($(this).parents('tr')).data();
		if (data === undefined) {
			data = data_table.row($(this)).data();
		}
		window.location.assign(data['m']);
	});

    $('#master-table tbody').on('click', '#btn_u', function() {
		var data = data_table.row($(this).parents('tr')).data();
		if (data === undefined) {
			data = data_table.row($(this)).data();
		}
		window.location.assign(data['up']);
	});

    $('#master-table tbody').on('click', '#btn_ac', function() {
        var data = data_table.row($(this).parents('tr')).data();
        if (data === undefined) {
            data = data_table.row($(this)).data();
        }

        var file_data = new FormData();
        vstatus_text = "Apakah anda yakin ingin " + data['vstatus_text'] + " data " + data['code'] + " ?";
        r_action_table(file_data, vstatus_text, data['ac'], 'table', data_table);
    });

    $('#master-table tbody').on('click', '#btn_dl', function() {
		var data = data_table.row($(this).parents('tr')).data();
		if (data === undefined) {
			data = data_table.row($(this)).data();
		}

		var file_data = new FormData();
		vstatus_text = "Apakah anda yakin ingin menghapus {{ $data['ctitle'] }} " + data['code'] + " ?";
		r_action_table(file_data, vstatus_text, data['dl'], 'table', data_table);
	});
</script>
    
@endpush