<?php

namespace App\Trait;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

trait TransactionTrait {
    function transactionByType($type, $transactions) {
        $month = [ "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember" ];
        $time = "";
        if($this->transactionType === 'daily') {
            $transactions = $transactions->whereBetween(DB::raw('DATE(created_at)'), [$this->data['start_date'], $this->data['end_date']])->get();
            $time = Carbon::createFromDate($this->data['start_date'])->format('d/m/Y') . ' SAMPAI ' . Carbon::createFromDate($this->data['end_date'])->format('d/m/Y');
        } else if($this->transactionType === 'monthly') {
            $transactions = $transactions->whereMonth('created_at', $this->data['month'])->get();
            $time = 'BULAN ' . strtoupper($month[$this->data['month']-1]) .' '. $this->data['year'];
        } else {
            $transactions = $transactions->whereYear('created_at', $this->data['year'])->get();
            $time = 'TAHUN ' . $this->data['year'];
        }
        return ['transaction' => $transactions, 'time' => $time];
    }
}
