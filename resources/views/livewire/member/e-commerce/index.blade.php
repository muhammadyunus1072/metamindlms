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
                            <li class="bg-light row justify-content-end align-items-end">
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

</div>
