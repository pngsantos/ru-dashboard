<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\User;
use App\Account;
use App\AccountLog;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Str;

class DashboardController extends Controller
{
    //
    public function index() 
    {   

        return view('dashboard');
    }

    public function tracker() 
    {   
        $accounts = Account::with(['logs'])->get();

        foreach($accounts as $account)
        {
            // dd($account->logs->take(-2)->first());
            // dd($account->logs->pluck('slp')->avg());
        }

        return view('tracker')
            ->with('accounts', $accounts);
    }

    public function test()
    {
        $response = Http::retry(5, 100)->get('https://game-api.skymavis.com/game-api/clients/0xc352a18bf290c38c5d7d3b530802929f6658ab6d/items/1');

        dd($response->object());
    }

    public function seed()
    {
        AccountLog::truncate();

        $accounts = [
            "0x29ac57f8e1806840d5b3892dc8c409bd73ea00e4" => array (
              'daily' => 
              array (
                0 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1838,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1630769514,
                  ),
                  'date' => '2021-09-16',
                ),
                1 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1973,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1630769514,
                  ),
                  'date' => '2021-09-17',
                ),
                2 => 
                array (
                  'slp' => 
                  array (
                    'total' => 0,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-18',
                ),
                3 => 
                array (
                  'slp' => 
                  array (
                    'total' => 138,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-19',
                ),
                4 => 
                array (
                  'slp' => 
                  array (
                    'total' => 273,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-20',
                ),
                5 => 
                array (
                  'slp' => 
                  array (
                    'total' => 369,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-21',
                ),
                6 => 
                array (
                  'slp' => 
                  array (
                    'total' => 471,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-22',
                ),
                7 => 
                array (
                  'slp' => 
                  array (
                    'total' => 569,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-23',
                ),
                8 => 
                array (
                  'slp' => 
                  array (
                    'total' => 700,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-24',
                ),
                9 => 
                array (
                  'slp' => 
                  array (
                    'total' => 841,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-25',
                ),
                10 => 
                array (
                  'slp' => 
                  array (
                    'total' => 991,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-26',
                ),
                11 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1114,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-27',
                ),
                12 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1228,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-28',
                ),
                13 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1366,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-29',
                ),
                14 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1510,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-09-30',
                ),
                15 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1657,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-10-01',
                ),
                16 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1786,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989590,
                  ),
                  'date' => '2021-10-02',
                ),
                17 => 
                array (
                  'slp' => 
                  array (
                    'total' => 135,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1633223604,
                  ),
                  'date' => '2021-10-03',
                ),
              ),
            ),
            "0x56320ef1e452874574fa16e97508423a34a16fab" => array (
              'daily' => 
              array (
                0 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2317,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1630766761,
                  ),
                  'date' => '2021-09-16',
                ),
                1 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2515,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1630766761,
                  ),
                  'date' => '2021-09-17',
                ),
                2 => 
                array (
                  'slp' => 
                  array (
                    'total' => 174,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-18',
                ),
                3 => 
                array (
                  'slp' => 
                  array (
                    'total' => 324,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-19',
                ),
                4 => 
                array (
                  'slp' => 
                  array (
                    'total' => 486,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-20',
                ),
                5 => 
                array (
                  'slp' => 
                  array (
                    'total' => 633,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-21',
                ),
                6 => 
                array (
                  'slp' => 
                  array (
                    'total' => 793,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-22',
                ),
                7 => 
                array (
                  'slp' => 
                  array (
                    'total' => 988,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-23',
                ),
                8 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1175,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-24',
                ),
                9 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1382,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-25',
                ),
                10 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1565,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-26',
                ),
                11 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1706,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-27',
                ),
                12 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1884,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-28',
                ),
                13 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2049,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-29',
                ),
                14 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2247,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-30',
                ),
                15 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2424,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-10-01',
                ),
                16 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2580,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-10-02',
                ),
                17 => 
                array (
                  'slp' => 
                  array (
                    'total' => 147,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1633223585,
                  ),
                  'date' => '2021-10-03',
                ),
              ),
            ),
            "0x56320ef1e452874574fa16e97508423a34a16fab" => array (
              'daily' => 
              array (
                0 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2317,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1630766761,
                  ),
                  'date' => '2021-09-16',
                ),
                1 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2515,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1630766761,
                  ),
                  'date' => '2021-09-17',
                ),
                2 => 
                array (
                  'slp' => 
                  array (
                    'total' => 174,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-18',
                ),
                3 => 
                array (
                  'slp' => 
                  array (
                    'total' => 324,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-19',
                ),
                4 => 
                array (
                  'slp' => 
                  array (
                    'total' => 486,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-20',
                ),
                5 => 
                array (
                  'slp' => 
                  array (
                    'total' => 633,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-21',
                ),
                6 => 
                array (
                  'slp' => 
                  array (
                    'total' => 793,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-22',
                ),
                7 => 
                array (
                  'slp' => 
                  array (
                    'total' => 988,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-23',
                ),
                8 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1175,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-24',
                ),
                9 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1382,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-25',
                ),
                10 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1565,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-26',
                ),
                11 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1706,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-27',
                ),
                12 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1884,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-28',
                ),
                13 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2049,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-29',
                ),
                14 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2247,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-09-30',
                ),
                15 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2424,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-10-01',
                ),
                16 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2580,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989572,
                  ),
                  'date' => '2021-10-02',
                ),
                17 => 
                array (
                  'slp' => 
                  array (
                    'total' => 147,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1633223585,
                  ),
                  'date' => '2021-10-03',
                ),
              ),
            ),
            "0x4e297b27ffd1efcb2c870786a37c3888330eacb6" => array (
              'daily' => 
              array (
                0 => 
                array (
                  'slp' => 
                  array (
                    'total' => 3085,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1630766762,
                  ),
                  'date' => '2021-09-16',
                ),
                1 => 
                array (
                  'slp' => 
                  array (
                    'total' => 3322,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1630766762,
                  ),
                  'date' => '2021-09-17',
                ),
                2 => 
                array (
                  'slp' => 
                  array (
                    'total' => 0,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-18',
                ),
                3 => 
                array (
                  'slp' => 
                  array (
                    'total' => 165,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-19',
                ),
                4 => 
                array (
                  'slp' => 
                  array (
                    'total' => 315,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-20',
                ),
                5 => 
                array (
                  'slp' => 
                  array (
                    'total' => 543,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-21',
                ),
                6 => 
                array (
                  'slp' => 
                  array (
                    'total' => 750,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-22',
                ),
                7 => 
                array (
                  'slp' => 
                  array (
                    'total' => 915,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-23',
                ),
                8 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1122,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-24',
                ),
                9 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1317,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-25',
                ),
                10 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1518,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-26',
                ),
                11 => 
                array (
                  'slp' => 
                  array (
                    'total' => 1737,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-27',
                ),
                12 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2160,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-28',
                ),
                13 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2235,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-29',
                ),
                14 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2474,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-09-30',
                ),
                15 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2702,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-10-01',
                ),
                16 => 
                array (
                  'slp' => 
                  array (
                    'total' => 2901,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1631989574,
                  ),
                  'date' => '2021-10-02',
                ),
                17 => 
                array (
                  'slp' => 
                  array (
                    'total' => 105,
                    'claimableTotal' => 0,
                    'lastClaimedItemAt' => 1633223586,
                  ),
                  'date' => '2021-10-03',
                ),
              ),
            )
        ];

        foreach($accounts as $account => $logs)
        {
            $ronin_address = Str::replaceFirst("0x", "ronin:", $account);

            $acct = Account::where("ronin_address", $ronin_address)->first();

            $prev = 0;

            // dd($logs);

            foreach($logs['daily'] as $log)
            {
                $date = Carbon::parse($log["date"]);
                $last_claimed = Carbon::parse($log['slp']["lastClaimedItemAt"]);

                if($prev == 0 || ($log['slp']['total'] - $prev) <= 0)
                {
                    $slp = $log['slp']['total'];
                }
                else
                {
                    $slp = $log['slp']['total'] - $prev;
                }

                $prev = $slp;

                AccountLog::create( [
                    'account_id' => $acct->id,
                    'scholar_id' => $acct->scholar_id,
                    'date' => $date,
                    'slp' => $slp,
                    'unclaimed_slp' => $log['slp']['total'],
                    'slp_scholar' => 0,
                ]);
            }

            $acct->update(['unclaimed_slp' => $log['slp']['total'], 'next_claim_date' => $last_claimed->addDays(7)]);
        }
    }
}