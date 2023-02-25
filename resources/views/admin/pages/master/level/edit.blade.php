@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <div class="pt-32pt">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
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

        </div>
    </div>

    <div class="container page__container page-section">

        <div class="card">
			<div class="card-header">
				<h4 class="card-title">Ubah Data {{ $data['ctitle'] }}</h4>
			</div>
            <form action="{{ $data['croute'] . 'update/' . enc($results_data->id) }}" id="form-data" method="POST">
            @csrf
                <div class="card-body">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="name">Nama :</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $results_data->name }}">
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="description">Deskripsi :</label>
                                <textarea class="form-control" name="description" id="description" rows="4">{{ $results_data->description }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="button" onclick="history.back();" class="btn btn-outline-primary px-4">Kembali</button>
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
		</div>

    </div>

@stop

@section('js')

<script>
    $("#form-data").submit(function(e) {
		e.preventDefault();
		
		var form = $(this);
		var url = form.attr('action');

		var file_data = new FormData();
		file_data.append('name', $('#name').val());
		file_data.append('description', $('#description').val());

		r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
	});
</script>
    
@stop