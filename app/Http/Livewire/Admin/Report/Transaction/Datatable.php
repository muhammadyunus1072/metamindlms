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
        $members = User::select('name')->whereIn('id', $this->members)->get();
        $statuses = $this->statuses;
        $products = Product::select('name')->whereIn('id', $this->products)->get();
        $courses = Course::select('title')->whereIn('id', $this->courses)->get();
        $offline_courses = OfflineCourse::select('title')->whereIn('id', $this->offline_courses)->get();
        return Excel::download(new CollectionExportExcel(
            [
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'members' => $members,
                'statuses' => $this->statuses,
                'products' => $products,
                'courses' => $courses,
                'offline_courses' => $offline_courses,
                'keyword' => $this->search,
                'title' => 'Data Rekap Transaksi',
            ], 
        $data, 
        'admin.pages.report.transaction.export'
        ), "$fileName.xlsx");
    }

    public function addFilter($filter)
    {
        $this->emit('consoleLog', $filter);
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
                    $products = ""; 
                    foreach ($item->transactionDetails as $index => $transactionDetail) {
                        $is_comma = ($item->transactionDetails->count() - 1 > $index) ? ", " : "";
                        $products .= $transactionDetail->product_name . $is_comma;
                    }

                    return $products;
                }
            ],
            [
                'name' => 'Detail Product',
                'sortable' => false,
                'searchable' => false,
                'render' => function($item){
                    $html = "";
                    foreach ($item->transactionDetails as $transactionDetail) {
                        $html .= "<h6 class='h4 fw-bold'>$transactionDetail->product_name</h6>";
                        $html .= "<h4 class='h5 fw-bold mt-2'>Kursus Online</h4>";
                        $html .= "<ul class='list-group list-group-custom list-group-flush'>";
                        foreach($transactionDetail->product->productCourses as $productCourse){
                            $courseName = $productCourse->course->title;
                            $html .= "<li class='list-group-item'> - $courseName</li>";
                        }
                        $html .= "</ul>";
                        $html .= "<h4 class='card-title mt-2'>Kursus Offline</h4>";
                        $html .= "<ul class='list-group list-group-custom list-group-flush'>";
                        foreach($transactionDetail->product->productOfflineCourses as $productOfflineCourse){
                            $offlineCourseName = $productOfflineCourse->offlineCourse->title;
                            $html .= "<li class='list-group-item'> - $offlineCourseName</li>";
                        }
                        $html .= "</ul>";
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
