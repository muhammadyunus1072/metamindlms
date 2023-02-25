<div class="mdk-drawer js-mdk-drawer "
    id="library-drawer"
    data-align="end">
    <div class="mdk-drawer__content ">
        <div class="sidebar sidebar-light sidebar-right py-16pt"
                data-perfect-scrollbar
                data-perfect-scrollbar-wheel-propagation="true">

            <div class="d-flex align-items-center mb-24pt  d-lg-none">
                <form action="index.html"
                        class="search-form search-form--light mx-16pt pr-0 pl-16pt">
                    <input type="text"
                            class="form-control pl-0"
                            placeholder="Search">
                    <button class="btn"
                            type="submit"><i class="material-icons">search</i></button>
                </form>
            </div>

            <?php 
                $category_filter = request()->input('category_filter') ?? array();
                $level_filter = request()->input('level_filter') ?? array();
            ?>

            <form action="{{ route('member.course.search') }}" class="m-0" id="form_search">
                <div class="sidebar-heading">Kategori</div>
                <div class="sidebar-block">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input"
                                    type="checkbox"
                                    value="semua"
                                    id="category_filter_all"
                                    name="category_filter[]"
                                    
                                    @if (in_array('semua', $category_filter))
                                        checked
                                    @endif>
                            <label class="custom-control-label"
                                    for="category_filter_all">
                                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">brush</span>
                                <span class="sidebar-menu-text">Semua</span>
                            </label>
                        </div>
                    </div>
                    @foreach ($category_data as $v)
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input"
                                        type="checkbox"
                                        value="{{ $v->name }}"
                                        id="category_filter_{{ $v->name }}"
                                        name="category_filter[]"
                                        
                                        @if (in_array($v->name, $category_filter))
                                            checked
                                        @endif>
                                <label class="custom-control-label"
                                        for="category_filter_{{ $v->name }}">
                                    <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">brush</span>
                                    <span class="sidebar-menu-text">{{ $v->name }}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="sidebar-heading">Tingkat</div>
                <div class="sidebar-block">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input"
                                    type="checkbox"
                                    value="semua"
                                    id="level_filter_all"
                                    name="level_filter[]"

                                    @if (in_array('semua', $level_filter))
                                        checked
                                    @endif>
                            <label class="custom-control-label"
                                    for="level_filter_all">
                                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">brush</span>
                                <span class="sidebar-menu-text">Semua</span>
                            </label>
                        </div>
                    </div>
                    @foreach ($level_data as $v)
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input"
                                        type="checkbox"
                                        value="{{ $v->name }}"
                                        id="level_filter_{{ $v->name }}"
                                        name="level_filter[]"

                                        @if (in_array($v->name, $level_filter))
                                            checked
                                        @endif>
                                <label class="custom-control-label"
                                        for="level_filter_{{ $v->name }}">
                                    <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">brush</span>
                                    <span class="sidebar-menu-text">{{ $v->name }}</span>        
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card-body">
                    <button type="submit" class="btn btn-block btn-outline-primary mb-3">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
