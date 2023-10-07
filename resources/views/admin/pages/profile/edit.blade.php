@extends('admin.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')
    <?php
    $list_route = [
        'update' => route('admin.profile.update'),
    ];
    ?>
    <div class="pt-32pt">
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Profile</h2>
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">
                            Profile
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <div class="container page__container">
        <div class="page-section">

            <div class="page-separator">
                <div class="page-separator__text">Informasi Pengguna</div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="name">Nama :</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $results_data->name }}">
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="email">Email :</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $results_data->email }}" disabled>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="password">Password :</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password :</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <button type="submit" id="btn_update" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@stop

@push('js')
    <script>
        $("#btn_update").click(function() {
            var url = "{{ $list_route['update'] }}";

            var file_data = new FormData();
            file_data.append('name', $('#name').val());
            file_data.append('phone', $('#phone').val());
            file_data.append('gender', $('#gender').val());
            file_data.append('religion', $('#religion').val());
            file_data.append('birth_place', $('#birth_place').val());
            file_data.append('birth_date', $('#birth_date').val());
            file_data.append('company_name', $('#company_name').val());
            file_data.append('password', $('#password').val());
            file_data.append('password_confirmation', $('#password_confirmation').val());

            r_action_table(file_data, "Harap periksa kembali data yang telah diinput sebelum disimpan.", url, 'page', null);
        });
    </script>
@endpush
