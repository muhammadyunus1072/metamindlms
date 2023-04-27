<?php

namespace App\Http\Livewire\Member\OnlineCourse;

use App\Models\CourseMemberLesson;
use Exception;
use App\Models\LessonAnswer;
use App\Models\LessonQuestion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Quiz extends Component
{
    public $lesson_id;
    public $lesson_questions = [];
    public $lesson_answers = [];
    public $lesson_score = null;
    public $selected_answers = [];

    public function mount($lesson_id)
    {
        $authUser = Auth::user();
        $decId = dec($lesson_id);

        // Check Lesson Answer
        $this->lesson_answers = LessonAnswer::where('lesson_question_lesson_id', '=', $decId)
            ->where('user_id', '=', $authUser->id)
            ->get()
            ->toArray();


        if (count($this->lesson_answers) > 0) {
            $this->lesson_score = LessonAnswer::generate_overall_score($this->lesson_answers);

            foreach ($this->lesson_answers as $key => $value) {
                $this->lesson_answers[$key]['lesson_question_choices'] = json_decode($value['lesson_question_choices'], true);
                $this->lesson_answers[$key]['answers'] = json_decode($value['answers'], true);
            }
        } else {
            // Prepare Lesson Question
            $questions = LessonQuestion::where('lesson_id', $decId)->get();
            foreach ($questions as $question) {
                $choices = json_decode($question->choices, true);
                $choicesText = [];
                foreach ($choices as $item) {
                    array_push($choicesText, $item['text']);
                }
                array_push(
                    $this->lesson_questions,
                    [
                        'id' => enc($question->id),
                        'number' => $question->number,
                        'text' => $question->text,
                        'choices' => $choicesText,
                    ]
                );
            };
        }
    }

    public function submitAnswer()
    {
        try {
            DB::beginTransaction();

            $authUser = Auth::user();

            $this->resetErrorBag();

            // Save All Answers
            foreach ($this->lesson_questions as $question) {
                if (!isset($this->selected_answers[$question['id']])) {
                    $this->addError('question_answer_error', 'Pertanyaan Nomor ' . $question['number'] . " Belum Ada Jawaban");
                    DB::rollBack();
                    return;
                }

                LessonAnswer::create([
                    'user_id' => $authUser->id,
                    'lesson_question_id' => dec($question['id']),
                    'answers' => json_encode(array_values($this->selected_answers[$question['id']])),
                ]);
            }

            // Mark Lesson As Done
            $course_member_lesson = CourseMemberLesson::where('lesson_id', '=', dec($this->lesson_id))
                ->where('member_id', '=', $authUser->id)
                ->first();
            $course_member_lesson->is_done = 1;
            $course_member_lesson->is_done_at = Carbon::now();
            $course_member_lesson->save();

            DB::commit();
            return redirect()->route('member.course_member.show_lesson', $this->lesson_id);
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
        }
    }

    public function render()
    {
        if ($this->lesson_score !== null) {
            return view('livewire.member.online-course.result_quiz');
        } else {
            return view('livewire.member.online-course.quiz');
        }
    }
}
