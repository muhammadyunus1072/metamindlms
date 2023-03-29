<?php

namespace App\Http\Livewire\Admin\OfflineCourse;

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
    public $attachments = [];

    public $active_tab = "registrar";
    public $count_attendance = 0;
    public $count_registrar = 0;

    public $registrar_user_id;
    public $attendance_user_id;


    protected $listeners = [
        'attendance-change' => 'attendanceChange',
        'registrar-change' => 'registrarChange'
    ];

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

        $offlineCourseAttachments = $offlineCourse->attachments()->select('file', 'file_name')->get();
        foreach ($offlineCourseAttachments as $item) {
            array_push($this->attachments, [
                'file' => $item->getFile(),
                'file_name' => $item->file_name,
            ]);
        }

        $this->count_attendance = $offlineCourse->attendances()->count();
        $this->count_registrar = $offlineCourse->registrars()->count();
    }

    public function attendanceChange($refreshDatatable = false)
    {
        $decId = Crypt::decryptString($this->offline_course_id);
        $this->count_attendance = OfflineCourseAttendance::where('offline_course_id', '=', $decId)->count();

        if ($refreshDatatable) {
            $this->emit('refresh-attendance-data');
        }
    }

    public function registrarChange($refreshDatatable = false)
    {
        $decId = Crypt::decryptString($this->offline_course_id);
        $this->count_registrar = OfflineCourseRegistrar::where('offline_course_id', '=', $decId)->count();

        if ($refreshDatatable) {
            $this->emit('refresh-registrar-data');
        }
    }

    public function saveRegistrar()
    {
        $this->resetErrorBag();

        if (empty($this->registrar_user_id)) {
            $this->addError('registrar_user_id', 'Peserta Belum Dipilih');
            return;
        }

        $decOfflineCourseId = Crypt::decryptString($this->offline_course_id);
        $decId = Crypt::decryptString($this->registrar_user_id);

        $checkAttendance = OfflineCourseRegistrar::where('offline_course_id', '=', $decOfflineCourseId)
            ->where('user_id', '=', $decId)
            ->first();

        if (!empty($checkAttendance)) {
            $this->addError('registrar_user_id', 'Peserta Sudah Terdapat Dalam Daftar Kehadiran');
            return;
        }

        OfflineCourseRegistrar::create([
            'offline_course_id' => $decOfflineCourseId,
            'user_id' => $decId
        ]);

        $this->registrarChange(true);
    }

    public function saveAttendance()
    {
        $this->resetErrorBag();

        if (empty($this->attendance_user_id)) {
            $this->addError('attendance_user_id', 'Pendaftar Belum Dipilih');
            return;
        }

        $decOfflineCourseId = Crypt::decryptString($this->offline_course_id);
        $decId = Crypt::decryptString($this->attendance_user_id);

        $registrar = OfflineCourseRegistrar::find($decId);
        if (empty($registrar)) {
            $this->addError('attendance_user_id', 'Pendaftar Tidak Ditemukan');
            return;
        }

        $checkAttendance = OfflineCourseAttendance::where('offline_course_id', '=', $decOfflineCourseId)
            ->where('user_id', '=', $registrar->user_id)
            ->first();

        if (!empty($checkAttendance)) {
            $this->addError('attendance_user_id', 'Peserta Sudah Terdapat Dalam Daftar Kehadiran');
            return;
        }

        OfflineCourseAttendance::create([
            'offline_course_registrar_id' => $registrar->id,
        ]);

        $this->attendanceChange(true);
    }

    public function render()
    {
        return view('livewire.admin.offline-course.show');
    }
}
