<?php

namespace App\Exports;

use App\Models\TransactionStock;
use App\Trait\TransactionTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class IngredientExport implements FromView
{
    use TransactionTrait;

    protected $type, $data, $transactionType;
    public function __construct($type, $transactionType, $data)
    {
        $this->type = $type;
        $this->data = $data;
        $this->transactionType = $transactionType;
    }

    public function view(): View
    {
        dd($this->type);
        $transactionTraint = $this->transactionByType($this->transactionType, TransactionStock::with(['detail', 'detail.ingredient', 'detail.histories', 'detail.ingredient.type'])->where('type', $this->type));
        return \view('report.ingredient', [
            'data' => $transactionTraint['transaction'],
            'type' => $this->type,
            'time' => $transactionTraint['time']
        ]);
    }
}
