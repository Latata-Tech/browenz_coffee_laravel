<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SellingExport implements FromView
{

    public function view(): View
    {
        return \view('report.selling', [
            'orders' => Order::with('user')->get()
        ]);
    }
}
