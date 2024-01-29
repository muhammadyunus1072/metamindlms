<?php

namespace App\Http\Livewire\Member\OfflineCourse;

use App\Models\Cart;
use App\Models\User;
use Livewire\Component;
use App\Models\OfflineCourse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\OfflineCourseRegistrar;
use App\Models\OfflineCourseAttendance;

class Show extends Component
{
    public $offline_course_id;
    public $title;
    public $description;
    public $content;
    public $quota;
    public $price;
    public $price_before_discount;
    public $date_time_start;
    public $date_time_end;
    public $url_online_meet;
    public $image = null;
    public $categories = [];
    public $attachments = [];

    public $product;

    public $links = [];
    public $videos = [];

    public function mount($offlineCourse)
    {
        $this->product = $offlineCourse->product;
        $this->offline_course_id = Crypt::encryptString($offlineCourse->id);
        $this->title = $offlineCourse->title;
        $this->description = $offlineCourse->description;
        $this->content = $offlineCourse->content;
        $this->quota = $offlineCourse->quota;
        $this->price = $offlineCourse->price;
        $this->price_before_discount = $offlineCourse->price_before_discount;
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

    public function store($product_id, $is_buy_now)
    {
        try {
            DB::beginTransaction();

            $data = array();
            $data['st'] = 'e';

            $member = User::where('role', User::MEMBER)->where('id', info_user_id())->first();
            if (!$member) {
                $this->emit('onFailSweetAlert', "Data Member tidak ditemukan.");
                return;
            }

            if (!Cart::is_product_in_cart($product_id)) {
                $insert_data = new Cart();
                $insert_data->product_id = $product_id;
                $insert_data->user_id = $member->id;
                if (!$insert_data->save()) {
                    DB::rollBack();
                    $this->emit('onSuccessSweetAlert', "Data Kursus gagal masuk keranjang.");
                }

                DB::commit();
            }

            $this->emit('onSuccessSweetAlert', "Kursus berhasil masuk keranjang anda.");
            $this->emit('refreshNotification');
            if ($is_buy_now) {
                return redirect()->route('member.cart.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('onFailSweetAlert', "Kursus gagal masuk keranjang.");
        }
    }

    public function render()
    {
        return view('livewire.member.offline-course.show');
    }
}
