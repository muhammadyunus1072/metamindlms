@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
		$list_route = array(
		    "json" => $data['croute'] . "recap_course/json",
		    "export" => $data['croute'] . "recap_course/export",
		);
    ?>

    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">{{ $data["ctitle"] . ' ' . $data['title_recap_course'] }}</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item">
                            {{ $data["ctitle"] }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $data["title_recap_course"] }}
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
					<h4 class="card-title my-auto">List Data {{ $data["ctitle"] . ' ' . $data['title_recap_course'] }}</h4>

					<a onclick="export_recap_course()" class="btn btn-success"><i class="fas fa-file-excel mr-2"></i> Export</a>
				</div>
			</div>
			<div class="card-body">

				<table id="master-table" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode</th>
							<th>Kursus</th>
							<th>Total Member</th>
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
			data: "course_code"
		},
		{
			data: "course_title"
		},
		{
			data: "total_member"
		},
		],
	});
</script>

<script>
	function export_recap_course() {
		var search_text = $('.dataTables_filter input').val();

		var url = "{{ $list_route['export'] }}?" + "search=" + search_text;
		window.open(url, '_blank');
	}
</script>
    
@endpush