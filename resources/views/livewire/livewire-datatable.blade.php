<div>
    @yield('top_content')

    <div class="row justify-content-between mb-3">
        <div class="col-auto">
            <label>Show</label>
            <select wire:model="length" class="form-control">
                @foreach ($lengthOptions as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="col col-md-6">
            <label>Kata Kunci</label>
            <input wire:model="search" type="text" class="form-control">
        </div>
    </div>

    <div class="position-relative">
        <div wire:loading.block>
            <div class="position-absolute w-100 h-100">
                <div class="w-100 h-100" style="background-color: grey; opacity:0.2"></div>
            </div>
            <h5 class="position-absolute shadow bg-white p-2 rounded"
                style="top: 50%;left: 50%;transform: translate(-50%, -50%);">Loading...</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-nowrap w-100 h-100">
                <thead>
                    <tr>
                        @foreach ($columns as $col)
                            <th>
                                @if (!isset($col['sortable']) || $col['sortable'])
                                    <button class='btn' wire:click="sortBy('{{ $col['key'] }}')">
                                        {{ $col['name'] }}

                                        <div class="ml-1">
                                            <i
                                                class="fa fa-arrow-down
                                            {{ $col['key'] == $sortBy && $sortDirection == 'asc' ? '' : 'text-muted' }}"></i>
                                            <i
                                                class="fa fa-arrow-up
                                            {{ $col['key'] == $sortBy && $sortDirection == 'desc' ? '' : 'text-muted' }}"></i>
                                        </div>
                                    </button>
                                @else
                                    {{ $col['name'] }}
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            @foreach ($columns as $col)
                                @if (isset($col['render']) && is_callable($col['render']))
                                    <td>{!! call_user_func($col['render'], $item) !!}</td>
                                @elseif (isset($col['key']))
                                    <td>{{ $item[$col['key']] }}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-end mt-3">
        <div class="col">
            <label>Total Data: {{ $data->total() }}</label>
        </div>
        <div class="col-auto">
            {{ $data->links() }}
        </div>
    </div>
</div>
