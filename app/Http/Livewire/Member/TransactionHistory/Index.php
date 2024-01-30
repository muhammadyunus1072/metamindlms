<?php

namespace App\Http\Livewire\Member\TransactionHistory;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\PaymentMethod;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $length = 10;

    public $start_date;
    public $end_date;
    public $search;

    public function mount()
    {
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->start_date = Carbon::now()->subMonths(3)->format('Y-m-d');
    }
    
    public function render()
    {
        return view('livewire.member.transaction-history.index', [
            'transactions' => Transaction::select('id', 'number', 'last_status_id')->where('user_id', info_user_id())->with([
                
                'transactionDetails.product' => function($query){
                    return $query->select('id', 'name', 'description');
                },
                'transactionDetails.product.productCourses' => function($query){
                    return $query->select('course_id', 'product_id');
                },
                'transactionDetails.product.productCourses.course' => function($query){
                    return $query->select('id', 'title', 'description');
                },
                'transactionDetails.product.productOfflineCourses' => function($query){
                    return $query->select('offline_course_id', 'product_id');
                },
                'transactionDetails.product.productOfflineCourses.offlineCourse' => function($query){
                    return $query->select('id', 'title', 'description');
                },
                'status',
            ])
            ->whereBetween('transactions.created_at', [$this->start_date . " 00:00:00", $this->end_date . " 23:59:59"])
            ->when($this->search, function ($query) {
                $query->whereHas('transactionDetails.product.productCourses.course', function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('transactionDetails.product.productOfflineCourses.offlineCourse', function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('transactions.created_at', 'DESC')
            ->paginate($this->length),
        ]);
    }

}
