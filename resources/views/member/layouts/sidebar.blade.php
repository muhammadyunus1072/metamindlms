<a href="{{ route('member.dashboard.index') }}" class="sidebar-brand ">
    <span class="avatar avatar-xl sidebar-brand-icon h-auto">
        <span class="avatar-title rounded bg-white">
            <img src="{{ asset('ic_logo.png') }}" class="img-fluid" alt="logo" />
        </span>
    </span>
</a>

<div class="sidebar-heading">Member</div>
<ul class="sidebar-menu">
    <li class="sidebar-menu-item {{ Request::segment(1) == 'course' || Request::segment(1) == 'offline_course' ? 'active' : '' }}">
        <a class="sidebar-menu-button" href="{{ route('course.index') }}">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">search</span>
            <span class="sidebar-menu-text">Cari Kursus</span>
        </a>
    </li>
    <li class="sidebar-menu-item {{ Request::segment(2) == 'e_commerce'? 'active' : '' }}">
        <a class="sidebar-menu-button" href="{{ route('member.e_commerce.index') }}">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">shopping_cart</span>
            <span class="sidebar-menu-text">E-Commerce</span>
        </a>
    </li>
    {{-- <li class="sidebar-menu-item {{ Request::segment(1) == 'offline_course' ? 'active' : '' }}">
        <a class="sidebar-menu-button" href="{{ route('offline_course.index') }}">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">search</span>
            <span class="sidebar-menu-text">Cari Kursus Offline</span>
        </a>
    </li> --}}

    @if (Auth::check())
       
        <li
            class="sidebar-menu-item {{ Request::segment(2) == 'cart' ? 'active' : '' }}">
            <a class="sidebar-menu-button" href="{{ route('member.cart.index') }}">
                <i class="fa fa-shopping-cart sidebar-menu-icon sidebar-menu-icon--left"></i>
                <span class="sidebar-menu-text">Keranjang</span>
            </a>
        </li>
        <li
            class="sidebar-menu-item {{ Request::segment(2) == 'transaction_history' ? 'active' : '' }}">
            <a class="sidebar-menu-button" href="{{ route('member.transaction.index') }}">
                <i class="fa fa-history sidebar-menu-icon sidebar-menu-icon--left"></i>
                <span class="sidebar-menu-text">Riwayat Transaksi</span>
            </a>
        </li>
        <li
            class="sidebar-menu-item {{ Request::segment(1) == 'member' && Request::segment(2) === null ? 'active' : '' }}">
            <a class="sidebar-menu-button" href="{{ route('member.dashboard.index') }}">
                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">home</span>
                <span class="sidebar-menu-text">Dashboard</span>
            </a>
        </li>
        <li class="sidebar-menu-item {{ Request::segment(2) == 'qr_scan' ? 'active' : '' }}">
            <a class="sidebar-menu-button" href="{{ route('member.qr_scan.index') }}">
                <i class="fa fa-qrcode sidebar-menu-icon sidebar-menu-icon--left"></i>
                <span class="sidebar-menu-text">Scan QR</span>
            </a>
        </li>

        <li class="sidebar-menu-item {{ Request::segment(2) == 'course_member' ? 'active' : '' }}">
            <a class="sidebar-menu-button" href="{{ route('member.course_member.index') }}">
                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">local_library</span>
                <span class="sidebar-menu-text">Kursus Saya</span>
            </a>
        </li>

        <li class="sidebar-menu-item {{ Request::segment(2) == 'favorite' ? 'active' : '' }}">
            <a class="sidebar-menu-button" href="{{ route('member.favorite.index') }}">
                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">favorite</span>
                <span class="sidebar-menu-text">Kursus Favorit Saya</span>
            </a>
        </li>

        <li class="sidebar-menu-item {{ Request::segment(2) == 'discussion' ? 'active' : '' }}">
            <a class="sidebar-menu-button" href="{{ route('member.discussion.index') }}">
                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">people_outline</span>
                <span class="sidebar-menu-text">Diskusi Saya</span>
            </a>
        </li>
    @endif
</ul>
