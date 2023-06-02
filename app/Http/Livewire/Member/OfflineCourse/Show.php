<?php

namespace App\Http\Livewire\Member\OfflineCourse;

use Livewire\Component;
use App\Models\OfflineCourse;
use App\Models\OfflineCourseAttendance;
use App\Models\OfflineCourseRegistrar;
use Illuminate\Support\Facades\Crypt;

class Show extends Component
{
    public $offline_course_id;
    public $title;
    public $description;
    public $content;
    public $quota;
    public $date_time_start;
    public $date_time_end;
    public $url_online_meet;
    public $image = null;
    public $categories = [];
    public $attachments = [];

    public $links = [];
    public $videos = [];

    public function mount($offlineCourse)
    {
        $this->offline_course_id = Crypt::encryptString($offlineCourse->id);
        $this->title = $offlineCourse->title;
        $this->description = $offlineCourse->description;
        $this->content = $offlineCourse->content;
        $this->quota = $offlineCourse->quota;
        $this->date_time_start = $offlineCourse->date_time_start;
        $this->date_time_end = $offlineCourse->date_time_end;
        $this->url_online_meet = $offlineCourse->url_online_meet;
        $this->image = $offlineCourse->getImage();
        $this->categories = $offlineCourse->categories()->select('category_courses.name')->get()->pluck('name');

        $is_attachment_available = OfflineCourseRegistrar::where('offline_course_id', '=', $offlineCourse->id)
            ->where('user_id', '=', info_user_id())
            ->first();

        if ($is_attachment_available) {
            $offlineCourseAttachments = $offlineCourse->attachments()->select('file', 'file_name', 'title')->get();
            foreach ($offlineCourseAttachments as $item) {
                array_push($this->attachments, [
                    'file' => $item->getFile(),
                    'file_name' => $item->file_name,
                    'title' => $item->title,
                ]);
            }

            $offlineCourseLinks = $offlineCourse->links()->select('url', 'title')->get();
            foreach ($offlineCourseLinks as $item) {
                array_push($this->links, [
                    'url' => $item->url,
                    'title' => $item->title,
                ]);
            }
            $offlineCourseVideos = $offlineCourse->videos()->select('video', 'title')->get();
            foreach ($offlineCourseVideos as $item) {
                array_push($this->videos, [
                    'video' => $item->video,
                    'title' => $item->title,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.member.offline-course.show');
    }
}
