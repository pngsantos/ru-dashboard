@extends('layout.app')

@section('content')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center my-3 border-bottom pb-3">
    <a class="btn btn-link" href="{{route('tracker')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
        </svg>
    </a>
    <h1>{{$account->name}}</h1>
    <div class="btn-toolbar">
        <div class="btn-group">
            <button type="button" class="btn btn-light" data-modal="#manage-account-modal" data-route="{{route('accountEdit', [$account->id])}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<div class="pt-3 pb-3 mb-3 border-bottom">
    <div class="row">
        <div class="col-6">
            <div class="card mb-3">
                <div class="card-header">
                    Account Details
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{$account->name}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{$account->code}}</h6>
                    <p class="card-text">{{$account->notes}}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Scholar Profile
                </div>
                <div class="card-body">
                    <h5 class="card-title" data-profile="accountId">-</h5>
                    <h6 class="card-subtitle mb-2 text-muted" data-profile="name">-</h6>
                    <p class="card-text">{{$account->ronin_address}}</p>
                </div>
            </div>
        </div>
        @if($account->scholar)
        <div class="col-6 mb-3">
            <div class="card">
                <div class="card-header">
                    Scholar Details
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{$account->scholar->first_name}} {{$account->scholar->last_name}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{$account->scholar->email}}</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{$account->scholar->payment_method}}</li>
                    <li class="list-group-item">{{$account->scholar->payment_account}}</li>
                    <li class="list-group-item">{{$account->scholar->payment_account_number}}</li>
                    <li class="list-group-item">{{$account->scholar->mobile}}</li>
                    <li class="list-group-item">{{$account->scholar->address}}</li>
                    <li class="list-group-item">{{$account->scholar->discord}}</li>
                    <li class="list-group-item">{{$account->scholar->notes}}</li>
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="pt-3 pb-3 mb-3 border-bottom">
    <div class="row">
        <div class="col-6">
            <canvas class="w-100" id="myChart" height="200"></canvas>
        </div>
        <div class="col-6">
            <table class="table" id="axies">
                <thead class="thead-dark">
                    <tr>
                        <th style="width:80px" scope="col"></th>
                        <th scope="col">Axie</th>
                        <th scope="col">Class</th>
                        <th scope="col">Breed</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@push('added-modals')

@include('modals.manage-account')

@endpush

@push('added-scripts')
<script>
$( document ).ready(function() {
	var profile_variables = {
        "url": "https://axieinfinity.com/graphql-server-v2/graphql",
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Content-Type": "application/json"
        },
        "data": JSON.stringify({
            query: "query GetProfileByRoninAddress($roninAddress: String!) {\r\n  publicProfileWithRoninAddress(roninAddress: $roninAddress) {\r\n    ...Profile\r\n    __typename\r\n  }\r\n}\r\n\r\nfragment Profile on PublicProfile {\r\n  accountId\r\n  name\r\n  addresses {\r\n    ...Addresses\r\n    __typename\r\n  }\r\n  __typename\r\n}\r\n\r\nfragment Addresses on NetAddresses {\r\n  ethereum\r\n  tomo\r\n  loom\r\n  ronin\r\n  __typename\r\n}",
            variables: {"roninAddress":"0x4e297b27ffd1efcb2c870786a37c3888330eacb6"}
        })
	};

	$.ajax(profile_variables).done(function (response) {
        for (var key in response.data.publicProfileWithRoninAddress) {
            if (! response.data.publicProfileWithRoninAddress.hasOwnProperty(key)) continue;
            $("*[data-profile='" + key + "']").html(response.data.publicProfileWithRoninAddress[key]);
        }
	  console.log(response);
	});

    var inventory_variables = {
        "url": "https://axieinfinity.com/graphql-server-v2/graphql",
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Content-Type": "application/json"
        },
        "data": JSON.stringify({
            query: "query GetAxieBriefList($auctionType: AuctionType, $criteria: AxieSearchCriteria, $from: Int, $sort: SortBy, $size: Int, $owner: String) {\r\n    axies(auctionType: $auctionType, criteria: $criteria, from: $from, sort: $sort, size: $size, owner: $owner) {\r\n        total\r\n        results {\r\n        ...AxieBrief\r\n        __typename\r\n        }\r\n        __typename\r\n    }\r\n  }\r\n\r\nfragment AxieBrief on Axie {\r\n  id\r\n  name\r\n  stage\r\n  class\r\n  breedCount\r\n  image\r\n  title\r\n  battleInfo {\r\n    banned\r\n    __typename\r\n  }\r\n  auction {\r\n    currentPrice\r\n    currentPriceUSD\r\n    __typename\r\n  }\r\n  parts {\r\n    id\r\n    name\r\n    class\r\n    type\r\n    specialGenes\r\n    __typename\r\n  }\r\n  __typename\r\n  }\r\n",
            variables: {"from":0,"owner":"0xc352a18bf290c38c5d7d3b530802929f6658ab6d","size":24,"sort":"IdDesc"}
        })
    };

    // $("#axies tbody").html("");
    $.ajax(inventory_variables).done(function (response) {
        response.data.axies.results.forEach(function(item){
            console.log(item);
            $("#axies tbody").append('<tr> <td> <img src="' + item.image + '" class="img-thumbnail" alt=""> </td> <td> ' + item.name + ' </td> <td> ' + item.class + ' </td> <td> ' + item.breedCount + ' </td> <td> </td> </tr>');
        });
    });


    // Graphs
    var ctx = document.getElementById('myChart')
    // eslint-disable-next-line no-unused-vars
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                @foreach($account->logs as $log)
                '{{$log->date->format("Y-m-d")}}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($account->logs as $log)
                    '{{$log->slp}}',
                    @endforeach
                ],
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                pointBackgroundColor: '#007bff'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            },
            plugins: {
                legend: false,
                title: {
                    display: false,
                }
            }
        },
    });
});
</script>


@endpush