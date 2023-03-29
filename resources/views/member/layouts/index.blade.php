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

            <!-- Header -->

            <!-- Navbar -->

            <div class="navbar navbar-expand pr-0 navbar-light border-bottom-2" id="default-navbar" data-primary>

                <!-- Navbar Toggler -->

                <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0" type="button"
                    data-toggle="sidebar">
                    <span class="material-icons">short_text</span>
                </button>

                <!-- // END Navbar Toggler -->

                <!-- Navbar Brand -->

                {{-- <a href="index.html"
                       class="navbar-brand mr-16pt d-lg-none">

                        <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                            <span class="avatar-title rounded bg-primary"><img src="../../public/images/illustration/student/128/white.svg"
                                     alt="logo"
                                     class="img-fluid" /></span>

                        </span>

                        <span class="d-none d-lg-block">Luma</span>
                    </a> --}}

                <!-- // END Navbar Brand -->

                {{-- <span class="d-none d-md-flex align-items-center mr-16pt">

                        <span class="avatar avatar-sm mr-12pt">

                            <span class="avatar-title rounded navbar-avatar"><i class="material-icons">opacity</i></span>

                        </span>

                        <small class="flex d-flex flex-column">
                            <strong class="navbar-text-100">Experience IQ</strong>
                            <span class="navbar-text-50">2,300 points</span>
                        </small>
                    </span> --}}

                <div class="flex"></div>

                <!-- Switch Layout -->

                {{-- <a href="../Compact_App_Layout/student-dashboard.html"
                       class="navbar-toggler navbar-toggler-custom align-items-center justify-content-center d-none d-lg-flex"
                       data-toggle="tooltip"
                       data-title="Switch to Compact Layout"
                       data-placement="bottom"
                       data-boundary="window">
                        <span class="material-icons">swap_horiz</span>
                    </a> --}}

                <!-- // END Switch Layout -->

                <!-- Navbar Menu -->

                <div class="nav navbar-nav flex-nowrap d-flex mr-16pt">

                    <!-- Notifications dropdown -->
                    {{-- <div class="nav-item dropdown dropdown-notifications dropdown-xs-down-full"
                             data-toggle="tooltip"
                             data-title="Messages"
                             data-placement="bottom"
                             data-boundary="window">
                            <button class="nav-link btn-flush dropdown-toggle"
                                    type="button"
                                    data-toggle="dropdown"
                                    data-caret="false">
                                <i class="material-icons icon-24pt">mail_outline</i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div data-perfect-scrollbar
                                     class="position-relative">
                                    <div class="dropdown-header"><strong>Messages</strong></div>
                                    <div class="list-group list-group-flush mb-0">

                                        <a href="javascript:void(0);"
                                           class="list-group-item list-group-item-action unread">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">5 minutes ago</small>

                                                <span class="ml-auto unread-indicator bg-accent"></span>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <img src="../../public/images/people/110/woman-5.jpg"
                                                         alt="people"
                                                         class="avatar-img rounded-circle">
                                                </span>
                                                <span class="flex d-flex flex-column">
                                                    <strong class="text-black-100">Michelle</strong>
                                                    <span class="text-black-70">Clients loved the new design.</span>
                                                </span>
                                            </span>
                                        </a>

                                        <a href="javascript:void(0);"
                                           class="list-group-item list-group-item-action">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">5 minutes ago</small>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <img src="../../public/images/people/110/woman-5.jpg"
                                                         alt="people"
                                                         class="avatar-img rounded-circle">
                                                </span>
                                                <span class="flex d-flex flex-column">
                                                    <strong class="text-black-100">Michelle</strong>
                                                    <span class="text-black-70">ðŸ”¥ Superb job..</span>
                                                </span>
                                            </span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    <!-- // END Notifications dropdown -->

                    <!-- Notifications dropdown -->
                    {{-- <div class="nav-item ml-16pt dropdown dropdown-notifications dropdown-xs-down-full"
                             data-toggle="tooltip"
                             data-title="Notifications"
                             data-placement="bottom"
                             data-boundary="window">
                            <button class="nav-link btn-flush dropdown-toggle"
                                    type="button"
                                    data-toggle="dropdown"
                                    data-caret="false">
                                <i class="material-icons">notifications_none</i>
                                <span class="badge badge-notifications badge-accent">2</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div data-perfect-scrollbar
                                     class="position-relative">
                                    <div class="dropdown-header"><strong>System notifications</strong></div>
                                    <div class="list-group list-group-flush mb-0">

                                        <a href="javascript:void(0);"
                                           class="list-group-item list-group-item-action unread">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">3 minutes ago</small>

                                                <span class="ml-auto unread-indicator bg-accent"></span>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <span class="avatar-title rounded-circle bg-light">
                                                        <i class="material-icons font-size-16pt text-accent">account_circle</i>
                                                    </span>
                                                </span>
                                                <span class="flex d-flex flex-column">

                                                    <span class="text-black-70">Your profile information has not been synced correctly.</span>
                                                </span>
                                            </span>
                                        </a>

                                        <a href="javascript:void(0);"
                                           class="list-group-item list-group-item-action">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">5 hours ago</small>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <span class="avatar-title rounded-circle bg-light">
                                                        <i class="material-icons font-size-16pt text-primary">group_add</i>
                                                    </span>
                                                </span>
                                                <span class="flex d-flex flex-column">
                                                    <strong class="text-black-100">Adrian. D</strong>
                                                    <span class="text-black-70">Wants to join your private group.</span>
                                                </span>
                                            </span>
                                        </a>

                                        <a href="javascript:void(0);"
                                           class="list-group-item list-group-item-action">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">1 day ago</small>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <span class="avatar-title rounded-circle bg-light">
                                                        <i class="material-icons font-size-16pt text-warning">storage</i>
                                                    </span>
                                                </span>
                                                <span class="flex d-flex flex-column">

                                                    <span class="text-black-70">Your deploy was successful.</span>
                                                </span>
                                            </span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    <!-- // END Notifications dropdown -->

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex align-items-center dropdown-toggle"
                            data-toggle="dropdown" data-caret="false">

                            <span class="avatar avatar-sm mr-8pt2">

                                <span class="avatar-title rounded-circle bg-primary"><i
                                        class="material-icons">account_box</i></span>

                            </span>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header"><strong>Account</strong></div>
                            @if (Auth::check())
                                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            @else
                                <a class="dropdown-item" href="{{ route('login.index') }}">Login</a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- // END Navbar Menu -->

            </div>

            <!-- // END Navbar -->

            <!-- // END Header -->

            <!-- BEFORE Page Content -->

            <!-- // END BEFORE Page Content -->

            <!-- Page Content -->

            @yield('content')

            <!-- // END Page Content -->

            <!-- Footer -->

            <div class="bg-white border-top-2 mt-auto">
                <div class="container page__container page-section d-flex flex-column">
                    <p class="text-70 brand mb-24pt">
                        <img class="brand-icon" src="" width="30" alt="Luma"> Luma
                    </p>
                    <p class="measure-lead-max text-50 small mr-8pt">Luma is a beautifully crafted user interface for
                        modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher
                        Dashboard, Curriculum Management, Earnings and Reporting, ERP, HR, CMS, Tasks, Projects,
                        eCommerce and more.</p>
                    <p class="mb-8pt d-flex">
                        <a href="" class="text-70 text-underline mr-8pt small">Terms</a>
                        <a href="" class="text-70 text-underline small">Privacy policy</a>
                    </p>
                    <p class="text-50 small mt-n1 mb-0">Copyright 2019 &copy; All rights reserved.</p>
                </div>
            </div>

            <!-- // END Footer -->

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
</body>

</html>
