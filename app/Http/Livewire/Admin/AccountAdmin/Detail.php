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
    public $password;
    public $retype_password;

    protected $rules = [
        'email' => 'required',
        'name' => 'required',
    ];

    protected $messages = [
        'email' => 'Email Harus Diisi',
        'name' => 'Nama Harus Diisi',
    ];

    public function render()
    {
        return view('livewire.admin.account_admin.detail');
    }

    public function mount()
    {
        if ($this->user_id != null) {
            $user = User::find(Crypt::decryptString($this->user_id));
            $this->email = $user->email;
            $this->name = $user->name;
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

        return redirect()->route('admin.admin_account.index');
    }
}
