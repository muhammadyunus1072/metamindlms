@extends('member.layouts.index')
{{-- @extends('layouts.components') --}}


@section('content')
    <?php
    $list_route = [
        'update' => route('profile.update'),
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
                        <label class="form-label" for="phone">Nomor Handphone :</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $results_data->phone }}">
                    </div>

                    <div class="col-3">
                        <label class="form-label" for="gender">Jenis Kelamin :</label>
                        <select id="gender" class="form-control custom-select">
                            @foreach ($gender_choice as $key => $value)
                                <option value="{{ $key }}" {{ $results_data->gender == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-3">
                        <label class="form-label" for="religion">Agama :</label>
                        <select id="religion" class="form-control custom-select">
                            @foreach ($religion_choice as $key => $value)
                                <option value="{{ $key }}" {{ $results_data->religion == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="birth_place">Tempat Lahir :</label>
                        <input type="text" class="form-control" id="birth_place" name="birth_place" value="{{ $results_data->birth_place }}">
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="birth_date">Tanggal Lahir :</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $results_data->birth_date }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="company_name">Perusahaan :</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $results_data->company_name }}">
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
