<div class="container page__container">

    <div class="row">
        <div class="col">
            <div class="page-separator">
                <div class="page-separator__text">Produk / Paket</div>
            </div>
        </div>

        <div class="col-auto">
            <a href="" class="btn btn-link btn-sm"><u>Lihat Produk / Paket</u></a>
        </div>
    </div>

    <div class="mb-lg-8pt">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-24pt"
        style="white-space: nowrap;">
            <div class="form-group flex mr-3 mb-2 mb-sm-0">
                    <div class="row">
                        <div class="col-lg">
                            <div class="search-form form-control-rounded search-form--dark">
                                <input type="text"
                                        class="form-control"
                                        placeholder="Cari Produk / Paket"
                                        wire:model="filter_search">
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="mb-lg-8pt">
        <div class="row d-flex-justify-content-evenly">
            @foreach ($products as $product)
                <div class="col-md-12">
                    <div class="card px-lg-4">
                        <ul class="pricing card-body list-unstyled mb-0">
                            <li class="fs-3 border-bottom py-2 card-title"><strong>{{ $product->name }}</strong></li>
                            <li class="border-bottom py-2">{{ $product->description }}</li>

                            {{-- OFFLINE COURSE --}}
                            @if (count($product->productOfflineCourses) > 0)
                                <div class='row ml-1 mt-2'>
                                    <h5>Kursus Offline</h5>
                                    @foreach ($product->productOfflineCourses as $product_offline_course)
                                        <div class="col-md-12 row">
                                            <div class='col font-italic'>
                                                {{ $product_offline_course->offlineCourse->title }}
                                            </div>
                                            <div class='col-auto'>
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('offline_course.show', Crypt::encrypt($product_offline_course->offlineCourse->id)) }}"
                                                    target="_blank">
                                                    Lihat Kursus
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- ONLINE COURSE --}}
                            @if (count($product->productCourses) > 0)
                                <div class='row ml-1 mt-2'>
                                    <h5>Kursus Online</h5>
                                    @foreach ($product->productCourses as $product_course)
                                        <div class="col-md-12 row">
                                            <div class='col font-italic'>
                                                {{ $product_course->course->title }}
                                            </div>
                                            <div class='col-auto'>
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('course.show', ['id' => enc($product_course->course->id)]) }}"
                                                    target="_blank">
                                                    Lihat Kursus
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- PRICE --}}
                            <li class="bg-light row justify-content-end align-items-end mt-3 py-2">
                                @if ($product->price_before_discount)
                                    <div class="col-auto">
                                        <del>
                                            <h5 class='m-0 p-0'>@currency($product->price_before_discount)</h5>
                                        </del>
                                    </div>
                                @endif
                                <div class="col-auto">
                                    <h3 class='m-0 p-0'>@currency($product->price)</h3>
                                </div>
                            </li>

                            <li class="pt-3">
                                <button class="btn btn-primary px-3 py-2"
                                    wire:click="store('{{ $product->id }}', false)">Tambah Keranjang</button>
                                <button class="btn btn-success px-3 py-2"
                                    wire:click="store('{{ $product->id }}', true)">Beli Sekarang
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <div class="row justify-content-end mt-3">
        <div class="col">
            <em>Total Data: {{ $products->total() }}</em>
        </div>
        <div class="col-auto">
            {{ $products->links() }}
        </div>
    </div>

</div>
