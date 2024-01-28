<?php

namespace App\Http\Livewire\Admin\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductCourse;
use App\Models\ProductOfflineCourse;
use Illuminate\Support\Facades\Crypt;

class Detail extends Component
{
    use WithFileUploads;

    public $product_id = null;
    public $name;
    public $description;
    public $price;
    public $price_before_discount;

    public $courses = [];
    public $offline_courses = [];
    public $course_olds = [];
    public $offline_course_olds = [];
    public $removed_course_olds = [];
    public $removed_offline_course_olds = [];

    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        'price' => 'required:numeric',
        'price_before_discount' => 'required|numeric',
    ];

    protected $messages = [
        'name' => 'Judul Harus Diisi',
        'description' => 'Deskripsi Harus Diisi',
        'price' => 'Harga Harus Diisi',
        'price_before_discount' => 'Harga Sebelum Diskon Harus Diisi',
    ];

    public function mount($product = null)
    {
        if ($product != null) {
            $this->product_id = Crypt::encryptString($product->id);
            $this->name = $product->name;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->price_before_discount = $product->price_before_discount;

            foreach ($product->productCourses as $productCourse) {
                $this->course_olds[] = [
                    'id' => $productCourse->id,
                    'course_id' => $productCourse->Course->id,
                    'title' => $productCourse->Course->title,
                ];
            }
            foreach ($product->productOfflineCourses as $productOfflineCourse) {
                $this->offline_course_olds[] = [
                    'id' => $productOfflineCourse->id,
                    'course_id' => $productOfflineCourse->offlineCourse->id,
                    'title' => $productOfflineCourse->offlineCourse->title,
                ];
            }
        }
    }

    public function addCourse()
    {
        $this->courses[] = [
            'course_id' => '',
        ];

        $this->emit('reInitSelect2');
    }

    public function setCourse($index, $data, $is_new)
    {
        if ($is_new) {
            $this->courses[$index] = array_merge($this->courses[$index], ['course_id' => $data]);
        } else {
            $this->course_olds[$index] = array_merge($this->course_olds[$index], ['course_id' => $data]);
        }

        $this->emit('reInitSelect2');
    }

    public function removeCourse($index, $is_new, $id = null)
    {
        if ($is_new) {
            array_splice($this->courses, $index, 1);

            $this->courses = $this->courses;
        } else {
            array_splice($this->course_olds, $index, 1);

            $this->course_olds = $this->course_olds;
            array_push($this->removed_course_olds, $id);
        }
        $this->emit('reInitSelect2');
    }

    public function addOfflineCourse()
    {
        $this->offline_courses[] = [
            'course_id' => '',
        ];

        $this->emit('reInitSelect2');
    }

    public function setOfflineCourse($index, $data, $is_new)
    {
        if ($is_new) {
            $this->offline_courses[$index] = array_merge($this->offline_courses[$index], ['course_id' => $data]);
        } else {
            $this->offline_course_olds[$index] = array_merge($this->offline_course_olds[$index], ['course_id' => $data]);
        }

        $this->emit('reInitSelect2');
    }

    public function removeOfflineCourse($index, $is_new, $id = null)
    {
        if ($is_new) {
            array_splice($this->offline_courses, $index, 1);

            $this->offline_courses = $this->offline_courses;
        } else {
            array_splice($this->offline_course_olds, $index, 1);

            $this->offline_course_olds = $this->offline_course_olds;
            array_push($this->removed_offline_course_olds, $id);
        }
        $this->emit('reInitSelect2');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        // Validation Steps
        $this->validate();
        $validatedData = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'price_before_discount' => $this->price_before_discount,
        ];


        // Handle Offline Course
        if ($this->product_id != null) {
            $product = Product::find(Crypt::decryptString($this->product_id));
        } else {
            $product = new Product();
        }
        $product->fill($validatedData);
        $product->save();

        foreach ($this->courses as $course) {
            $product_course = new ProductCourse();
            $product_course->product_id = $product->id;
            $product_course->course_id = $course['course_id'];
            $product_course->save();
        }
        foreach ($this->offline_courses as $offline_course) {
            $product_offline_course = new ProductOfflineCourse();
            $product_offline_course->product_id = $product->id;
            $product_offline_course->offline_course_id = $offline_course['course_id'];
            $product_offline_course->save();
        }

        foreach ($this->removed_course_olds as $removed_course_old) {
            $course = ProductCourse::find($removed_course_old);
            $course->delete();
        }
        foreach ($this->removed_offline_course_olds as $removed_offline_course_old) {
            $offline_course = ProductOfflineCourse::find($removed_offline_course_old);
            $offline_course->delete();
        }

        session()->flash('success', 'Paket Berhasil ' . ($this->product_id == null ? 'Ditambahkan' : 'Diperbarui'));

        return redirect()->route('admin.product.index');
    }

    public function render()
    {
        return view('livewire.admin.product.detail');
    }
}
