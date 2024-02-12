@push('css')
    <script type="text/javascript" src="{{ config('midtrans.snap_url') }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush
<div class="page-section">

    <div class="page-separator">
        <div class="page-separator__text">Data Riwayat Transaksi Anda.</div>
    </div>

    <div class="row card-group-row">
        @if (!empty($transaction))
            <div class="col-md-12">
                <div class="card card-sm">
                    <form wire:submit.prevent='save'>
                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap col-md-7 col-12">
                                <tbody>
                                    <tr>
                                        <td class="card-title text-left">
                                            <p class="my-0 py-0">Tanggal</p>
                                        </td>
                                        <td>:</td>
                                        <td colspan="3" class="card-title text-left">
                                            <p class="my-0 py-0">
                                                {{ Carbon\Carbon::parse($transaction->created_at)->format('d M Y') }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="card-title text-left">
                                            <p class="my-0 py-0">Nomor</p>
                                        </td>
                                        <td>:</td>
                                        <td colspan="3" class="card-title text-left">
                                            <p class="my-0 py-0">
                                                {{ $transaction->number }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="card-title text-left">
                                            <p class="my-0 py-0">Metode Pembayaran</p>
                                        </td>
                                        <td>:</td>
                                        <td colspan="3" class="card-title text-left">
                                            <p class="my-0 py-0">
                                                {{ $transaction->payment_method_name . '-' . $transaction->payment_method_description }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="card-title text-left">
                                            <p class="my-0 py-0">Status</p>
                                        </td>
                                        <td>:</td>
                                        <td colspan="3" class="card-title">
                                            {!! $transaction->status->get_beautify() !!}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered table-nowrap col-12">
                                <tbody>
                                    @foreach ($transaction->transactionDetails as $transactionDetail)
                                        <tr>
                                            <td class="card-title text-left">
                                                <p class="my-0 py-0">{{ $transactionDetail->product_name }}</p>
                                            </td>
                                            <td class="card-title text-right">
                                                @if ($transactionDetail->product_price_before_discount)
                                                    <p class="my-0 py-0 d-inline mr-2">
                                                        <del>@currency($transactionDetail->product_price_before_discount)</del>
                                                    </p>
                                                @endif
                                                <p class="my-0 py-0 d-inline">
                                                    @currency($transactionDetail->product_price)
                                                </p>
                                            </td>
                                        </tr>
                                        @if (count($transactionDetail->courses))
                                            <tr>
                                                <td colspan="2">
                                                    <h6 class="my-0 py-0 ml-3 fw-bold">Kursus Online</h6>

                                                    <ul class="list-group list-group-custom list-group-flush my-0 py-0 ml-3">
                                                    @foreach ($transactionDetail->courses as $course)
                                                        <li class="list-group-item my-0 py-0 ml-3"> - {{ $course->course_title }}</li>
                                                    @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endif
                                        @if (count($transactionDetail->offlineCourses))
                                            <tr>
                                                <td colspan="2">
                                                    <h6 class="my-0 py-0 ml-3 fw-bold">Kursus Offline</h6>

                                                    <ul class="list-group list-group-custom list-group-flush my-0 py-0 ml-3">
                                                    @foreach ($transactionDetail->offlineCourses as $offlineCourse)
                                                        <li class="list-group-item my-0 py-0 ml-3"> - {{ $offlineCourse->offline_course_title }}</li>
                                                    @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td class="card-title text-right">
                                            <p class="my-0 py-0 h3">TOTAL</p>
                                        </td>
                                        <td class="card-title text-right">
                                            <p class="my-0 py-0 d-inline">
                                                @currency($total)
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                                @if (
                                    $transaction->status->name != App\Models\TransactionStatus::STATUS_CANCEL &&
                                        $transaction->status->name != App\Models\TransactionStatus::STATUS_DONE)

                                    @if($transaction->payment_method_id == App\Models\PaymentMethod::MIDTRANS_ID)
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-block btn-success mb-2" wire:click="checkout">Bayar</button>
                                        </div>
                                    @else
                                    <div class="row mx-2">
                                        <div class="col-md-12">

                                            {{-- FILE --}}
                                            <div class="form-group">
                                                <label class="form-label" for="image">Upload Bukti Bayar :</label>
                                                <div class="custom-file">
                                                    <input type="file" wire:model.lazy="image"
                                                        class="custom-file-input  @error('image') is-invalid @enderror">
                                                    <label for="image" class="custom-file-label">
                                                        <div wire:loading.remove wire:target="image">
                                                            @if ($image)
                                                                {{ $image->getClientOriginalName() }}
                                                            @else
                                                                Pilih Gambar
                                                            @endif
                                                        </div>
                                                        <div wire:loading wire:target="image">
                                                            Uploading...
                                                        </div>
                                                    </label>
                                                    @error('image')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                @if ($image && empty($errors->get('image')))
                                                    <img class="img-fluid" src="{{ $image->temporaryUrl() }}"
                                                        style="width: 300px; height:auto">
                                                @elseif($oldImage != null)
                                                    <img class="img-fluid" src="{{ $oldImage }}"
                                                        style="width: 300px; height:auto">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-block btn-success mb-2">Simpan Bukti
                                                Bayar</button>
                                            <button type='button' class='btn btn-block btn-danger mb-3'
                                                wire:click="confirmCancelTransaction()">
                                                <i class='fa fa-trash mr-2'></i> Batalkan Transaksi
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <h3 class="text-center">Data Tidak Tersedia</h3>
            </div>
        @endif
    </div>

    <div class="card">
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:load', function() {
            window.livewire.on('midtransCheckout', (snapToken) => {
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
        window.addEventListener('openConfirmCancellationModal', event => {
            if (confirm('Batalkan Transaksi?')) {
                @this.cancelTransaction();
            }
        });
    </script>
@endpush
