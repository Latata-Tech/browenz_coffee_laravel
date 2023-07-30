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
        $transactionTraint = $this->transactionByType($this->transactionType, TransactionStock::with(['detail', 'detail.ingredient' => fn($q) => $q->withTrashed(), 'detail.histories', 'detail.ingredient.type' => fn($q) => $q->withTrashed()])->where('type', $this->type));
        return \view('report.ingredient', [
            'data' => $transactionTraint['transaction'],
            'type' => $this->type,
            'time' => $transactionTraint['time']
        ]);
    }
}
