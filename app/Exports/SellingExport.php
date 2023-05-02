<?php

namespace App\Exports;

use App\Models\Order;
use App\Trait\TransactionTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class SellingExport implements FromView
{
    use TransactionTrait;

    protected $data, $transactionType;
    public function __construct($transactionType, $data)
    {
        $this->data = $data;
        $this->transactionType = $transactionType;
    }
    public function view(): View
    {
        $transactionTraint = $this->transactionByType($this->transactionType, Order::with(['user']));
        return \view('report.selling', [
            'orders' => $transactionTraint['transaction'],
            'time' => $transactionTraint['time']
        ]);
    }
}
