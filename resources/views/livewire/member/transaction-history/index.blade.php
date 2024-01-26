<div class="page-section">

    <div class="page-separator">
        <div class="page-separator__text">Data Riwayat Transaksi Anda.</div>
    </div>

    <div class="row card-group-row">
        
            <div class="col-md-12">
                <div class="card card-sm">
                    @forelse ($user->transactions as $transaction)
                        <a class="card-body" href="{{route('member.transaction.detail', ['id' => $transaction->id])}}">
                            <ul class="list-group list-group-custom">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="bold h5">{{Carbon\Carbon::parse($transaction->created_at)->format('d M Y')}}</p>
                                    {!! $transaction->status->get_beautify() !!}
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$transaction->number}}
                                </li>
                                @foreach ($transaction->transactionDetails as $transactionDetail)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$transactionDetail->product_name}}
                                        <p class="h6">{{App\Helpers\NumberFormatter::format($transactionDetail->product_price, 0, '.', '.')}}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </a>
                    @empty
                        
                    @endforelse
                </div>
            </div>
    </div>
</div>