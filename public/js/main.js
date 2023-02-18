function loading(action) {
    if (action == "show") {
        $.LoadingOverlay('show');
    }

    if (action == "hide") {
        $.LoadingOverlay('hide');
    }
}

function alert_error(error, xhr){
    if (error == "show") {
        Swal.fire('Gagal!', 'Terjadi kesalahan dalam memproses, harap menghubungi Administrator' + xhr.responseText, 'error');
    }

    if (error == "hide") {
        Swal.fire('Gagal!', 'Terjadi kesalahan dalam memproses, harap menghubungi Administrator', 'error');
    }
}

function course_item_sm(results_data){
    let learn_description_text = "";

    results_data.learn_description.forEach(v => {
        learn_description_text += `
        <div class="d-flex align-items-top">
            <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
            <p class="flex text-50 lh-1 mb-0 text-justify"><small>${ v.description }</small></p>
        </div>
        `;
    });

    return `
    <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

        <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal card-group-row__card"
                
                data-partial-height="44"
                data-toggle="popover"
                data-trigger="click">

            <a href="student-course.html"
                class="js-image"
                data-position="">
                <img src="'. asset('/assets/images/paths/mailchimp_430x168.png') .'
                        alt="course">
                <span class="overlay__content align-items-start justify-content-start">
                    <span class="overlay__action card-body d-flex align-items-center">
                        <i class="material-icons mr-4pt">play_circle_outline</i>
                        <span class="card-title text-white">Preview</span>
                    </span>
                </span>
            </a>

            <div class="mdk-reveal__content">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex">
                            <a class="card-title"
                                href="student-course.html">${results_data.title}</a>
                            <small class="text-50 font-weight-bold mb-4pt">${results_data.level_name}</small>
                        </div>
                        <a href="student-course.html"
                            data-toggle="tooltip"
                            data-title="Remove Favorite"
                            data-placement="top"
                            data-boundary="window"
                            class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite</a>
                    </div>
                    <div class="d-flex">
                        <div class="rating flex">
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                        </div>
                        <small class="text-50">6 hours</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="popoverContainer d-none">
            <div class="media">
                <div class="media-left mr-12pt">
                    <img src="../../public/images/paths/mailchimp_40x40@2x.png"
                            width="40"
                            height="40"
                            alt="Angular"
                            class="rounded">
                </div>
                <div class="media-body">
                    <div class="card-title mb-0">${results_data.title}</div>
                    <p class="lh-1 mb-0">
                        <span class="text-50 small font-weight-bold">${results_data.level_name}</span>
                    </p>
                </div>
            </div>

            <p class="my-16pt text-70">${results_data.description}</p>

            <div class="mb-16pt">
                ${learn_description_text}
            </div>

            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="d-flex align-items-center mb-4pt">
                        <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                        <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                    </div>
                    <div class="d-flex align-items-center mb-4pt">
                        <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                        <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                        <p class="flex text-50 lh-1 mb-0"><small>Beginner</small></p>
                    </div>
                </div>
                <div class="col text-right">
                    <a href="student-course.html"
                        class="btn btn-primary">Lihat Trailer</a>
                </div>
            </div>

        </div>

    </div>
    `;
}   