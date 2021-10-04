@extends('layout.app')

@section('content')
      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
@endsection

@push('added-scripts')
<script>
$( document ).ready(function() {
	var settings = {
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

	$.ajax(settings).done(function (response) {
	  console.log(response);
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
        borderWidth: 4,
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
      legend: {
        display: false
      }
    }
  })
});
</script>


@endpush