<?php

namespace App\Http\Livewire\Member\OnlineCourse;

use Exception;
use App\Models\LessonAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Quiz extends Component
{
    public $selectedAnswers = [];
    protected $results_data;
    protected $lesson_questions;

    public function mount($results_data, $lesson_questions)
    {
        $this->results_data = $results_data;
        $this->lesson_questions = $lesson_questions;
    }

    public function submitAnswer()
    {
        try {
            DB::beginTransaction();

            $input = [
                // 'lesson_question_id' => $this->lesson_questions_id,
                'user_id' => Auth::user()->id,
                'answers' => json_encode($this->selectedAnswers),
            ];

            LessonAnswer::create($input);

            // for ($i = 0; $i < count($this->lesson_questions); $i++) {
            //     foreach ($this->lesson_questions as $value) {
            //         $input = [
            //             'lesson_question_id' => $value['id'],
            //             'user_id' => Auth::user()->id,
            //             'answers' => json_encode($this->selectedAnswers),
            //         ];
            //     }
            //     LessonAnswer::create($input);
            // }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function render()
    {
        return view('livewire.member.online-course.quiz', [
            'results_data' => $this->results_data,
            'lesson_questions' => $this->lesson_questions,
        ]);
    }
}
