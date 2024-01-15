<div class="page-section">

    <div class="page-separator">
        <div class="page-separator__text">Data kursus dalam keranjang anda.</div>
    </div>

    <div class="row card-group-row">
        
            <div class="col-md-12">
                <div class="card card-sm">
                    <form wire:submit.prevent='checkout'>
                        <div class="table-responsive">
                            <table class="table table-bordered table-nowrap w-100">
                                <tbody>
                                    @forelse ($user->carts as $item)
                                        <tr>
                                            <td class="text-center">
                                                <p class="bold h6">{{ $item->product->name }}</p>
                                            </td>
                                            <td class="text-center">
                                                @if ($item->product->price_before_discount)
                                                    <p class="my-0"><del>{{$item->product->price_before_discount}}</del></p>
                                                @endif
                                                <p class="my-0">{{$item->product->price}}</p>
                                            </td>
                                            <td>
        
                                                <button type="button" class="btn btn-danger" wire:click="deleteCart('{{$item->id}}')">
                                                    <i class='fa fa-trash mr-2'></i>Hapus
                                                </button>
                                            </td>
                                        </tr>
    
                                    @empty   
                                        <tr>
                                            <td colspan="3">
                                                <h3 class="text-center">Belum Terdapat Kursus Dalam Keranjang Anda.</h3>
                                            </td>
                                        </tr>
                                    @endforelse
                                    @if (!$user->carts)
                                        <tr>
                                            <td class="card-title text-right"><p class="h3">TOTAL</p></td>
                                            <td colspan="3" class="card-title text-center">
                                                <p class="h3">
                                                    {{$total}}
                                                </p>
                                            </td>
                                        </tr>
        
                                        <tr>
                                            <td class="card-title text-right"><p class="h3">Pilih Metode Pembayaran</p></td>
                                            <td colspan="2" class="card-title text-center">
                                                <select class="form-control" wire:model="input_payment_method" required>
                                                    <option value="">Pilih Metode Pembayaran</option>
                                                    @foreach ($payment_method_choices as $item)
                                                        <option value="{{$item->id}}">{{$item->name ."-". $item->description}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="card-title text-right" colspan="3">
                                                <div class="d-flex justify-content-end">
                                                    <div class="col-md-4 col-6">
            
                                                        <button type="submit"
                                                        class="btn btn-block btn-success mb-3 "
                                                        >Checkout</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>