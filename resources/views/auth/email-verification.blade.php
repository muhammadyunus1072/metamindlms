@extends('auth.layout')

@section('body-class', 'layout-default layout-login-image')

@section('content')
    <div class="layout-login-image__overlay" style="background-image: url({{ asset('bg_auth.jpg') }});">
        <div class="fullbleed bg-dark" style="opacity: .5"></div>
    </div>

    <div class="layout-login-image__form bg-white vh-100" data-perfect-scrollbar>
        <h4 class="m-0">Verifikasi Email</h4>
        <p class="mb-5">Silahkan periksa Email Anda</p>

        <form action="{{ route('verification.store') }}" id="login-form" method="post">
            @csrf
            <div class="form-group">
                <label class="text-label" for="email">Email:</label>
                <div class="input-group input-group-merge">
                    <input id="email" name="email" type="email" class="form-control form-control-prepended"
                        value="{{ $email }}" readonly>
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="far fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4 mb-4">
                <div class="captcha">
                    <span>{!! captcha_img() !!}</span>
                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                        &#x21bb;
                    </button>
                </div>
            </div>
            <div class="form-group mb-4">
                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
            </div>

            <div class="form-group text-center">
                <span id='btn-submit-info'></span>
                <button class="btn btn-primary mb-5" type="submit" id="btn-submit" disabled>
                    Kirim Ulang Verifikasi Email
                </button>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        var interval_send_email;
        var time_send_email;

        $(() => {
            disable_send_email();
        });

        function disable_send_email() {
            time_send_email = 30;
            $('#btn-submit').attr('disabled', true);
            $('#btn-submit-info').text(`Kirim Ulang Email Dalam ${time_send_email} Detik`);

            interval_send_email = setInterval(() => {
                time_send_email -= 1;

                if (time_send_email == 0) {
                    clearInterval(interval_send_email);
                    $('#btn-submit-info').text(``);
                    $('#btn-submit').attr('disabled', false);
                    $('#reload').trigger('click');
                } else {
                    $('#btn-submit-info').text(`Kirim Ulang Email Dalam ${time_send_email} Detik`);
                }
            }, 1000);
        }

        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'reload-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });

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

                    if (response.code == 201) {
                        Swal.fire({
                            title: result.title,
                            text: result.message,
                            icon: result.type,
                        });
                        disable_send_email();
                    } else if (response.code == 200) {
                        Swal.fire({
                            title: result.title,
                            text: result.message,
                            icon: result.type,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        window.location = "{{ route('login.index') }}";
                    } else {
                        Swal.fire(result.title, result.message, result.type);
                    }

                    $('#reload').trigger('click');
                },
                error: function(xhr, request, error) {
                    loading("hide");
                    alert_error("show", xhr);

                    $('#reload').trigger('click');
                }
            });
        });
    </script>
@endpush
