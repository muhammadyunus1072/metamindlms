<div class="page-section">
    <div class="page-separator">
        <div class="page-separator__text">Data Riwayat Transaksi.</div>
    </div>
    <div class="row card-group-row mb-2">
        <div class="col-md-3 mb-2">
            <label class="form-label">Jenis Tanggal</label>
            <select wire:model="jenis_tanggal" class="form-control">
                @foreach ($jenis_tanggal_choice as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    
        @if ($jenis_tanggal == 'rentang-waktu')
            <div class="col-md-3 mb-2">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" wire:model="start_date" />
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" wire:model="end_date" />
            </div>
        @endif
    
        <div class="col-md-3 mb-2">
            <label class="form-label">Status</label>
            <select class="form-control" wire:model="status">
                <option value="">Seluruh</option>
                @foreach (App\Models\TransactionStatus::STATUS_CHOICE as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="row card-group-row">
        <div class="col-md-12">
            <div class="card card-sm">
                @forelse ($transactions as $transaction)
                    <a class="card-body" href="{{route('admin.transaction.detail', ['id' => $transaction->id])}}">
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