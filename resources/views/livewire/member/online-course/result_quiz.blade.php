<div class="container page__container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-section">
                <div class="page-nav__content">
                    <div class="card text-center">
                        <div class="card-header">
                            <h4 class="card-title">Nilai Quiz</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="d-inline">{{ $lesson_score['score'] }} /</h1>
                            <h4 class="d-inline">{{ $lesson_score['max_score'] }}</h4>
                        </div>
                    </div>

                    <div class="page-separator">
                        <div class="page-separator__text">Soal Quiz</div>
                    </div>

                    @forelse ($lesson_answers as $answerIndex => $answer)
                        <div class="card"
                            style="background-color: {{ $answer['score'] > 0 ? '#c9ffda' : '#ffe3e4' }}">
                            <div class="card-header">
                                <h4 class="card-title">Soal No. {{ $answer['lesson_question_number'] }}</h4>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title mb-3">{{ $answer['lesson_question_text'] }}</h4>
                                @forelse ($answer['lesson_question_choices'] as $choiceIndex => $choice)
                                    <div
                                        class="form-group {{ $choice['is_correct'] ? 'border border-success rounded p-2' : '' }}">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" id="{{ $answerIndex }}_{{ $choiceIndex }}"
                                                class="custom-control-input" value="{{ $choice['text'] }}"
                                                {{ in_array($choice['text'], $answer['answers']) ? 'checked' : '' }}
                                                disabled>
                                            <label for="{{ $answerIndex }}_{{ $choiceIndex }}"
                                                class="custom-control-label">
                                                {{ $choice['text'] }}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <h4>Data belum tersedia</h4>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <h4 class="text-center">Pertanyaan Belum Tersedia</h4>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
