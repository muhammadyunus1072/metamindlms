<div class="container page__container">

    <div class="row">
        <div class="col">
            <div class="page-separator">
                <div class="page-separator__text">Produk</div>
            </div>
        </div>

        <div class="col-auto">
            <a href="" class="btn btn-link btn-sm"><u>Lihat Produk</u></a>
        </div>
    </div>

    <div class="mb-lg-8pt">
        <div class="row d-flex-justify-content-evenly">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card px-lg-4">
                        <ul class="pricing card-body list-unstyled text-center mb-0">
                            <li class="fs-3 border-bottom py-2 card-title"><strong>{{$product->name}}</strong></li>
                            <li class="border-bottom py-2">{{$product->description}}</li>
                            <li class="bg-light py-2">
                                <h3>{{$product->price}}</h3>
                                @if ($product->price_before_discount)
                                <del><p class="h5">{{$product->price_before_discount}}</p class="h5"></del>
                                @endif
                            </li>
                            <li class="pt-3"><button class="btn btn-success px-3 py-2" wire:click="store('{{$product->id}}', true)">Beli Sekarang</button></li>
                            <li class="pt-3"><button class="btn btn-primary px-3 py-2" wire:click="store('{{$product->id}}', false)">Tambah Keranjang</button></li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</div>