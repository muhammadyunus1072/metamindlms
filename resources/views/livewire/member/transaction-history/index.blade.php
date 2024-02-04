<div class="page-section">

    <div class="page-separator">
        <div class="page-separator__text">Data Riwayat Transaksi Anda.</div>
    </div>

    <div class="row card-group-row mb-2">
        <div class="col-md-6 mb-2">
            <label class="form-label">Kata Kunci</label>
            <input type="text" class="form-control" wire:model.lazy="search" placeholder="Kata Kunci">
        </div>

        <div class="col-md-3 mb-2">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" wire:model="start_date" />
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" class="form-control" wire:model="end_date" />
        </div>

    </div>

    <div class="row card-group-row">
        <div class="col-md-12">
            <div class="card card-sm">
                @forelse ($transactions as $transaction)
                    @php
                        $total = 0;
                    @endphp
                    <a class="card-body" href="{{ route('member.transaction.detail', ['id' => $transaction->id]) }}">
                        <ul class="list-group list-group-custom">
                            <li class="list-group-item">
                                <div class='row'>
                                    <div class='col'>
                                        <div class="bold h5 m-0 p-0">
                                            {{ Carbon\Carbon::parse($transaction->created_at)->format('d M Y') }}
                                        </div>
                                        <div class='font-italic'>
                                            Nomor: {{ $transaction->number }}
                                        </div>
                                    </div>
                                    <div class='col-auto'>
                                        {!! $transaction->status->get_beautify() !!}
                                    </div>
                                </div>
                            </li>
                            @foreach ($transaction->transactionDetails as $transactionDetail)
                                @php
                                    $total += $transactionDetail->product_price;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center py-0">
                                    {{ $transactionDetail->product_name }}
                                    <p class="h6">
                                        {{ App\Helpers\NumberFormatter::format($transactionDetail->product_price, 0, '.', '.') }}
                                    </p>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <p class="my-0 py-0 h3">TOTAL</p>
                                <p class="my-0 py-0 h4">@currency($total)</p>
                            </li>
                        </ul>
                    </a>
                @empty

                @endforelse
            </div>
        </div>
    </div>

    <div class="row justify-content-end mt-3">
        <div class="col">
            <em>Total Data: {{ $transactions->total() }}</em>
        </div>
        <div class="col-auto">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
