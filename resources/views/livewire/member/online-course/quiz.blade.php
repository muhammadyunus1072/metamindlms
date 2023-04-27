<div class="container page__container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-section">
                <div class="page-nav__content">
                    <div class="page-separator">
                        <div class="page-separator__text">Soal Quiz</div>
                    </div>
                    <form wire:submit.prevent='submitAnswer'>
                        @forelse ($lesson_questions as $questionIndex => $question)
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Soal No. {{ $question['number'] }}</h4>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title mb-3">{{ $question['text'] }}</h4>
                                    @forelse ($question['choices'] as $choiceIndex => $choiceText)
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="{{ $questionIndex }}_{{ $choiceIndex }}"
                                                    value="{{ $choiceText }}"
                                                    wire:model="selected_answers.{{ $question['id'] }}.{{ $choiceIndex }}">
                                                <label class="custom-control-label"
                                                    for="{{ $questionIndex }}_{{ $choiceIndex }}">
                                                    {{ $choiceText }}
                                                </label>
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

                        @error('question_answer_error')
                            <div class='alert alert-danger font-weight-bold'>{{ $message }}</div>
                        @enderror

                        <button onclick="return confirm('Yakin akan kumpul Quiz?')" class="btn btn-primary text-end">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
