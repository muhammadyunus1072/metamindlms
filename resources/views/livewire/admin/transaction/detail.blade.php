<div class="page-section">

    <div class="page-separator">
        <div class="page-separator__text">Data Riwayat Transaksi Anda.</div>
    </div>

    <div class="row card-group-row">
        @if (!empty($transaction))
            <div class="col-md-12">
                <div class="card card-sm">
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
                                            @if ($transactionDetail->product_price)
                                                <p class="my-0 py-0 d-inline mr-2">
                                                    <del>@currency($transactionDetail->product_price)</del>
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
                                                        <li class="list-group-item d-flex justify-content-between my-0 py-0">
                                                            <p class="my-0 py-0">
                                                                 - {{ $course->course_title }}
                                                            </p>
                                                            <p class="my-0 py-0">
                                                                @currency($course->course_price)
                                                            </p>
                                                        </li>
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
                                                        <li class="list-group-item d-flex justify-content-between my-0 py-0">
                                                            <p class="my-0 py-0">
                                                                 - {{ $offlineCourse->offline_course_title }}
                                                            </p>
                                                            <p class="my-0 py-0">
                                                                @currency($offlineCourse->offline_course_price)
                                                            </p>
                                                        </li>
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
                        <div class="row mx-2">
                            @if($oldImage != null)
                                <div class="col-md-12">
                                    {{-- FILE --}}
                                    <div class="form-group">
                                        <label class="form-label w-100" for="image">Bukti Bayar :</label>
                                        <a href="{{ $oldImage }}" target="_blank" download="bukti_bayar_{{ $transaction->number }}">
                                            <img class="img-fluid" src="{{ $oldImage }}"
                                                style="width: 300px; height:auto">
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <h3 class="text-center">Belum Terdapat Bukti Bayar.</h3>
                                </div>
                            @endif
                            <div class="col-md-12">
                                @if (
                                    $transaction->status->name != App\Models\TransactionStatus::STATUS_CANCEL &&
                                        $transaction->status->name != App\Models\TransactionStatus::STATUS_DONE)
                                    <button type="button" class="btn btn-block btn-success mb-2"
                                        wire:click="confirmDoneTransaction()">Selesai</button>
                                    <button type='button' class='btn btn-block btn-danger mb-3'
                                        wire:click="confirmCancelTransaction()">
                                        <i class='fa fa-trash mr-2'></i> Batalkan Transaksi
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
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
        window.addEventListener('openConfirmTransactionModal', event => {
            if (confirm('Selesaikan Transaksi?')) {
                @this.confirmTransaction();
            }
        });
    </script>
@endpush
