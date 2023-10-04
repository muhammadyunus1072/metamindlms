<form wire:submit.prevent="save">
    <div class="row">
        <div class="col-md-12">
            <div class="page-separator">
                <div class="page-separator__text">Informasi Dasar</div>
            </div>

            <div class="card">
                <div class="card-body">

                    {{-- EMAIL --}}
                    <div class="form-group">
                        <label class="form-label" for="email">Email :</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            wire:model.lazy="email">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- NAME --}}
                    <div class="form-group">
                        <label class="form-label" for="name">Nama :</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            wire:model.lazy="name">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="form-group">
                        <label class="form-label" for="password">Password :</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            wire:model.lazy="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- RETYPE PASSWORD --}}
                    <div class="form-group">
                        <label class="form-label" for="retype_password">Ketik Ulang Password :</label>
                        <input type="password" class="form-control @error('retype_password') is-invalid @enderror"
                            wire:model.lazy="retype_password">
                        @error('retype_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button wire:loading.remove wire:target="save" type="button" onclick="history.back();"
                                class="btn btn-outline-primary px-4">
                                Kembali
                            </button>
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
