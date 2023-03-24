<?php

namespace App\Http\Livewire\OfflineCourse;

use App\Models\OfflineCourseRegistrar;
use App\Models\OfflineCourseAttendance;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Crypt;

class Show extends Component
{
    use WithFileUploads;

    public $offline_course_id;
    public $title;
    public $description;
    public $quota;
    public $date_time_start;
    public $date_time_end;
    public $image = null;
    public $categories = [];
    public $count_attendance = 0;
    public $count_registrar = 0;

    protected $listeners = ['attendanceChange', 'registrarChange'];

    public function mount($offlineCourse)
    {
        $this->offline_course_id = Crypt::encryptString($offlineCourse->id);
        $this->title = $offlineCourse->title;
        $this->description = $offlineCourse->description;
        $this->quota = $offlineCourse->quota;
        $this->date_time_start = $offlineCourse->date_time_start;
        $this->date_time_end = $offlineCourse->date_time_end;
        $this->image = $offlineCourse->getImage();
        $this->categories = $offlineCourse->categories()->select('category_courses.name')->get()->pluck('name');
        $this->count_attendance = $offlineCourse->attendances()->count();
        $this->count_registrar = $offlineCourse->registrars()->count();
    }

    public function attendanceChange()
    {
        $decId = Crypt::decryptString($this->offline_course_id);
        $this->count_attendance = OfflineCourseAttendance::where('offline_course_id', '=', $decId)->count();
    }

    public function registrarChange()
    {
        $decId = Crypt::decryptString($this->offline_course_id);
        $this->count_registrar = OfflineCourseRegistrar::where('offline_course_id', '=', $decId)->count();
    }

    public function render()
    {
        return view('livewire.offline-course.show');
    }
}
