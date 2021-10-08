<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Account;
use App\Axie;
use Illuminate\Support\Facades\Http;


use Carbon\Carbon;

class AxieUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AxieUpdates:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull Axies from GraphQL';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now();
        $accounts = Account::whereNotNull('ronin_address')->get();

        foreach($accounts as $account)
        {
            $ronin_address = str_replace("ronin:", "0x", $account->ronin_address);

            $response = Http::post('https://axieinfinity.com/graphql-server-v2/graphql', [
                'query' => "query GetAxieBriefList(\$auctionType: AuctionType, \$criteria: AxieSearchCriteria, \$from: Int, \$sort: SortBy, \$size: Int, \$owner: String) {\r\n    axies(auctionType: \$auctionType, criteria: \$criteria, from: \$from, sort: \$sort, size: \$size, owner: \$owner) {\r\n        total\r\n        results {\r\n        ...AxieBrief\r\n        __typename\r\n        }\r\n        __typename\r\n    }\r\n  }\r\n\r\nfragment AxieBrief on Axie {\r\n  id\r\n  name\r\n  stage\r\n  class\r\n  breedCount\r\n  image\r\n  title\r\n  battleInfo {\r\n    banned\r\n    __typename\r\n  }\r\n  auction {\r\n    currentPrice\r\n    currentPriceUSD\r\n    __typename\r\n  }\r\n  parts {\r\n    id\r\n    name\r\n    class\r\n    type\r\n    specialGenes\r\n    __typename\r\n  }\r\n  __typename\r\n  }\r\n",
                'variables' => '{"from":0,"owner":"'.$ronin_address.'","size":24,"sort":"IdDesc"}'
            ]);

            $data = $response->object();

            // dd($data->data);

            foreach($data->data->axies->results as $axie)
            {
                $dupe = Axie::where('axie_id', $axie->id)->first();

                if($dupe)
                {
                    $dupe->update([
                        'stage' => $axie->stage,
                        'name' => $axie->name,
                        'breed' => $axie->breedCount,
                        'ronin_address' => $ronin_address,
                        'class' => $axie->class,
                        'image' => $axie->image,
                        'parts' => $axie->parts
                    ]);
                    echo "Axie updated \n";

                }
                else
                {
                    Axie::create([
                        'axie_id' => $axie->id,
                        'name' => $axie->name,
                        'stage' => $axie->stage,
                        'breed' => $axie->breedCount,
                        'ronin_address' => $ronin_address,
                        'class' => $axie->class,
                        'image' => $axie->image,
                        'parts' => $axie->parts
                    ]);
                    echo "Axie created \n";
                }
            }
        }

        return 0;
    }
}
