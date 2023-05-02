<?php

namespace App\Exports;

use App\Models\TransactionStock;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class IngredientExport implements FromView
{
    protected $type, $data, $tranasctionType;
    public function __construct($type, $transactionType, $data)
    {
        $this->type = $type;
        $this->data = $data;
        $this->tranasctionType = $transactionType;
    }

    public function view(): View
    {
        $transactions = TransactionStock::with(['detail', 'detail.ingredient', 'detail.histories', 'detail.ingredient.type']);
        if($this->tranasctionType === 'daily') {
            $transactions = $transactions->whereBetween(DB::raw('DATE(created_at)'), [$this->data['start_date'], $this->data['end_date']])->get();
        } else if($this->tranasctionType === 'monthly') {
            $transactions = $transactions->whereMonth('created_at', $this->data['month'])->get();
        } else {
            $transactions = $transactions->whereYear('created_at', $this->data['year'])->get();
        }
        $data = [];
        foreach ($transactions as $transaction) {
            $txDatas = [
                $transaction->code => []
            ];
            foreach ($transaction->detail as $detail) {
                $txDatas[$transaction->code][] = [
                    'name' => $detail->ingredient->name,
                    'type' => $detail->ingredient->type->name,
                    "{$this->type}" => $detail->qty,
                    'current' => $detail->histories()->orderBy('created_at', 'DESC')->first()
                ];
            }
            $data[] = $txDatas;
        }
        dd($data);
        return \view('report.ingredient', [
            'transactions' => $data
        ]);
    }
}
