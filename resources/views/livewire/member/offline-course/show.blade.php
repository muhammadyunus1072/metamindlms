<div>
    <div class="mdk-box bg-primary js-mdk-box mb-0"
        style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),url({{ $image }}); background-size: cover;"
        data-effects="blend-background">

        <div class="mdk-box__content">
            <div class="hero py-64pt text-center text-sm-left">
                <div class="container page__container">
                    <h1 class="text-white">{{ $title }}</h1>
                    <p class="lead text-white-50 measure-hero-lead"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
        <div class="container page__container">
            <ul class="nav navbar-nav flex align-items-sm-center">
                <li class="nav-item navbar-list__item">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <p class=" card-title m-0 lead text-70 measure-lead mx-auto"></p>
                        </div>
                    </div>
                </li>
                <li class="nav-item navbar-list__item">
                    <i class="material-icons text-muted icon--left">people</i>
                    Kuota : {{ $quota }}
                </li>
                <li class="nav-item navbar-list__item">
                    <i class="material-icons text-muted icon--left">class</i>
                    Kategory : @foreach ($categories as $key => $name)
                        <div class="btn btn-outline-info btn-sm mx-1">{{ $name }}</div>
                    @endforeach
                </li>
            </ul>
        </div>
    </div>

    <div class="page-section border-bottom-2">
        <div class="container page__container">

            <div class="page-separator">
                <div class="page-separator__text">Konten kursus</div>
            </div>
            <div class="row mb-0">
                <div class="col-lg-7">


                </div>
                <div class="col-lg-5 justify-content-center">

                    <div class="card">
                        <div class="card-body py-16pt">
                            <h2></h2>

                            <button class="btn btn-block btn-primary mb-3">Scan QR-CODE</button>

                            <h6 class="card-title mb-2">Kursus ini mencakup</h6>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center mb-8pt">
                                        <span class="material-icons icon-16pt mr-8pt">format_list_bulleted</span>
                                        <p class="flex lh-1 mb-0"></p>
                                    </div>
                                    <div class="d-flex align-items-center mb-8pt">
                                        <span class="material-icons icon-16pt mr-8pt">play_circle_outline</span>
                                        <p class="flex lh-1 mb-0"></p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-icons icon-16pt mr-8pt">assessment</span>
                                        <p class="flex lh-1 mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="page-section bg-white border-bottom-2">

        <div class="container page__container">
            <div class="row ">
                <div class="col-md-7">
                    <div class="page-separator">
                        <div class="page-separator__text">Tentang Kursus Ini</div>
                    </div>
                    <p class="text-70 mb-0 text-justify">

                    </p>
                </div>
                <div class="col-md-5">
                    <div class="page-separator">
                        <div class="page-separator__text bg-white">Apa yang akan anda pelajari</div>
                    </div>
                    <ul class="list-unstyled">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
