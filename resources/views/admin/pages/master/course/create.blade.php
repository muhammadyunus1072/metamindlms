@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')

    <?php 
        $list_route = array(
            "search_level" => $data["croute"] . "search_level",
            "search_category" => $data["croute"] . "search_category",
        );
    ?>

    <div class="pt-32pt">
        <div class="page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">{{ $data['ctitle'] }}</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">
                            {{ $data['ctitle'] }}
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <div class="page__container page-section">
        
        <form action="{{ $data['croute'] . 'store' }}" id="form-data" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-md-8">

                <div class="page-separator">
                    <div class="page-separator__text">Informasi Dasar</div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label" for="title">Judul :</label>
                                    <input type="text" class="form-control" id="title" name="title">
                                </div>
        
                                <div class="col-6">
                                    <label class="form-label" for="about">Tentang :</label>
                                    <textarea class="form-control" name="about" id="about" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label" for="description">Deskripsi :</label>
                                    <textarea class="form-control" name="description" id="description" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
        
                        <div class="form-group">
                            <div class="row">
                                
                                <div class="col-6">
                                    <label class="form-label" for="url_image">Foto :</label>
                                    <div class="custom-file">
                                        <input type="file" id="url_image" name="url_image" class="custom-file-input">
                                        <label for="url_image" class="custom-file-label">Pilih file</label>
                                    </div>
                                    <small class="text-danger">*) Foto yang boleh di upload hanya jpg dan png dengan maksimum file 2MB</small>
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
                </div>

            </div>

            
            <div class="col-md-4">

                <div class="page-separator">
                    <div class="page-separator__text">Kursus</div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Kategori</label>
                                    <select name="category_id" id="category_id" class="form-control custom-select select2" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Level</label>
                                        <select name="level_id" id="level_id" class="form-control custom-select select2">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Harga</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group form-inline">
                                                <span class="input-group-prepend"><span class="input-group-text">Rp</span></span>
                                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Harga Sebelum Diskon</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group form-inline">
                                                <span class="input-group-prepend"><span class="input-group-text">Rp</span></span>
                                                <input type="number" class="form-control" id="price_before_discount" name="price_before_discount" step="0.01" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-separator">
                    <div class="page-separator__text">Video Trailer</div>
                </div>

                <div class="card">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" id="video_trailer" name="video_trailer" src="" allowfullscreen=""></iframe>
                    </div>
                    <div class="card-body">
                        <label class="form-label">URL</label>
                        <input type="text" class="form-control" id="url_video" name="url_video" onchange="refresh_video()">
                    </div>
                </div>

            </div>
        </div>

        </form>

    </div>


@stop

@push('js')

@include('admin.pages.master.course.components.js_file')

@include('admin.pages.master.course.components.js_select2')

<script>
    $("#form-data").submit(function(e) {
		e.preventDefault();
		
		var form = $(this);
		var url = form.attr('action');

		var file_data = new FormData();
		file_data.append('title', $('#title').val());
		file_data.append('about', $('#about').val());
		file_data.append('description', $('#description').val());
		file_data.append('level_id', $('#level_id').val());
		file_data.append('price', $('#price').val());
		file_data.append('price_before_discount', $('#price_before_discount').val());
		file_data.append('url_video', $('#url_video').val());
        file_data.append('url_image', $("#url_image").get(0).files[0]); 

        var list_category = $('#category_id').select2('data');

        for (let i = 0; i < list_category.length; i++) {
            file_data.append('category_id[]', list_category[i].id);
        }

		r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'redirect', null);
	});
</script>
    
@endpush