<div>
    <div class="container page__container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-section">
                    <div class="page-nav__content">
                        <div class="page-separator">
                            <div class="page-separator__text">Soal Quiz</div>
                        </div>

                        <div class="row mb-0 text-justify">
                            <div class="col">
                                <form>
                                    @forelse ($lesson_questions as $item)
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Soal No. {{ $item->number }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <h4 class="card-title mb-3">{{ $item->text }}</h4>
                                                @forelse ($item->choices as $key => $choice)
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input wire:model.defer='selectedAnswers'
                                                                id="{{ $choice['text'] }}" type="checkbox"
                                                                value="{{ $choice['text'] }}"
                                                                class="custom-control-input">
                                                            <label for="{{ $choice['text'] }}"
                                                                class="custom-control-label">
                                                                {{ $choice['text'] }}</label>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <h4>Data belum tersedia</h4>
                                                @endforelse
                                                <p class="text-muted">*Jawaban dapat lebih dari 1</p>
                                            </div>
                                        </div>
                                    @empty
                                        <h4 class="text-center">Pertanyaan Belum Tersedia</h4>
                                    @endforelse
                                    <button wire:click='submitAnswer'
                                        onclick="return  confirm('Yakin akan kumpul Quiz?')"
                                        class="btn btn-primary text-end">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
