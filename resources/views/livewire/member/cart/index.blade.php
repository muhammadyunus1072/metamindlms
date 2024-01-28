@push('css')
    <script type="text/javascript" src="{{ config('midtrans.snap_url') }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush
<div class="page-section">

    <div class="page-separator">
        <div class="page-separator__text">Data kursus dalam keranjang anda.</div>
    </div>

    <div class="row card-group-row">
        <div class="col-md-12">
            <div class="card">
                <form wire:submit.prevent='checkout'>
                    <div class="table-responsive">
                        <table class="table table-bordered w-100">
                            <tbody>
                                @forelse ($user->carts as $item)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="deleteCart('{{ $item->id }}')">
                                                <i class='fa fa-trash mr-2'></i>Hapus
                                            </button>
                                        </td>
                                        <td>
                                            <h5 class="bold text-wrap">{{ $item->product->name }}</h5>
                                        </td>
                                        <td class="text-right">
                                            @if ($item->product->price_before_discount)
                                                <h6 class="m-0 p-0">
                                                    <del>@currency($item->product->price_before_discount)</del>
                                                </h6>
                                            @endif
                                            <h5 class="m-0 p-0">@currency($item->product->price)</h5>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <h3 class="text-center">Belum Terdapat Kursus Dalam Keranjang Anda.</h3>
                                        </td>
                                    </tr>
                                @endforelse

                                @if ($carts->count() > 0)
                                    <tr>
                                        <td colspan="2" class="card-title text-right">
                                            <h3>Total</h3>
                                        </td>
                                        <td class="card-title text-right">
                                            <h3>@currency($total)</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="card-title text-right">
                                            <h3>Metode Pembayaran</h3>
                                        </td>
                                        <td class="card-title text-center">
                                            <select class="form-control" wire:model="input_payment_method" required>
                                                <option value="">Pilih Metode Pembayaran</option>
                                                @foreach ($payment_method_choices as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->name . '-' . $item->description }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    @if ($instruction)
                                        <tr>
                                            <td colspan="4">
                                                {!! $instruction !!}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="card-title text-right" colspan="3">
                                            <div class="d-flex justify-content-end">
                                                <div class="col-md-4 col-6">

                                                    <button type="submit"
                                                        class="btn btn-block btn-success mb-3 ">Checkout</button>
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

@push('js')
    <script type="text/javascript">
        document.addEventListener('livewire:load', function() {
            window.livewire.on('midtransCheckout', (snapToken) => {
                console.log(snapToken)
                window.snap.pay(snapToken, {
                    onSuccess: function(result) {
                        window.location.href = "{{ route('member.transaction.index') }}";
                    },
                    onError: function(result) {
                        Livewire.emit('onFailSweetAlert', 'Pembayaran Gagal!');
                    },
                    onClose: function() {
                        Livewire.emit('onFailSweetAlert', 'Pembayaran Ditutup!');
                    }
                })
            });
        });
    </script>
@endpush
