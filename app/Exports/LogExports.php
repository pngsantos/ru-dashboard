<?php

namespace App\Exports;

use App\AccountLog;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class LogExports implements FromView
{
    use Exportable;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }


    public function view(): View
    {
        $logs = AccountLog::with(['account'])->whereDate('date', '<=', $this->end_date)->whereDate('date', '>=', $this->start_date)->orderBy('date', 'desc')->orderBy('date')->get();

        return view('exports.logs', [
            'logs' => $logs
        ]);
    }
}