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
                                        <td class="card-title text-left"><p class="my-0 py-0">Tanggal</p></td>
                                        <td>:</td>
                                        <td colspan="3" class="card-title text-left">
                                            <p class="my-0 py-0">
                                                {{Carbon\Carbon::parse($transaction->created_at)->format('d M Y')}}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="card-title text-left"><p class="my-0 py-0">Nomor</p></td>
                                        <td>:</td>
                                        <td colspan="3" class="card-title text-left">
                                            <p class="my-0 py-0">
                                                {{$transaction->number}}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="card-title text-left"><p class="my-0 py-0">Metode Pembayaran</p></td>
                                        <td>:</td>
                                        <td colspan="3" class="card-title text-left">
                                            <p class="my-0 py-0">
                                                {{$transaction->payment_method_name ."-". $transaction->payment_method_description}}
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered table-nowrap col-12">
                                <tbody>
                                        @foreach ($transaction->transactionDetails as $transactionDetail)
                                            <tr>
                                                <td class="card-title text-left"><p class="my-0 py-0">{{$transactionDetail->product_name}}</p></td>
                                                <td class="card-title text-left">
                                                    @if ($transactionDetail->product_price)
                                                        
                                                    <p class="my-0 py-0 d-inline mr-2">
                                                        <del>{{App\Helpers\NumberFormatter::format($transactionDetail->product_price, 0, '.', '.')}}</del>
                                                    </p>
                                                    @endif
                                                    <p class="my-0 py-0 d-inline">
                                                        {{App\Helpers\NumberFormatter::format($transactionDetail->product_price, 0, '.', '.')}}
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="card-title text-center"><p class="my-0 py-0 h3">TOTAL</p></td>
                                            <td class="card-title text-left">
                                                <p class="my-0 py-0 d-inline">
                                                    {{App\Helpers\NumberFormatter::format($total, 0, '.', '.')}}
                                                </p>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
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
                                            <img class="img-fluid" src="{{ $oldImage }}" style="width: 300px; height:auto">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @if($transaction->status->name != App\Models\TransactionStatus::STATUS_CANCEL && $transaction->status->name != App\Models\TransactionStatus::STATUS_DONE)
                                        <button type="submit"
                                        class="btn btn-block btn-success mb-2"
                                        >Simpan Bukti Bayar</button>
                                        <button type='button' class='btn btn-block btn-danger mb-3' wire:click="confirmCancelTransaction()">
                                            <i class='fa fa-trash mr-2'></i> Batalkan Transaksi
                                        </button>
                                    @endif
                                </div>
                            </div>
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
        window.addEventListener('openConfirmCancellationModal', event => {
            if (confirm('Batalkan Transaksi?')) {
                @this.cancelTransaction();
            }
        });
    </script>
@endpush