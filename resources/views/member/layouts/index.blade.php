<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&display=swap"
        rel="stylesheet">

    <link href="{{ asset('/assets/vendor/spinkit.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/vendor/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/material-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/fontawesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/preloader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet" type="text/css" />
    <link type="text/css" href="{{ asset('/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('/assets/css/select2.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/gh/smartintegratedsistem/JqueryPagination@1.0.0/css/jquery-pagination.css"
        rel="stylesheet">

    @stack('css')

    @livewireStyles
</head>

<body class="layout-app ">

    <div class="preloader">
        <div class="sk-chase">
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
        </div>
    </div>

    <!-- Drawer Layout -->

    <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
        <div class="mdk-drawer-layout__content page-content">

            <!-- Navbar -->
            <div class="navbar navbar-expand pr-0 navbar-light border-bottom-2" id="default-navbar" data-primary>

                <!-- Navbar Toggler -->
                <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0" type="button"
                    data-toggle="sidebar">
                    <span class="material-icons">short_text</span>
                </button>

                <div class="flex"></div>

                <!-- Navbar Menu -->

                <div class="nav navbar-nav flex-nowrap d-flex mr-16pt">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex align-items-center dropdown-toggle"
                            data-toggle="dropdown" data-caret="false">
                            <span class="avatar avatar-sm mr-8pt2">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="material-icons">account_box</i>
                                </span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header"><strong>Account</strong></div>
                            @if (Auth::check())
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            @else
                                <a class="dropdown-item" href="{{ route('login.index') }}">Login</a>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- // END Navbar Menu -->
            </div>

            <!-- Page Content -->
            @yield('content')
            <!-- // END Page Content -->
        </div>

        <!-- // END drawer-layout__content -->

        <!-- Drawer -->
        <div class="mdk-drawer js-mdk-drawer" id="default-drawer">
            <div class="mdk-drawer__content">
                <div class="sidebar sidebar-dark-pickled-bluewood sidebar-left" data-perfect-scrollbar>
                    <!-- Sidebar Content -->
                    @include('member.layouts.sidebar')
                    <!-- // END Sidebar Content -->
                </div>
            </div>
        </div>

        @yield('filter')

        <!-- // END Drawer -->
    </div>

    <!-- // END Drawer Layout -->

    @yield('modal')

    <script src="{{ asset('/assets/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/dom-factory.js') }}"></script>
    <script src="{{ asset('/assets/vendor/material-design-kit.js') }}"></script>
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="{{ asset('/assets/js/preloader.js') }}"></script>
    <script src="{{ asset('/assets/js/settings.js') }}"></script>
    <script src="{{ asset('/assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('/assets/js/flatpickr.js') }}"></script>
    <script src="{{ asset('/assets/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/moment-range.js') }}"></script>
    <script src="{{ asset('/assets/vendor/Chart.min.js') }}"></script>
    <script src="{{ asset('/assets/js/chartjs.js') }}"></script>
    <script src="{{ asset('/assets/js/page.student-dashboard.js') }}"></script>
    <script src="{{ asset('/assets/vendor/list.min.js') }}"></script>
    <script src="{{ asset('/assets/js/list.js') }}"></script>
    <script src="{{ asset('/assets/js/toggle-check-all.js') }}"></script>
    <script src="{{ asset('/assets/js/check-selected-row.js') }}"></script>
    <script src="{{ asset('/assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/select2.js') }}"></script>

    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/smartintegratedsistem/JqueryPagination@1.0.0/js/jquery-pagination.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script src="{{ asset('/js/main.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(".custom_scrolling_navbar a").on('click', function(event) {
                if (this.hash !== "") {
                    event.preventDefault();

                    var hash = this.hash;

                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function() {

                        window.location.hash = hash;
                    });
                }
            });
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.custom-select-2').select2({})

        function r_action_table(data, messages, action_url, reload_data) {
            swal.fire({
                title: 'Informasi',
                text: messages,
                icon: 'warning',
                // showLoaderOnConfirm: true,
                showCancelButton: true,
                // closeOnConfirm: false,
                // preConfirm: true,
                confirmButtonText: "Yakin!",
                cancelButtonText: "Tutup"
            }).then((result) => {
                if (result.value) {
                    loading("show");
                    $.ajax({
                        url: action_url,
                        type: "POST",
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: data,
                        success: function(result) {
                            loading("hide");
                            if (reload_data == 'table') {
                                data_table.ajax.reload(null, false);
                            }

                            if (reload_data == 'page' && result['st'] == 's') {
                                location.reload();
                            }

                            if (reload_data == 'redirect' && result['st'] == 's') {
                                window.location.assign(result['p']);
                            }

                            if (result['st'] == 's') info_server('success', result['s']);
                            else info_server('error', result['s']);
                        },
                        error: function(xhr, res, result) {
                            loading("hide");
                            alert_error("show", xhr);
                        }
                    });
                }
            });
        }

        function action_table(data, action_url, reload_data) {
            loading("show");
            $.ajax({
                url: action_url,
                type: "POST",
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                success: function(result) {
                    loading("hide");
                    if (reload_data == 'table') {
                        data_table.ajax.reload(null, false);
                    }

                    if (reload_data == 'page' && result['st'] == 's') {
                        location.reload();
                    }

                    if (reload_data == 'redirect' && result['st'] == 's') {
                        window.location.assign(result['p']);
                    }

                    // if (result['st'] == 's') info_server('success', result['s']);
                    // else info_server('error', result['s']);
                },
                error: function(xhr, res, result) {
                    loading("hide");
                    alert_error("show", xhr);
                }
            });
        }

        @if (session('success'))
            info_server('success', "{{ session('success') }}");
        @elseif (session('error'))
            info_server('error', "{{ session('error') }}");
        @elseif (session('info'))
            info_server('info', "{{ session('info') }}");
        @endif

        function info_server(info_type = null, messages = null) {
            button_color = "#2196F3";

            if (info_type == 'success') button_color = "#66BB6A";
            else if (info_type == 'error') button_color = "#EF5350";
            else if (info_type == 'info') button_color = "#2196F3";

            swal.fire({
                title: "Informasi",
                text: messages,
                // confirmButtonColor: button_color,
                confirmButtonText: "Tutup",
                icon: info_type
            });
        }
    </script>

    <script>
        function change_icon_favorite(data, view) {
            if (data == 1) {
                $(view).attr('data-original-title', 'Hapuskan dari Favorite');
                $(view).text('favorite');
            } else if (data == 0) {
                $(view).attr('data-original-title', 'Tambahkan ke Favorite');
                $(view).text('favorite_border');
            }
        }
    </script>

    @stack('js')

    @livewireScripts

    <script>
        $(() => {
            get_notification();
        })

        function get_notification(){
                $.ajax({
                    type: "get",
                    processData: false,
                    contentType: false,
                    url: "{{ route('member.menu_notification.get') }}",
                    success: function(data) {
                        var response = data;
    
                        response.forEach(data => {
                            
                            data.forEach(element => {
                                if (element.body > 0) {
                                    $(`#notif_${element.id_menu}`).remove();
                                    $(`#${element.id_menu}`).append(
                                        `<span class="badge ms-2 bg-${element.style}" style="margin-left:10px;" id="notif_${element.id_menu}">${element.body}</span>`
                                    )
                                }
                            });
                        });
                    }
                });
            }
        window.livewire.on('onSuccessSweetAlert', (message) => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: message,
            });
        });

        window.livewire.on('onFailSweetAlert', (message) => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: message,
            });
        });
        window.livewire.on('consoleLog', (data) => {
            console.log(data)
        });
        window.livewire.on('refreshNotification', () => {
            get_notification();
        });
    </script>
</body>

</html>
