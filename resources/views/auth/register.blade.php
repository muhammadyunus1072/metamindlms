@extends('auth.layout')

@section('body-class', 'layout-default layout-login-image')

@section('content')
    <div class="layout-login-image__overlay" style="background-image: url({{ asset('bg_auth.jpg') }});">
        <div class="fullbleed bg-dark" style="opacity: .5"></div>
    </div>

    <div class="layout-login-image__form bg-white vh-100" data-perfect-scrollbar>
        <h4 class="m-0">Registrasi Akun</h4>
        <p class="mb-3">Silahkan lengkapi informasi akun anda </p>

        <form action="{{ route('register.do_register') }}" id="register-form" method="post">
            @csrf
            <div class="form-group">
                <label class="text-label" for="email">Email:</label>
                <div class="input-group input-group-merge">
                    <input id="email" name="email" type="email" class="form-control form-control-prepended"
                        placeholder="Email">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="far fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="name">Nama:</label>
                <div class="input-group input-group-merge">
                    <input id="name" name="name" type="text" class="form-control form-control-prepended"
                        placeholder="Nama">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="far fa-user"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="phone">Nomor HP:</label>
                <div class="input-group input-group-merge">
                    <input id="phone" name="phone" type="tel" class="form-control form-control-prepended"
                        placeholder="Nomor HP">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-phone"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="birth_place">Tempat Lahir:</label>
                <div class="input-group input-group-merge">
                    <input id="birth_place" name="birth_place" type="text" class="form-control form-control-prepended"
                        placeholder="Tempat Lahir">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-city"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="birth_date">Tanggal Lahir:</label>
                <div class="input-group input-group-merge">
                    <input id="birth_date" name="birth_date" type="date" class="form-control form-control-prepended"
                        placeholder="Tanggal Lahir">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="gender">Jenis Kelamin:</label>
                <div class="input-group input-group-merge">
                    <select class="form-control" id="gender" name="gender">
                        @foreach ($gender_choice as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-venus-mars"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="religion">Agama:</label>
                <div class="input-group input-group-merge">
                    <select class="form-control" id="religion" name="religion">
                        @foreach ($religion_choice as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-pray"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="company_name">Perusahaan:</label>
                <div class="input-group input-group-merge">
                    <input id="company_name" name="company_name" type="text" class="form-control form-control-prepended"
                        placeholder="Nama Perusahaan (Tidak Wajib)">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-building"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="password">Password:</label>
                <div class="input-group input-group-merge">
                    <input id="password" name="password" type="password" class="form-control form-control-prepended"
                        placeholder="Password">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-key"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="text-label" for="retype_password">Ketik Ulang Password:</label>
                <div class="input-group input-group-merge">
                    <input id="retype_password" name="retype_password" type="password"
                        class="form-control form-control-prepended" placeholder="Password">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-key"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary mb-5" type="submit">Daftar Sekarang</button><br>
                Sudah punya akun? <a class="text-body text-underline" href="{{ route('login.index') }}">Login!</a>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $("#register-form").submit(function(e) {

            e.preventDefault();

            loading("show");

            // Kirim data ke server
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    var result = response.response;
                    loading("hide");

                    if (response.code > 0) {
                        Swal.fire({
                            title: result.title,
                            text: result.message,
                            icon: result.type,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        // window.location = '/';
                        location.reload();
                    } else {
                        Swal.fire(result.title, result.message, result.type);
                    }
                },
                error: function(xhr, request, error) {
                    loading("hide");
                    alert_error("show", xhr);
                }
            });
        });
    </script>
@endpush
