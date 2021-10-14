<?php

namespace App\Imports;

use App\Account;
use App\AccountLog;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LogsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $account = Account::where('code', $row['code'])->first();

        if($account)
        {
            $date = $this->transformDate($row['date']);
            $dupe = AccountLog::where('account_id', $account->id)->where('date', $date)->first();

            if(!$dupe)
            {
                $log = AccountLog::create([
                    'account_id' => $account->id,
                    'scholar_id' => $account->scholar_id,
                    'date' => $date,
                    'slp' => $row["slp"],
                ]);   
            }

            // dd($log->id);
        }
    
        return $account;
    }

    private function transformDate($value, $format = 'm/d/Y')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}