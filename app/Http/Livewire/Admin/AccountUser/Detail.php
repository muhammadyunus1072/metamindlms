<?php

namespace App\Http\Livewire\Admin\OfflineCourse;

use App\Models\OfflineCourse;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class Detail extends Component
{
    use WithFileUploads;

    public $user_id = null;
    public $email;
    public $name;
    public $phone;
    public $birth_place;
    public $birth_date;
    public $gender;
    public $religion;

    public $password;
    public $retype_password;

    protected $rules = [
        'email' => 'required',
        'name' => 'required',
        'phone' => 'required',
        'birth_place' => 'required',
        'birth_date' => 'required',
        'gender' => 'required',
        'religion' => 'required',
    ];

    protected $messages = [
        'email' => 'Email Harus Diisi',
        'name' => 'Nama Harus Diisi',
        'phone' => 'Nomor HP Harus Diisi',
        'birth_place' => 'Tempat Lahir Harus Diisi',
        'birth_date' => 'Tanggal Lahir Harus Diisi',
        'gender' => 'Jenis Kelamin Harus Diisi',
        'religion' => 'Agama Harus Diisi',
    ];

    public function render()
    {
        return view('livewire.admin.account_user.detail');
    }

    public function mount()
    {
        if ($this->user_id != null) {
            $user = User::find(Crypt::decryptString($this->user_id));
            $this->email = $user->email;
            $this->name = $user->name;
            $this->phone = $user->phone;
            $this->birth_place = $user->birth_place;
            $this->birth_date = $user->birth_date;
            $this->gender = $user->gender;
            $this->religion = $user->religion;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        // Validation Steps
        $this->validate();

        if (!empty($this->user_id) || !empty($this->password) || !empty($this->retype_password)) {
            if (empty($this->password)) {
                $this->addError('password', 'Password Harus Diisi');
            }
            if (empty($this->retype_password)) {
                $this->addError('retype_password', 'Ketik Ulang Password Harus Diisi');
            }
            if ($this->retype_password != $this->password) {
                $this->addError('retype_password', 'Ketik Ulang Password Tidak Sama');
            }
        }

        $validatedData = [
            'email' => $this->email,
            'name' => $this->name,
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'religion' => $this->religion,
        ];

        // Handle Offline Course
        if ($this->user_id != null) {
            $user = User::find(Crypt::decryptString($this->user_id));
        } else {
            $user = new OfflineCourse();
        }
        $user->fill($validatedData);
        $user->save();

        session()->flash('success', 'User Berhasil ' . ($this->user_id == null ? 'Ditambahkan' : 'Diperbarui'));

        return redirect()->route('admin.admin_user.index');
    }
}
