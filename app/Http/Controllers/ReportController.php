<?php

namespace App\Http\Controllers;

use App\Exports\IngredientExport;
use App\Exports\SellingExport;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function export() {
        return Excel::download(new SellingExport, 'selling.xlsx');
    }

    public function ingredientExport(Request $request) {
        $request->validate([
            'type' => 'required|string|in:out,in',
            'transaction_type' => 'required|string|in:daily,monthly,yearly',
            'start_date' => 'required_if:transaction_type,daily|date|date_format:Y-m-d',
            'end_date' => 'required_if:transaction_type,daily|date|date_format:Y-m-d',
            'month' => 'required_if:transaction_type,monthly|integer|min:1|max:12',
            'year' => 'required_if:transaction_type,yearly|integer'
        ]);
        $data = [];
        if($request->transaction_type === 'daily') {
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
        } else if($request->transaction_type === 'monthly') {
            $data['month'] = $request->month;
        } else {
            $data['year'] = $request->year;
        }
        return Excel::download(new IngredientExport($request->type, $request->transaction_type, $data), 'stock.xlsx');
    }
}
