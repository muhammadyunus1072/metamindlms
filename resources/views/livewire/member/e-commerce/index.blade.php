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
        <div class="row d-flex-justify-content-evenly">
            @foreach ($products as $product)
                <div class="col-md-12">
                    <div class="card px-lg-4">
                        <ul class="pricing card-body list-unstyled mb-0">
                            <li class="fs-3 border-bottom py-2 card-title"><strong>{{ $product->name }}</strong></li>
                            <li class="border-bottom py-2">{{ $product->description }}</li>
                            <li class="bg-light row justify-content-end align-items-end mb-2">
                                <div class="col-auto">
                                    <h3>Harga: @currency($product->price)</h3>
                                </div>
                                @if ($product->price_before_discount)
                                    <div class="col-auto">
                                        <del>
                                            <p class="h5">(Dari: @currency($product->price_before_discount) )</p>
                                        </del>
                                    </div>
                                @endif
                            </li>

                            <li class="fs-3 border-bottom py-2 card-title"><strong>Kursus Offline</strong></li>
                            @foreach ($product->productOfflineCourses as $product_offline_course)
                                <li class="fs-1 border-bottom py-2 d-flex justify-content-between w-75">
                                    <strong>{{ $product_offline_course->offlineCourse->title }}</strong>
                                    <a class="btn btn-info px-3 py-2" href="{{ route('offline_course.show', Crypt::encrypt($product_offline_course->offlineCourse->id)) }}" target="_blank">
                                        Detail
                                    </a>
                                </li>
                            @endforeach
                            <li class="fs-3 border-bottom py-2 card-title"><strong>Kursus Online</strong></li>
                            @foreach ($product->productCourses as $product_course)
                                <li class="fs-1 border-bottom py-2 d-flex justify-content-between w-75">
                                    <strong>{{ $product_course->course->title }}</strong>
                                    <a class="btn btn-info px-3 py-2" href="{{route('course.show', ['id' => enc($product_course->course->id)])}}" target="_blank">
                                        Detail
                                    </a>
                                </li>
                            @endforeach
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
            <em>Total Produk / Paket: {{ $products->total() }}</em>
        </div>
        <div class="col-auto">
            {{ $products->links() }}
        </div>
    </div>

</div>
