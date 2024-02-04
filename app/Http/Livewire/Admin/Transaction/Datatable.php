<?php

namespace App\Http\Livewire\Admin\Transaction;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Traits\WithDatatable;
use App\Helpers\NumberFormatter;
use App\Models\TransactionStatus;
use Illuminate\Database\Eloquent\Builder;

class Datatable extends Component
{
    use WithDatatable;

    public $end_date;
    public $start_date;
    public $jenis_tanggal;
    public $status;

    protected $listeners = [
        'addFilter',
        'refreshDatatable' => '$refresh',
    ];

    public function onMount()
    {
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->start_date = Carbon::now()->subMonths(1)->format('Y-m-d');
        $this->jenis_tanggal = 'rentang-waktu';
        $this->sortDirection = 'asc';
    }

    // public function cancelTransaction($id)
    // {
    //     $transaction_status = new TransactionStatus();
    //     $transaction_status->transaction_id = $id;
    //     $transaction_status->name = TransactionStatus::STATUS_CANCEL;
    //     $transaction_status->description = TransactionStatus::STATUS_CANCEL;
    //     if ($transaction_status->save()) {
    //         return redirect()->route('admin.transaction.index');
    //     }
    // }
    // public function confirmTransaction($id)
    // {
    //     $transaction_status = new TransactionStatus();
    //     $transaction_status->transaction_id = $id;
    //     $transaction_status->name = TransactionStatus::STATUS_DONE;
    //     $transaction_status->description = TransactionStatus::STATUS_DONE;
    //     if ($transaction_status->save()) {
    //         return redirect()->route('admin.transaction.index');
    //     }
    // }

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
                'key' => 'number',
                'name' => 'Nomor Invoice',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item->number;
                }
            ],
            [
                'key' => 'name',
                'name' => 'Nama',
                'sortable' => false,
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
                'key' => 'created_at',
                'name' => 'Tanggal',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item->created_at;
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
                'name' => 'Aksi',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    // $imageURL = $item->getImage();
                    // $html = "<div class='align-items-center d-inline-flex'>";

                    // if ($item->payment_method_id != PaymentMethod::MIDTRANS_ID) {
                    //     $html .= "<div class='col-auto'>
                    //         <a href='$imageURL' target='_blank' class='btn btn-sm btn-info'><i class='fa fa-eye mr-2'></i> Lihat Bukti Bayar</a>
                    //     </div>";
                    // }
                    // if ($item->status->name != TransactionStatus::STATUS_CANCEL && $item->status->name != TransactionStatus::STATUS_DONE) {
                    //     $html .= "<div class='col-auto'>
                    //         <form wire:submit.prevent=\"confirmTransaction('$item->id')\">"
                    //         . method_field('DELETE') . csrf_field() .
                    //         "<button type='submit' class='btn btn-sm btn-success'
                    //                 onclick=\"return confirm('Konfirmasi Pembayaran ?')\">
                    //                 <i class='fa fa-check mr-2'></i> Konfirmasi
                    //             </button>
                    //         </form>
                    //     </div>";
                    //     $html .= "<div class='col-auto'>
                    //         <form wire:submit.prevent=\"cancelTransaction('$item->id')\">"
                    //         . method_field('DELETE') . csrf_field() .
                    //         "<button type='submit' class='btn btn-sm btn-danger'
                    //                 onclick=\"return confirm('Batalkan Transaksi ?')\">
                    //                 <i class='fa fa-times mr-2'></i> Batalkan
                    //             </button>
                    //         </form>
                    //     </div>";
                    // }
                    // $html .= "</div>";

                    $showUrl = route("admin.transaction.detail", $item->id);
                    $html = "<div class='col-auto'>
                        <a href='$showUrl' class='btn btn-sm btn-info'><i class='fa fa-eye mr-2'></i> Lihat</a>
                    </div>";

                    return $html;
                },
            ],
        ];
    }

    public function getQuery(): Builder
    {

        return Transaction::select(
            'transactions.*',
            'transaction_statuses.name as status_name',
            'users.name',
        )
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->leftJoin('transaction_statuses', 'transactions.last_status_id', '=', 'transaction_statuses.id')
            ->with('transactionDetails', 'status')
            ->withSum('transactionDetails', 'product_price')
            ->when($this->jenis_tanggal == 'rentang-waktu', function ($query) {
                $query->whereBetween('transactions.created_at', [$this->start_date . " 00:00:00", $this->end_date . " 23:59:59"]);
            })
            ->when($this->status, function ($query) {
                $query->where('transaction_statuses.name', $this->status);
            })
            ->when($this->search, function ($query) {
                $query->where('transactions.number', 'LIKE', '%' . $this->search . '%');
            })
            ->orderByRaw("
                CASE 
                    WHEN transaction_statuses.name = '" . TransactionStatus::STATUS_ORDER_CONFIRMATION_PENDING . "' THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('transactions.created_at', 'DESC');
    }

    public function getView(): string
    {
        return 'livewire.admin.transaction.datatable';
    }
}
