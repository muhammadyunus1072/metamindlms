<?php

namespace App\Http\Livewire\Admin\OfflineCourse;

use App\Helpers\FileHelper;
use App\Models\OfflineCourse;
use App\Models\OfflineCourseAttachment;
use App\Models\OfflineCourseCategory;
use App\Models\OfflineCourseLink;
use App\Models\OfflineCourseVideo;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;

class Detail extends Component
{
    use WithFileUploads;

    public $offline_course_id = null;
    public $title;
    public $description;
    public $content;
    public $quota;
    public $date_time_start;
    public $date_time_end;

    public $image = null;
    public $oldImage = null;

    public $categories = [];
    public $oldCategories = [];

    public $attachments = [];
    public $deletedAttachments = [];

    public $links = [];
    public $deletedLinks = [];

    public $videos = [];
    public $deletedVideos = [];

    protected $rules = [
        'title' => 'required',
        'description' => 'required',
        'quota' => 'required',
        'date_time_start' => 'required',
        'date_time_end' => 'required',
        'categories' => 'required',
    ];

    protected $messages = [
        'title' => 'Judul Harus Diisi',
        'description' => 'Deskripsi Harus Diisi',
        'quota' => 'Quota Harus Diisi',
        'date_time_start' => 'Tanggal dan Waktu Mulai Harus Diisi',
        'date_time_end' => 'Tanggal dan Waktu Selesai Harus Diisi',
        'image.image' => 'Foto harus berupa file gambar',
        'image.max' => 'Maximum Ukuran File 2 MB',
        'categories' => 'Kategori Harus Diisi',
    ];

    public function render()
    {
        return view('livewire.admin.offline-course.detail');
    }

    public function mount($offlineCourse = null)
    {
        if ($offlineCourse != null) {
            $this->offline_course_id = Crypt::encryptString($offlineCourse->id);
            $this->title = $offlineCourse->title;
            $this->description = $offlineCourse->description;
            $this->content = $offlineCourse->content;
            $this->quota = $offlineCourse->quota;
            $this->date_time_start = $offlineCourse->date_time_start;
            $this->date_time_end = $offlineCourse->date_time_end;

            $this->oldImage = $offlineCourse->getImage();

            $courseCategories = $offlineCourse->categories()->select('category_courses.id', 'category_courses.name')->get();
            foreach ($courseCategories as $item) {
                $encId = Crypt::encryptString($item->id);
                array_push($this->categories, $encId);
                $this->oldCategories[$encId] = $item->name;
            }

            $offlineCourseAttachments = $offlineCourse->attachments()->select('id', 'title', 'file', 'file_name')->get();
            foreach ($offlineCourseAttachments as $item) {
                array_push($this->attachments, [
                    'id' => Crypt::encryptString($item->id),
                    'file' => $item->getFile(),
                    'file_name' => $item->file_name,
                    'title' => $item->title,
                    'is_old' => true,
                ]);
            }

            $offlineCourseLinks = $offlineCourse->links()->select('id', 'title', 'url')->get();
            foreach ($offlineCourseLinks as $item) {
                array_push($this->links, [
                    'id' => Crypt::encryptString($item->id),
                    'url' => $item->url,
                    'title' => $item->title,
                    'is_old' => true,
                ]);
            }

            $offlineCourseVideos = $offlineCourse->videos()->select('id', 'title', 'video')->get();
            foreach ($offlineCourseVideos as $item) {
                array_push($this->videos, [
                    'id' => Crypt::encryptString($item->id),
                    'video' => $item->video,
                    'title' => $item->title,
                    'is_old' => true,
                ]);
            }
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->image != null) {
            $this->validate([
                'image' => 'image|max:2048',
            ]);
        }
    }

    public function save()
    {
            // Validation Steps
            $this->validate();

            if (count($this->categories) == 0) {
                $this->addError('categories', 'Kategori Kursus Harus Diisi');
            }

            $validatedData = [
                'title' => $this->title,
                'description' => $this->description,
                'content' => $this->content,
                'quota' => $this->quota,
                'date_time_start' => $this->date_time_start,
                'date_time_end' => $this->date_time_end,
            ];

            if ($this->image != null) {
                $this->validate([
                    'image' => 'image|max:2048',
                ]);

                $this->image->store(FileHelper::OFFLINE_COURSE_SAVE_LOCATION);
                $validatedData['image'] = $this->image->hashName();
            }

            // Handle Offline Course
            if ($this->offline_course_id != null) {
                $offlineCourse = OfflineCourse::find(Crypt::decryptString($this->offline_course_id));
            } else {
                $offlineCourse = new OfflineCourse();
            }
            $offlineCourse->fill($validatedData);
            $offlineCourse->save();

            $this->handleCategories($offlineCourse);
            $this->handleAttachment($offlineCourse);
            $this->handleVideo($offlineCourse);
            $this->handleLink($offlineCourse);

            session()->flash('success', 'Kursus Offline Berhasil ' . ($this->offline_course_id == null ? 'Ditambahkan' : 'Diperbarui'));

            return redirect()->route('admin.offline_course.index');
    }

    private function handleCategories($offlineCourse)
    {
        $offlineCourseCategories = $offlineCourse->offlineCourseCategories()->get();
        foreach ($offlineCourseCategories as $item) {
            $item->delete();
        }

        foreach ($this->categories as $encId) {
            $decId = Crypt::decryptString($encId);
            OfflineCourseCategory::create([
                'offline_course_id' => $offlineCourse->id,
                'category_course_id' => $decId,
            ]);
        }
    }

    // HANDLE ATTACHMENT
    private function handleAttachment($offlineCourse)
    {
        // Handle Delete Attachment
        foreach ($this->deletedAttachments as $encId) {
            $decId = Crypt::decryptString($encId);
            $offlineCourseAttachment = OfflineCourseAttachment::find($decId);
            if ($offlineCourseAttachment) {
                Storage::delete(FileHelper::OFFLINE_COURSE_SAVE_LOCATION . $offlineCourseAttachment->file);
                $offlineCourseAttachment->delete();
            }
        }

        foreach ($this->attachments as $item) {
            if ($item['is_old']) {
                // Handle Update Attachment
                $attachment = OfflineCourseAttachment::find(Crypt::decryptString($item['id']));
                $attachment->title = $item['title'];

                if ($item['file'] instanceof TemporaryUploadedFile) {
                    $item['file']->store(FileHelper::OFFLINE_COURSE_SAVE_LOCATION, 'public');
                    $attachment->file = $item['file']->hashName();
                    $attachment->file_name = $item['file']->getClientOriginalName();
                }
                $attachment->save();
            } else {
                // Handle Create Attachment
                OfflineCourseAttachment::create([
                    'offline_course_id' => $offlineCourse->id,
                    'file' => $item['file']->hashName(),
                    'file_name' => $item['file']->getClientOriginalName(),
                    'title' => $item['title']
                ]);
            }
        }
    }

    public function addAttachment()
    {
        array_push($this->attachments, [
            'id' => Str::random(30),
            'file' => '',
            'file_name' => '',
            'title' => '',
            'is_old' => false,
        ]);
    }

    public function deleteAttachment($id)
    {
        $deletedItem = null;
        foreach ($this->attachments as $item) {
            if ($item['id'] == $id) {
                $deletedItem = $item;
                if ($deletedItem['is_old']) {
                    array_push($this->deletedAttachments, $item['id']);
                }
                break;
            }
        }

        if ($deletedItem) {
            $this->attachments = array_filter($this->attachments, function ($item) use ($id) {
                return $item['id'] != $id;
            });
        }
    }

    // HANDLE LINK
    private function handleLink($offlineCourse)
    {
        // Handle Delete Link
        foreach ($this->deletedLinks as $encId) {
            $decId = Crypt::decryptString($encId);
            $offlineCourseLink = OfflineCourseLink::find($decId);
            if ($offlineCourseLink) {
                $offlineCourseLink->delete();
            }
        }

        foreach ($this->links as $item) {
            if ($item['is_old']) {
                // Handle Update Link
                $link = OfflineCourseLink::find(Crypt::decryptString($item['id']));
                $link->title = $item['title'];
                $link->url = $item['url'];
                $link->save();
            } else {
                // Handle Create Link
                OfflineCourseLink::create([
                    'offline_course_id' => $offlineCourse->id,
                    'url' => $item['url'],
                    'title' => $item['title']
                ]);
            }
        }
    }

    public function addLink()
    {
        array_push($this->links, [
            'id' => Str::random(30),
            'url' => '',
            'title' => '',
            'is_old' => false,
        ]);
    }

    public function deleteLink($id)
    {
        $deletedItem = null;
        foreach ($this->links as $item) {
            if ($item['id'] == $id) {
                $deletedItem = $item;
                if ($deletedItem['is_old']) {
                    array_push($this->deletedLinks, $item['id']);
                }
                break;
            }
        }

        if ($deletedItem) {
            $this->links = array_filter($this->links, function ($item) use ($id) {
                return $item['id'] != $id;
            });
        }
    }

    // HANDLE VIDEO
    private function handleVideo($offlineCourse)
    {
        // Handle Delete Video
        foreach ($this->deletedVideos as $encId) {
            $decId = Crypt::decryptString($encId);
            $offlineCourseVideo = OfflineCourseVideo::find($decId);
            if ($offlineCourseVideo) {
                $offlineCourseVideo->delete();
            }
        }

        foreach ($this->videos as $item) {
            if ($item['is_old']) {
                // Handle Update Video
                $video = OfflineCourseVideo::find(Crypt::decryptString($item['id']));
                $video->title = $item['title'];
                $video->video = $item['video'];
                $video->save();
            } else {
                // Handle Create Video
                OfflineCourseVideo::create([
                    'offline_course_id' => $offlineCourse->id,
                    'video' => $item['video'],
                    'title' => $item['title']
                ]);
            }
        }
    }

    public function addVideo()
    {
        array_push($this->videos, [
            'id' => Str::random(30),
            'video' => '',
            'title' => '',
            'is_old' => false,
        ]);
    }

    public function deleteVideo($id)
    {
        $deletedItem = null;
        foreach ($this->videos as $item) {
            if ($item['id'] == $id) {
                $deletedItem = $item;
                if ($deletedItem['is_old']) {
                    array_push($this->deletedVideos, $item['id']);
                }
                break;
            }
        }

        if ($deletedItem) {
            $this->videos = array_filter($this->videos, function ($item) use ($id) {
                return $item['id'] != $id;
            });
        }
    }
}
