<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }}</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&display=swap"
        rel="stylesheet">

    <link href="{{ asset('/assets/vendor/spinkit.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/vendor/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/material-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/fontawesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/preloader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

</head>

<body class="layout-default layout-login-image">

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
                <button class="btn btn-primary mb-5" type="submit">Login</button><br>
                Belum punya akun? <a class="text-body text-underline" href="signup-image.html">Daftar!</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('/assets/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/dom-factory.js') }}"></script>
    <script src="{{ asset('/assets/vendor/material-design-kit.js') }}"></script>
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="{{ asset('/assets/js/preloader.js') }}"></script>
    <script src="{{ asset('/assets/js/hljs.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script src="{{ asset('/js/main.js') }}"></script>

    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

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

</body>

</html>
