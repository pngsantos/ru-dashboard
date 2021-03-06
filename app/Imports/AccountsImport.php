<?php

namespace App\Imports;

use App\Account;
use App\Scholar;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class AccountsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $dupe_scholar = Scholar::where('email', $row['email'])->first();

        if($dupe_scholar)
        {
            $scholar = $dupe_scholar;

            $scholar->update([
                'first_name' => $row["first_name"],
                'last_name' => $row["last_name"],
                'payment_method' => $row["payment_method"],
                'payment_account' => $row["account_name"],
                'payment_account_number' => $row["account_number"],
                'mobile' => $row["mobile_number"],
                'address' => $row["address"],
                'address2' => @$row["address2"],
                'city' => @$row["city"],
                'province' => @$row["province"],
                'zip' => @$row["zip"],
                'referrer' => $row["referrer"],
                'discord' => $row["discord"]
            ]);
        }
        else
        {
            $scholar = Scholar::create([
                'first_name' => $row["first_name"],
                'last_name' => $row["last_name"],
                'email' => $row["email"],
                'payment_method' => $row["payment_method"],
                'payment_account' => $row["account_name"],
                'payment_account_number' => $row["account_number"],
                'mobile' => $row["mobile_number"],
                'address' => $row["address"],
                'address2' => @$row["address2"],
                'city' => @$row["city"],
                'province' => @$row["province"],
                'zip' => @$row["zip"],
                'referrer' => $row["referrer"],
                'discord' => $row["discord"]
            ]);
        }

        $dupe_account = Account::where('code', $row['acct_code'])->first();

        if($dupe_account)
        {
            $dupe_account->update([
                'name' => $row['acct_codename'],
                'scholar_id' => @$scholar->id,
                'ronin_address' => $row['ronin_address'],
                'tags' => trim($row['type'] != "") ? explode(",", $row['type']) : null,
                'split' => $row['split'],
                'owner' => $row["owner"],
                'notes' => $row["notes"],
                'last_cutoff' => @$row["last_cutoff"],
                'next_payout' => @$row["next_payout"],
                'start_date' => @$row["start_date"],
                'balance' => @$row["starting_balance"]
            ]);

            if(@$row["last_cutoff"] && @$row["next_payout"])
            {
                \App\Payout::where('account_id', $dupe_account->id)->delete();

                $dupe_account->create_new_payout($this->transformDate($row["last_cutoff"])->addDay(), $this->transformDate($row["next_payout"]));
            }

            return $dupe_account;
        }
        else
        {
            $account = Account::create([
                'name' => $row['acct_codename'],
                'code' => $row['acct_code'],
                'scholar_id' => @$scholar->id,
                'user_id' => @Auth::user()->id,
                'ronin_address' => $row['ronin_address'],
                'tags' => trim($row['type'] != "") ? explode(",", $row['type']) : null,
                'split' => $row['split'],
                'owner' => $row["owner"],
                'notes' => $row["notes"],
                'last_cutoff' => @$row["last_cutoff"],
                'next_payout' => @$row["next_payout"],
                'start_date' => @$row["start_date"],
                'balance' => @$row["starting_balance"],
                'created_by' => @Auth::user()->id,
            ]);

            return $account;
        }

        
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