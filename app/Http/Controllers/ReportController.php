<?php

namespace App\Http\Controllers;

use App\Exports\IngredientExport;
use App\Exports\SellingExport;
use App\Http\Requests\ExportIngredientRequest;
use App\Http\Requests\ExportSellingRequest;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index() {
        return view('report.index', [
            'month' => [ "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember" ]
        ]);
    }

    public function staffIncome() {
        $data = Order::with(['user' => fn($q) => $q->withTrashed()])
        ->sum('total')
        ->whereDate('created_at', Carbon::now())
        ->groupBy('user_id')
        ->get();
        @dd($data);
        return view('report.income', [
            'data' => $data
        ]);
    }
    public function export(ExportSellingRequest $request) {
        return Excel::download(new SellingExport($request->transaction_type, $this->time($request)), 'selling.xlsx');
    }

    public function ingredientExport(ExportIngredientRequest $request) {
        return Excel::download(new IngredientExport($request->type, $request->transaction_type, $this->time($request)), 'stock.xlsx');
    }

    private function time($request) {
        $data = [];
        if($request->transaction_type === 'daily') {
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
        } else if($request->transaction_type === 'monthly') {
            $data['month'] = $request->month;
            $data['year'] = $request->year;
        } else {
            $data['year'] = $request->year;
        }
        return $data;
    }
}
