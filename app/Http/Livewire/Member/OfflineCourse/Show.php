<?php

namespace App\Http\Livewire\Member\OfflineCourse;

use Livewire\Component;
use App\Models\OfflineCourse;
use App\Models\OfflineCourseAttendance;
use Illuminate\Support\Facades\Crypt;

class Show extends Component
{
    public $offline_course_id;
    public $title;
    public $description;
    public $quota;
    public $date_time_start;
    public $date_time_end;
    public $image = null;
    public $categories = [];
    public $attachments = [];

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

        $is_attachment_available = OfflineCourseAttendance::where('offline_course_id', '=', $offlineCourse->id)
            ->where('user_id', '=', info_user_id())
            ->first();

        if ($is_attachment_available) {
            $offlineCourseAttachments = $offlineCourse->attachments()->select('file', 'file_name')->get();
            foreach ($offlineCourseAttachments as $item) {
                array_push($this->attachments, [
                    'file' => $item->getFile(),
                    'file_name' => $item->file_name,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.member.offline-course.show');
    }
}
