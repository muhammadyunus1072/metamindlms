@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $data["csub_title"] = "Konten";

		$list_route = array(
		    "create" => $data["croute"] . "create_lesson/" . enc($results_data->id),
		    "back" => $data["croute"] . "edit/" . enc($results_data->course_id),
		    "destroy_section" => $data["croute"] . "destroy_section/",
		    "json_lesson" => $data['croute'] . "json_lesson/" . enc($results_data->id),
		);
    ?>

    <div class="pt-32pt">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
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
                    <a href="{{ $list_route['create'] }}"
                        class="btn btn-outline-secondary">Tambah Materi Video</a>
					<a href="{{ $list_route['create'] }}"
                        class="btn btn-outline-secondary">Tambah Kuis</a>
                </div>
            </div>

        </div>
    </div>

    <div class="container page__container page-section">

        <div class="card">
			<div class="card-header">
				<h4 class="card-title">Ubah Data {{ $data["csub_title"] }} {{ $data['ctitle'] }}</h4>
			</div>
            <form action="{{ $data['croute'] . 'update_section/' . enc($results_data->id) }}" id="form-data" method="POST">
            @csrf
                <div class="card-body">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label" for="title">Judul <span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $results_data->title }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="position">Urutan Ke <span class="text-danger">*</span> :</label>
                                <input type="number" class="form-control" id="position" name="position" value="{{ $results_data->position }}" min="1">
                            </div>
    
                            <div class="col-6">
                                <label class="form-label" for="is_actived">Status Konten :</label>
                                <select name="is_actived" id="is_actived" class="form-control custom-select">
                                    <option value="1" {{ $results_data->is_actived == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ $results_data->is_actived == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <a type="button" onclick="destroy_section('{{ enc($results_data->id) }}')" class="btn btn-outline-danger px-4">Hapus</a>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a type="button" href="{{ $list_route['back'] }}" class="btn btn-outline-primary px-4">Kembali</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
		</div>
        

        <div class="card">
			<div class="card-header">
				<h4 class="card-title">List Data Pelajaran</h4>
			</div>
			<div class="card-body">
				<table id="master-table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>No</th>
							<th>Aksi</th>
							<th>Judul</th>
							<th>Jenis</th>
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
    $("#form-data").submit(function(e) {
		e.preventDefault();
		
		var form = $(this);
		var url = form.attr('action');

		var file_data = new FormData();
		file_data.append('title', $('#title').val());
		file_data.append('position', $('#position').val());
		file_data.append('is_actived', $('#is_actived').val());

		r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
	});
</script>

@include('admin.pages.master.course.components.js_destroy_section')

<script>
    var data_table = $("#master-table").DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: "{{ $list_route['json_lesson'] }}"
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
			data: "vtitle"
		},
		{
			data: "type"
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
        vstatus_text = "Apakah anda yakin ingin " + data['vstatus_text'] + " data " + data['title'] + " ?";
        r_action_table(file_data, vstatus_text, data['ac'], 'table', data_table);
    });

    $('#master-table tbody').on('click', '#btn_dl', function() {
		var data = data_table.row($(this).parents('tr')).data();
		if (data === undefined) {
			data = data_table.row($(this)).data();
		}

		var file_data = new FormData();
		vstatus_text = "Apakah anda yakin ingin menghapus Pelajaran " + data['title'] + " ?";
		r_action_table(file_data, vstatus_text, data['dl'], 'table', data_table);
	});
</script>
    
@endpush