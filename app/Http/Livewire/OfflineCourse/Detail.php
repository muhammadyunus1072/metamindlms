<?php

namespace App\Http\Livewire\OfflineCourse;

use App\Helpers\FileHelper;
use App\Models\OfflineCourse;
use App\Models\OfflineCourseCategory;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Crypt;

class Detail extends Component
{
    use WithFileUploads;

    public $offline_course_id = null;
    public $title;
    public $description;
    public $quota;
    public $date_time_start;
    public $date_time_end;
    public $image = null;
    public $oldImage = null;
    public $categories = [];
    public $oldCategories = [];

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

    public function mount($offlineCourse = null)
    {
        if ($offlineCourse != null) {
            $this->offline_course_id = Crypt::encryptString($offlineCourse->id);
            $this->title = $offlineCourse->title;
            $this->description = $offlineCourse->description;
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
            'quota' => $this->quota,
            'date_time_start' => $this->date_time_start,
            'date_time_end' => $this->date_time_end,
        ];

        if ($this->image != null) {
            $this->validate([
                'image' => 'image|max:2048',
            ]);

            $this->image->store(FileHelper::OFFLINE_COURSE_SAVE_LOCATION, 'public');
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


        // Handle Categories
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

        session()->flash('success', 'Kursus Offline Berhasil ' . ($this->offline_course_id == null ? 'Ditambahkan' : 'Diperbarui'));

        return redirect()->route('admin.offline_course.index');
    }

    public function render()
    {
        return view('livewire.offline-course.detail');
    }
}
