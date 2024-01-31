<?php

namespace App\Http\Livewire\Admin\Report\Transaction;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\User;
use App\Models\Course;
use App\Models\Product;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\OfflineCourse;
use App\Models\PaymentMethod;
use App\Traits\WithDatatable;
use App\Models\ClinicalPathway;
use App\Helpers\NumberFormatter;
use App\Exports\CollectionExport;
use App\Helpers\PermissionHelper;
use App\Models\TransactionStatus;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CollectionExportExcel;
use App\Models\TarifTindakanKontraktor;
use Illuminate\Database\Eloquent\Builder;

class Datatable extends Component
{
    use WithDatatable;

    public $end_date;
    public $start_date;
    public $statuses;
    public $products;
    public $members;
    public $courses;
    public $offline_courses;
    public $payment_methods;

    protected $listeners = [
        'export',
        'addFilter',
        'refreshDatatable' => '$refresh',
    ];

    public function onMount()
    {
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->start_date = Carbon::now()->subMonths(1)->format('Y-m-d');
        $this->sortDirection = 'asc';
    }

    public function export()
    {
        $fileName = 'Data Rekap Transaksi ' . Carbon::parse($this->start_date)->format('Y-m-d') . ' sd ' . Carbon::parse($this->end_date)->format('Y-m-d');

        $data = $this->getProcessedQuery()->get();
        $members = $this->members ? User::select('name')->whereIn('id', $this->members)->get() : [];
        $statuses = $this->statuses ? $this->statuses : [];
        $products = $this->products ? Product::select('name')->whereIn('id', $this->products)->get() : [];
        $courses = $this->courses ? Course::select('title')->whereIn('id', $this->courses)->get() : [];
        $offline_courses = $this->offline_courses ? OfflineCourse::select('title')->whereIn('id', $this->offline_courses)->get() : [];
        $payment_methods = $this->payment_methods ? PaymentMethod::select('name', 'description')->whereIn('id', $this->payment_methods)->get() : [];
        return Excel::download(new CollectionExportExcel(
            [
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'members' => $members,
                'statuses' => $statuses,
                'products' => $products,
                'courses' => $courses,
                'offline_courses' => $offline_courses,
                'payment_methods' => $payment_methods,
                'keyword' => $this->search,
                'title' => 'Data Rekap Transaksi',
            ], 
        $data, 
        'admin.pages.report.transaction.export'
        ), "$fileName.xlsx");
    }

    public function addFilter($filter)
    {
        foreach ($filter as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getColumns(): array
    {
        return [
            [
                'key' => 'created_at',
                'name' => 'Tanggal',
                'sortable' => false,
                'searchable' => false,
                'render' => function($item){
                    return Carbon::parse($item->created_at)->format('d F Y, H:i');
                }
            ],
            [
                'key' => 'number',
                'name' => 'Nomor Invoice',
                'sortable' => false,
                'searchable' => false,
                'render' => function($item){
                    return $item->number;
                }
            ],
            [
                'name' => 'Member',
                'sortable' => false,
                'searchable' => false,
                'render' => function($item){
                    return $item->user->name;
                }
            ],
            [
                'name' => 'Product',
                'sortable' => false,
                'searchable' => false,
                'render' => function($item){
                    $products = "<ul class='list-group list-group-custom list-group-flush'>"; 
                    foreach ($item->transactionDetails as $index => $transactionDetail) {
                        $is_comma = ($item->transactionDetails->count() - 1 > $index) ? ", " : "";
                        $products .= "<li class='list-group-item py-1 my-1'> $transactionDetail->product_name</li>";
                    }

                    return $products ."</ul>";
                }
            ],
            [
                'name' => 'Detail Product',
                'sortable' => false,
                'searchable' => false,
                'render' => function($item){
                    $html = "";
                    foreach ($item->transactionDetails as $transactionDetail) {
                        $html .= "<h6 class='h5 fw-bold py-0 my-0'>$transactionDetail->product_name</h6>";
                        if($transactionDetail->product->productCourses->count() > 0){
                            $html .=  "<h4 class='card-title mt-0'>Kursus Online</h4>
                                <ul class='list-group my-0 py-0 list-group-custom list-group-flush'>";
                            foreach($transactionDetail->product->productCourses as $productCourse){
                                $courseName = $productCourse->course->title;
                                $html .= "<li class='list-group-item py-1 my-1'> - $courseName</li>";
                            }
                            $html .= "</ul>";
                        }
                        if($transactionDetail->product->productOfflineCourses->count() > 0){
                            $html .=  "<h4 class='card-title mt-0'>Kursus Offline</h4>
                            <ul class='list-group my-0 py-0 list-group-custom list-group-flush'>";
                            foreach($transactionDetail->product->productOfflineCourses as $productOfflineCourse){
                                $offlineCourseName = $productOfflineCourse->offlineCourse->title;
                                $html .= "<li class='list-group-item py-1 my-1'> - $offlineCourseName</li>";
                            }
                            $html .= "</ul>";
                        }
                    }
                    return $html;
                }
            ],
            [
                'name' => 'Total',
                'sortable' => false,
                'searchable' => false,
                'render' => function($item){
                    return NumberFormatter::format($item->transaction_details_sum_product_price);
                }
            ],
            [
                'name' => 'Metode Pembayaran',
                'sortable' => false,
                'searchable' => false,
                'render' => function($item){
                    return $item->payment_method_name ." - ". $item->payment_method_description;
                }
            ],
            [
                'key' => 'transaction_statuses.name',
                'name' => 'Status',
                'sortable' => false,
                'searchable' => false,
                'render' => function($item){
                    return $item->status->get_beautify();
                },
            ],
        ];
    }

    public function getQuery(): Builder
    {

        return Transaction::select(
            'transactions.*',
            'transaction_statuses.name as status_name'
        )
            ->leftJoin('transaction_statuses', 'transactions.last_status_id', '=', 'transaction_statuses.id')
            ->with([
                'transactionDetails', 
                'transactionDetails.product', 
                'transactionDetails.product.productCourses', 
                'transactionDetails.product.productCourses.course', 
                'transactionDetails.product.productOfflineCourses', 
                'transactionDetails.product.productOfflineCourses.offlineCourse', 
                'status', 
                'user'
            ])
            ->withSum('transactionDetails', 'product_price')
            ->whereBetween('transactions.created_at', [$this->start_date . " 00:00:00", $this->end_date . " 23:59:59"])
            ->when($this->statuses, function ($query) {
                $query->whereHas('status', function ($query) {
                    $query->whereIn('name', $this->statuses);
                });
            })
            ->when($this->members, function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->whereIn('id', $this->members);
                });
            })
            ->when($this->products, function ($query) {
                $query->whereHas('transactionDetails.product', function ($query) {
                    $query->whereIn('id', $this->products);
                });
            })
            ->when($this->courses, function ($query) {
                $query->whereHas('transactionDetails.product.productCourses.course', function ($query) {
                    $query->whereIn('id', $this->courses);
                });
            })
            ->when($this->offline_courses, function ($query) {
                $query->whereHas('transactionDetails.product.productOfflineCourses.offlineCourse', function ($query) {
                    $query->whereIn('id', $this->offline_courses);
                });
            })
            ->when($this->payment_methods, function ($query) {
                $query->whereIn('payment_method_id', $this->payment_methods);
            })
            ->when($this->search, function ($query) {
                $query->where('transactions.number', 'like', '%'.$this->search.'%');
            })
            ->orderByRaw("
                CASE 
                    WHEN transaction_statuses.name = '". TransactionStatus::STATUS_ORDER_CONFIRMATION_PENDING ."' THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('transactions.created_at', 'DESC');
    }

    public function getView(): string
    {
        return 'livewire.admin.report.transaction.datatable';
    }
}
