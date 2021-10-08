@extends('layout.app')

@section('content')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center my-3 border-bottom pb-3">
    @if(Auth::check())
    <a class="btn btn-link" href="{{route('tracker')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
        </svg>
    </a>
    @endif
    <h1>{{$account->name}}</h1>

    @if(Auth::check())
    <div class="btn-toolbar">
        <div class="btn-group">
            <button type="button" class="btn btn-light" data-modal="#manage-account-modal" data-route="{{route('accountEdit', [$account->id])}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                </svg>
            </button>
        </div>
    </div>
    @endif
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
            @if(Auth::check() && $account->scholar)
            <div class="card">
                <div class="card-header">
                    Scholar Details
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                          <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                        <span>
                            {{$account->scholar->first_name}} {{$account->scholar->last_name}}
                        </span>
                    </h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                          <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                        </svg>
                        {{$account->scholar->email}}
                    </h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                          <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                          <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                          <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                        </svg>
                        {{$account->scholar->payment_method ? $account->scholar->payment_method : "No payment method indicated"}}
                    </li>
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16">
                          <path d="M8 .95 14.61 4h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.379l.5 2A.5.5 0 0 1 15.5 17H.5a.5.5 0 0 1-.485-.621l.5-2A.5.5 0 0 1 1 14V7H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 4h.89L8 .95zM3.776 4h8.447L8 2.05 3.776 4zM2 7v7h1V7H2zm2 0v7h2.5V7H4zm3.5 0v7h1V7h-1zm2 0v7H12V7H9.5zM13 7v7h1V7h-1zm2-1V5H1v1h14zm-.39 9H1.39l-.25 1h13.72l-.25-1z"/>
                        </svg>
                        {{$account->scholar->payment_account ? $account->scholar->payment_account : "No account indicated"}}
                        @if($account->scholar->payment_account_number)
                        <div class="text-muted">
                            {{$account->scholar->payment_account_number}}
                        </div>
                        @endif
                    </li>
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                          <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                          <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                        </svg>
                        {{$account->scholar->mobile ? $account->scholar->mobile : "No mobile indicated"}}
                    </li>
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                          <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                        </svg>
                        {{$account->scholar->address ? $account->scholar->address : "No address indicated"}}
                    </li>
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-discord" viewBox="0 0 16 16">
                          <path d="M6.552 6.712c-.456 0-.816.4-.816.888s.368.888.816.888c.456 0 .816-.4.816-.888.008-.488-.36-.888-.816-.888zm2.92 0c-.456 0-.816.4-.816.888s.368.888.816.888c.456 0 .816-.4.816-.888s-.36-.888-.816-.888z"/>
                          <path d="M13.36 0H2.64C1.736 0 1 .736 1 1.648v10.816c0 .912.736 1.648 1.64 1.648h9.072l-.424-1.48 1.024.952.968.896L15 16V1.648C15 .736 14.264 0 13.36 0zm-3.088 10.448s-.288-.344-.528-.648c1.048-.296 1.448-.952 1.448-.952-.328.216-.64.368-.92.472-.4.168-.784.28-1.16.344a5.604 5.604 0 0 1-2.072-.008 6.716 6.716 0 0 1-1.176-.344 4.688 4.688 0 0 1-.584-.272c-.024-.016-.048-.024-.072-.04-.016-.008-.024-.016-.032-.024-.144-.08-.224-.136-.224-.136s.384.64 1.4.944c-.24.304-.536.664-.536.664-1.768-.056-2.44-1.216-2.44-1.216 0-2.576 1.152-4.664 1.152-4.664 1.152-.864 2.248-.84 2.248-.84l.08.096c-1.44.416-2.104 1.048-2.104 1.048s.176-.096.472-.232c.856-.376 1.536-.48 1.816-.504.048-.008.088-.016.136-.016a6.521 6.521 0 0 1 4.024.752s-.632-.6-1.992-1.016l.112-.128s1.096-.024 2.248.84c0 0 1.152 2.088 1.152 4.664 0 0-.68 1.16-2.448 1.216z"/>
                        </svg>
                        {{$account->scholar->discord ? $account->scholar->discord : "No discord indicated"}}
                    </li>

                    @if($account->scholar->notes)
                    <li class="list-group-item">
                        <div class="font-weight-bold">Notes</div>
                        {{$account->scholar->notes}}
                    </li>
                    @endif
                </ul>
            </div>
            @endif
        </div>
        <div class="col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <span data-profile="accountId">-</span>
                        <a target="_blank" href="https://marketplace.axieinfinity.com/profile/{{$account->ronin_address}}4/axie">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
                          <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
                        </svg>
                    </a>
                    </h5>
                    <h6 class="card-subtitle mb-2 text-muted" data-profile="name">-</h6>
                    <p class="card-text">{{$account->ronin_address}}</p>
                </div>
            </div>

            @if(Auth::check())
            <div class="mt-3" id="axies">
                
            </div>
            @endif
        </div>
    </div>
</div>

@if(!Auth::check())
<div class="my-3 d-flex" style="gap:15px" id="axies">
    
</div>
@endif

<div class="pt-3 pb-3 mb-3 border-bottom">
    <h2>Daily SLP</h2>
    <canvas class="w-100 mb-3" id="myChart" height="200"></canvas>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Date</th>
                <th scope="col">SLP</th>
                <th scope="col">Scholar Input</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($account->logs as $log)
            <tr>
                <td>
                    {{$log->date->format("M d, Y")}}
                </td>
                <td>
                    {{$log->slp}}
                </td>
                <td>
                    {{$log->slp_scholar}}
                </td>
                <td class="text-right">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-modal="#manage-log-modal" data-route="{{route('logEdit', [$log->id])}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                          <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                        </svg>
                    </button>
                </td>
            </tr>
            @empty
            @endif
        </tbody>
    </table>
</div>


@endsection

@push('added-modals')

@if(Auth::check())
@include('modals.manage-account')
@endif

@include('modals.manage-log')

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
            $("#axies").append('<div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative bg-white"><div class="col-9 p-4 d-flex flex-column position-static"><strong class="d-inline-block mb-2 text-primary">' + item.name + '</strong><h4 class="mb-0">' + item.id + '</h4><div class="mb-1 text-muted">' + item.class + ' &middot; Breed Count ' + item.breedCount + '</div><a href="https://marketplace.axieinfinity.com/axie/' + item.id + '" target="_blank" class="stretched-link">Open in Market</a></div><div class="col-3 d-none d-lg-block"><img src="' + item.image + '" class="img-fluid" alt=""></div></div>');
            // $("#axies tbody").append('<tr> <td> <img src="' + item.image + '" class="img-thumbnail" alt=""> </td> <td> ' + item.id + ' </td> <td> ' + item.class + ' </td> <td> ' + item.breedCount + ' </td> <td> </td> </tr>');
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