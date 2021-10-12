<?php

namespace App\Imports;

use App\Account;
use App\Scholar;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccountsImport implements ToModel, WithHeadingRow
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

        $dupe_account = Account::where('ronin_address', $row['ronin_address'])->first();

        if($dupe_account)
        {
            return $dupe_account;
        }

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
            'created_by' => @Auth::user()->id,
        ]);
        
        return $account;
    }
}