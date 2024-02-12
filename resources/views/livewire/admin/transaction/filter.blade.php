<div class="row card-group-row mb-2 align-items-end">
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