<?php

namespace App\Http\Livewire\Admin\Lesson;

use App\Models\Lesson;
use App\Models\LessonQuestion;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class EditQuiz extends Component
{
    public $lesson_id;
    public $title;
    public $description;
    public $can_preview;

    public $questions = [];

    protected $rules = [
        'title' => 'required',
    ];

    protected $messages = [
        'title' => 'Judul Harus Diisi',
    ];

    public function mount(Lesson $lesson)
    {
        $this->lesson_id = Crypt::encryptString($lesson->id);
        $this->title = $lesson->title;
        $this->description = $lesson->description;
        $this->can_preview = $lesson->can_preview;

        $this->questions = $lesson->questions()->get()->toArray();
        foreach ($this->questions as $index => $value) {
            $this->questions[$index]['id'] = Crypt::encryptString($value['id']);
            $this->questions[$index]['choices'] = json_decode($value['choices']);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.admin.lesson.edit-quiz');
    }

    public function save()
    {
        $validatedData = $this->validate();
        $lesson = Lesson::find(Crypt::decryptString($this->lesson_id));
        $lesson->title = $this->title;
        $lesson->description = $this->description;
        $lesson->can_preview = $this->can_preview;
        $lesson->save();

        $updatedQuestionIds = [];
        foreach ($this->questions as $question) {
            $questionData = [
                'number' => $question['number'],
                'text' => $question['text'],
                'choices' => json_encode($question['choices']),
            ];

            if (isset($question['id'])) {
                $lessonQuestion = LessonQuestion::find(Crypt::decryptString($question['id']));
            } else {
                $lessonQuestion = new LessonQuestion();
                $lessonQuestion->lesson_id = $lesson->id;
            }

            $lessonQuestion->fill($questionData);
            $lessonQuestion->save();

            array_push($updatedQuestionIds, $lessonQuestion->id);
        }

        // Deleted Questions
        $deletedQuestions = $lesson->questions()->whereNotIn('id', $updatedQuestionIds)->get();
        foreach ($deletedQuestions as $item) {
            $item->delete();
        }
    }

    //-----------------------------
    //------ QUESTION HANDLE ------
    //-----------------------------

    public function updatedQuestions($name, $value)
    {
        usort($this->questions, fn ($a, $b) => $a['number'] > $b['number']);
    }

    public function addQuestion($text = null, $answer_choices = [])
    {
        array_push(
            $this->questions,
            [
                'number' => count($this->questions) + 1,
                'text' => $text,
                'choices' => $answer_choices,
            ]
        );
    }

    public function removeQuestion($questionKey)
    {
        $this->questions = array_filter(
            $this->questions,
            function ($value, $key) use ($questionKey) {
                return $key != $questionKey;
            },
            ARRAY_FILTER_USE_BOTH
        );
    }

    //-----------------------------
    //------- CHOICE HANDLE -------
    //-----------------------------

    public function addChoice($questionKey, $text = null, $isCorrect = false)
    {
        array_push(
            $this->questions[$questionKey]['choices'],
            [
                'text' => $text,
                'is_correct' => $isCorrect,
            ]
        );
    }

    public function removeChoice($questionKey, $choiceKey)
    {
        $this->questions[$questionKey]['choices'] = array_filter(
            $this->questions[$questionKey]['choices'],
            function ($value, $key) use ($choiceKey) {
                return $key != $choiceKey;
            },
            ARRAY_FILTER_USE_BOTH
        );
    }
}
