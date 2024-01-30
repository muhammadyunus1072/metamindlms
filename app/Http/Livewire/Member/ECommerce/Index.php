<?php

namespace App\Http\Livewire\Member\ECommerce;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Helpers\MidtransPayment;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $length = 1;
    public $filter_search;

    protected $listeners = [
        '',
    ];

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
        return view('livewire.member.e-commerce.index', [
            'products' => Product::with([
                'productCourses',
                'productCourses.course' => function($query){
                    return $query->select('id', 'title', 'description');
                },
                'productOfflineCourses',
                'productOfflineCourses.offlineCourse' => function($query){
                    return $query->select('id', 'title', 'description');
                },
            ])
            ->whereNull('remarks_id')
            ->whereNull('remarks_type')
            ->when($this->filter_search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->filter_search . '%')
                        ->orWhereHas('productCourses.course', function ($query) {
                            $query->where('title', 'like', '%' . $this->filter_search . '%');
                        })
                        ->orWhereHas('productOfflineCourses.offlineCourse', function ($query) {
                            $query->where('title', 'like', '%' . $this->filter_search . '%');
                        });
                });
            })
            ->paginate($this->length),
        ]);
    }
}
