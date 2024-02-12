<?php

namespace App\Http\Livewire\Admin\Report\Transaction;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Product;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\OfflineCourse;
use App\Models\PaymentMethod;
use App\Traits\WithDatatable;
use App\Helpers\NumberFormatter;
use App\Models\TransactionDetail;
use App\Models\TransactionStatus;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CollectionExportExcel;
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
        'getTotalHeader',
        'refreshDatatable' => '$refresh',
    ];

    public function onMount()
    {
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->start_date = Carbon::now()->subMonths(1)->format('Y-m-d');
        $this->sortDirection = 'asc';
    }

    public function addFilter($filter)
    {
        foreach ($filter as $key => $value) {
            $this->$key = $value;
        }
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

    public function getColumns(): array
    {
        return [
            [
                'key' => 'created_at',
                'name' => 'Tanggal',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return Carbon::parse($item->created_at)->format('d F Y, H:i');
                }
            ],
            [
                'key' => 'number',
                'name' => 'Nomor Invoice',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item->number;
                }
            ],
            [
                'name' => 'Member',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item->user->name;
                }
            ],
            [
                'name' => 'Product',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    $products = "<ul class='pl-2'>";
                    foreach ($item->transactionDetails as $index => $transactionDetail) {
                        $products .= "<li> $transactionDetail->product_name</li>";
                    }

                    return $products . "</ul>";
                }
            ],
            [
                'name' => 'Detail Product',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    $html = "<ol class='pl-2'>";
                    foreach ($item->transactionDetails as $transactionDetail) {
                        $html .= "<li class='font-weight-bold'>$transactionDetail->product_name</li>";

                        if (empty($transactionDetail->product_remarks_id) && $transactionDetail->courses->count() > 0) {
                            $html .=  "<ul class='pl-4'>";
                            foreach ($transactionDetail->courses as $course) {
                                $html .= "<li class='font-italic'>Online - $course->course_title</li>";
                            }
                            $html .= "</ul>";
                        }
                        if (empty($transactionDetail->product_remarks_id) && $transactionDetail->offlineCourses->count() > 0) {
                            $html .=  "<ul class='pl-4'>";
                            foreach ($transactionDetail->offlineCourses as $course) {
                                $html .= "<li class='font-italic'>Offline - $course->offline_course_title</li>";
                            }
                            $html .= "</ul>";
                        }
                    }
                    $html .= "</ol>";

                    return $html;
                }
            ],
            [
                'name' => 'Total',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return NumberFormatter::format($item->transaction_details_sum_product_price);
                }
            ],
            [
                'name' => 'Metode Pembayaran',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item->payment_method_name . " - " . $item->payment_method_description;
                }
            ],
            [
                'key' => 'transaction_statuses.name',
                'name' => 'Status',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item->status->get_beautify();
                },
            ],
            [
                'name' => 'Data',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item;
                },
            ],
        ];
    }

    public function getQuery(): Builder
    {
        $this->getTotalHeader();

        $query = Transaction::select(
            'transactions.*',
            'transaction_statuses.name as status_name'
        )
            ->leftJoin('transaction_statuses', 'transactions.last_status_id', '=', 'transaction_statuses.id')
            ->with([
                'transactionDetails',
                'transactionDetails.courses',
                'transactionDetails.offlineCourses',
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
                $query->whereHas('transactionDetails', function ($query) {
                    $query->whereIn('product_id', $this->products);
                });
            })
            ->when($this->courses, function ($query) {
                $query->whereHas('transactionDetails.courses', function ($query) {
                    $query->whereIn('course_id', $this->courses);
                });
            })
            ->when($this->offline_courses, function ($query) {
                $query->whereHas('transactionDetails.offlineCourses', function ($query) {
                    $query->whereIn('offline_course_id', $this->offline_courses);
                });
            })
            ->when($this->payment_methods, function ($query) {
                $query->whereIn('payment_method_id', $this->payment_methods);
            })
            ->when($this->search, function ($query) {
                $query->where('transactions.number', 'like', '%' . $this->search . '%');
            })
            ->orderBy('transactions.created_at', 'DESC');

        return $query;
    }

    public function getTotalHeader()
    {
        $total_price = TransactionDetail::
            join('transactions as t', 'transaction_details.transaction_id', '=', 't.id')
            ->leftJoin('transaction_statuses', 't.last_status_id', '=', 'transaction_statuses.id')
            ->whereBetween('t.created_at', [$this->start_date . " 00:00:00", $this->end_date . " 23:59:59"])
            ->when($this->statuses, function ($query) {
                $query->whereHas('transactions.status', function ($query) {
                    $query->whereIn('name', $this->statuses);
                });
            })
            ->when($this->members, function ($query) {
                $query->whereHas('transactions.user', function ($query) {
                    $query->whereIn('id', $this->members);
                });
            })
            ->when($this->products, function ($query) {
                $query->whereIn('product_id', $this->products);
            })
            ->when($this->courses, function ($query) {
                $query->whereHas('courses', function ($query) {
                    $query->whereIn('course_id', $this->courses);
                });
            })
            ->when($this->offline_courses, function ($query) {
                $query->whereHas('offlineCourses', function ($query) {
                    $query->whereIn('offline_course_id', $this->offline_courses);
                });
            })
            ->when($this->payment_methods, function ($query) {
                $query->whereHas('transactions', function ($query) {
                    $query->whereIn('payment_method_id', $this->payment_methods);
                });
            })
            ->when($this->search, function ($query) {
                $query->whereHas('transactions', function ($query) {
                    $query->where('number', 'like', '%' . $this->search . '%');
                });
            })
            ->sum('product_price');
        $total_transaction = Transaction::
            leftJoin('transaction_statuses', 'transactions.last_status_id', '=', 'transaction_statuses.id')
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
                $query->whereHas('transactionDetails', function ($query) {
                    $query->whereIn('product_id', $this->products);
                });
            })
            ->when($this->courses, function ($query) {
                $query->whereHas('transactionDetails.courses', function ($query) {
                    $query->whereIn('course_id', $this->courses);
                });
            })
            ->when($this->offline_courses, function ($query) {
                $query->whereHas('transactionDetails.offlineCourses', function ($query) {
                    $query->whereIn('offline_course_id', $this->offline_courses);
                });
            })
            ->when($this->payment_methods, function ($query) {
                $query->whereIn('payment_method_id', $this->payment_methods);
            })
            ->when($this->search, function ($query) {
                $query->where('transactions.number', 'like', '%' . $this->search . '%');
            })
            ->count();

        $this->emit('consoleLog', "$total_price - $total_transaction");
        $this->emit('setTotalHeader', $total_price, $total_transaction);
    }

    public function getView(): string
    {
        return 'livewire.admin.report.transaction.datatable';
    }
}
