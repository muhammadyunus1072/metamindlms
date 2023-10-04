<a href="{{ route('admin.dashboard.index') }}" class="sidebar-brand ">
    <span class="avatar avatar-xl sidebar-brand-icon h-auto">
        <span class="avatar-title rounded bg-white">
            <img src="{{ asset('ic_logo.png') }}" class="img-fluid" alt="logo" />
        </span>
    </span>
</a>

<div class="sidebar-heading">Instructor</div>
<ul class="sidebar-menu">
    {{-- Dashboard --}}
    <li class="sidebar-menu-item {{ Request::segment(1) == 'admin' && Request::segment(2) === null ? 'active' : '' }}">
        <a class="sidebar-menu-button" href="{{ route('admin.dashboard.index') }}">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">account_box</span>
            <span class="sidebar-menu-text">Dashboard</span>
        </a>
    </li>

    {{-- Kursus --}}
    <li class="sidebar-menu-item {{ Request::segment(2) == 'master_data' ? 'active open' : '' }}">
        <a class="sidebar-menu-button" data-toggle="collapse" href="#master_data_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">folder</span>
            Kursus
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent" id="master_data_menu">
            <?php $name = 'course'; ?>
            <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                    <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                </a>
            </li>
            <?php $name = 'offline_course'; ?>
            <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                    <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                </a>
            </li>
            <?php $name = 'group_category_course'; ?>
            <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                    <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                </a>
            </li>
            <?php $name = 'category_course'; ?>
            <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                    <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                </a>
            </li>
            <?php $name = 'level'; ?>
            <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                    <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                </a>
            </li>
        </ul>
    </li>

    {{-- Report --}}
    <li class="sidebar-menu-item {{ Request::segment(2) == 'report' ? 'active open' : '' }}">
        <a class="sidebar-menu-button js-sidebar-collapse" data-toggle="collapse" href="#report_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">receipt</span>
            Laporan
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent" id="report_menu">
            <?php $name = 'course_member'; ?>
            <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.report.' . $name . '.index') }}">
                    <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                </a>
            </li>
            <?php $name = 'recap_course'; ?>
            <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.report.' . $name . '.index') }}">
                    <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ Request::segment(3) == 'offline_course' ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.report.offline_course') }}">
                    <span class="sidebar-menu-text">Kursus Offline</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ Request::segment(3) == 'registrar_offline_course' ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.report.registrar_offline_course') }}">
                    <span class="sidebar-menu-text">Pendaftar Kursus Offline</span>
                </a>
            </li>
        </ul>
    </li>

    {{-- ADMIN & MEMBER --}}
    <li class="sidebar-menu-item {{ Request::segment(2) == 'account' ? 'active open' : '' }}">
        <a class="sidebar-menu-button js-sidebar-collapse" data-toggle="collapse" href="#account">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">account_circle</span>
            Akun
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent" id="account">
            <?php $name = 'account_member'; ?>
            <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                    <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                </a>
            </li>
            <?php $name = 'account_admin'; ?>
            <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                    <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                </a>
            </li>
        </ul>
    </li>
</ul>
