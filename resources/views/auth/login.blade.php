@extends('auth.layout')

@section('body-class', 'layout-default layout-login-image')

@section('content')
    <div class="layout-login-image__overlay" style="background-image: url({{ asset('bg_auth.jpg') }});">
        <div class="fullbleed bg-dark" style="opacity: .5"></div>
    </div>

    <div class="layout-login-image__form bg-white vh-100" data-perfect-scrollbar>
        <div class="d-flex justify-content-center mt-2 mb-5 navbar-light">
            <a href="index.html" class="navbar-brand flex-column mb-2 align-items-center mr-0" style="min-width: 0">
                <img src="{{ asset('ic_logo.png') }}" alt="logo" class="img-fluid" style="max-width:200px;" />
            </a>
        </div>

        <h4 class="m-0">Selamat Datang!</h4>
        <p class="mb-5">Silahkan login dengan akun anda </p>

        <form action="{{ route('login.do_login') }}" id="login-form" method="post">
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
            <div class="form-group text-center">
                <button class="btn btn-primary mb-5" type="submit">Login</button>
                <br>Belum punya akun? <a class="text-body text-underline" href="{{ route('register.index') }}">Daftar!</a>
                <br>Sudah punya akun tapi lupa password? <a class="text-body text-underline"
                    href="{{ route('password.request') }}">Lupa Password</a>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $("#login-form").submit(function(e) {
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

                    if (response.code == 200) {
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
                    } else if (response.code == 201) {
                        window.location =
                        `{{ route('verification.index') }}?email=${$('#email').val()}`;
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
