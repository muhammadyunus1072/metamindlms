 <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-24pt"
        style="white-space: nowrap;">
    <div class="form-group flex mr-3 mb-2 mb-sm-0">
        <form action="{{ $list_route['search'] }}" class="m-0" id="form_search">
            <div class="row">
                <div class="col-lg">
                    <div class="search-form form-control-rounded search-form--dark">
                        <input type="text"
                                class="form-control"
                                placeholder="Cari Kursus"
                                name="text_filter"
                                value="{{ request()->input('text_filter') ?? '' }}">
                        <button class="btn"
                                type="submit"><i class="material-icons">search</i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <a href="#"
        data-target="#library-drawer"
        data-toggle="sidebar"
        class="btn btn-sm btn-white ml-sm-16pt">
        <i class="material-icons icon--left">tune</i> Filters
    </a>

</div>