@extends('layout.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center my-3">
    <h1 class="h2">Scholars</h1>
	<div class="d-flex">
		<form action="" class="form-inline">
			<input type="date" class="form-control mr-2" name="cutoff" placeholder="" value="{{$cutoff->format('Y-m-d')}}" id="payoutDate" />
		</form>
	  	<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">FX</span>
			</div>
			<input type="number" class="form-control" placeholder="" aria-label="" id="fx-rate" aria-describedby="fx-rate">
		</div>
	</div>
</div>

<table class="table table-striped table-sm spreadsheet header-sticky">
	<thead class="thead-dark">
		<tr>
			<th style="width: 50px;" class="text-center">
				<input name="finalize_all" type="checkbox" value="1" checked="checked" id="select-all" />
			</th>
			<th scope="col">Code</th>
			<th scope="col">Scholar</th>
			<th scope="col">Payout Start</th>
			<th scope="col">Next Payout</th>
			<th scope="col">SLP</th>
			<th scope="col">Days</th>
			<th scope="col" style="width:80px">Team Wgt</th>
			<th scope="col">Avg. SLP</th>
			<th scope="col">Split</th>
			<th scope="col" class="text-right">Manager (SLP)</th>
			<th scope="col" class="text-right">Scholar (SLP)</th>
			<th scope="col" class="text-right">Scholar (USD)</th>
			<th scope="col" class="text-right">Bonus</th>
		</tr>
		<tr>
			<td class="bg-white"></td>
			<td class="bg-white"></td>
			<td class="bg-white"></td>
			<td class="bg-white"></td>
			<td class="bg-white"></td>
			<td class="bg-white">{{$totals['slp']}}</td>
			<td class="bg-white">{{$totals['diff_days']}}</td>
			<td class="bg-white">{{number_format($totals['weight'], 2)}}</td>
			<td class="bg-white">{{number_format($totals['avg_slp'], 2)}}</td>
			<td class="bg-white">{{$totals['slp'] ? number_format($totals['manager_slp'] / $totals['scholar_slp'], 2) : "-"}}</td>
			<td class="bg-white text-right">{{number_format($totals['manager_slp'], 2)}}</td>
			<td class="bg-white text-right">{{number_format($totals['scholar_slp'], 2)}}</td>
			<td class="bg-white text-right" data-slp_to_usd="{{$totals['scholar_slp']}}"></td>
			<td class="bg-white text-right">{{number_format($totals['bonus'], 2)}}</td>
			<td class="bg-white"></td>
		</tr>
	</thead>
	<tbody>
		@if($accounts->count() > 0)
		@foreach($accounts->chunk(100) as $account_chunk)
		@foreach($account_chunk as $account)
		@forelse($account->payouts as $payout)
		<tr class="{{@$payout->status == 'final' ? 'table-success' : ''}}" data-id="{{@$payout->id}}">
			<td class="text-center">
				@if($payout->can_finalize)
			  	<input name="finalize[]" type="checkbox" value="1" checked="checked">
			  	@else
			  	<input type="checkbox" value="1" checked="checked" disabled="disabled">
			  	@endif
			</td>
			<td>
				{{$account->code}}
			</td>
			<td>
				{{$payout->scholar->name}}
			</td>
			<td>
				{{@$payout->from_date->format('M-d')}}

				@if($payout->status != 'final')
				<button class="btn btn-sm btn-light" data-modal="#manage-account-modal" data-route="{{route('payoutEdit', [$payout->id])}}">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
					  <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
					  <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
					</svg>
				</button>
				@endif
			</td>
			<td>
				{{@$payout->to_date->format('M-d')}}

				@if($payout->status != 'final')
				<button class="btn btn-sm btn-light" data-modal="#manage-account-modal" data-route="{{route('payoutEdit', [$payout->id])}}">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
					  <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
					  <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
					</svg>
				</button>
				@endif
			</td>
			<td>
				{{$payout->scope->sum('slp')}}
			</td>
			<td>
				{{$payout->diff_days}}
			</td>
			<td>
				<input type="number" value="{{number_format($payout->weight, 2)}}" name="team_weight" {!! !$payout->can_finalize ? "disabled='disabled'" : "" !!} />
			</td>
			<td>
				{{number_format($payout->scope->avg('slp'), 2)}}
			</td>
			<td>
				{{0.01 * $payout->split}}
			</td>
			@if($payout->status != 'final')
			<td class="text-right">
				{{number_format(0.01 * $payout->split * $payout->scope->sum('slp'), 2)}}
			</td>
			<td class="text-right">
				{{number_format(0.01 * (100 - $payout->split) * $payout->scope->sum('slp'), 2)}}
			</td>
			<td class="text-right" data-slp_to_usd="{{0.01 * (100 - $payout->split) * $payout->scope->sum('slp')}}">
				-
			</td>
			@else
			<td class="text-right">
				{{number_format(0.01 * $payout->split * $payout->slp, 2)}}
			</td>
			<td class="text-right">
				{{number_format(0.01 * (100 - $payout->split) * $payout->slp, 2)}}
			</td>
			<td class="text-right">
				$ {{number_format($payout->usd, 2)}}
			</td>
			@endif
			<td>
				<input class="text-right" type="number" value="{{$payout->bonus}}" name="bonus" {!! $payout->status == 'final' ? "disabled='disabled'" : "" !!} />
			</td>
		</tr>
		@empty
		<tr class="{{@$account->current_payout->status == 'final' ? 'table-success' : ''}}" data-id="{{@$account->current_payout->id}}">
			<td class="text-center">
				@if($account->current_payout && $account->current_payout->can_finalize)
			  	<input name="finalize[]" type="checkbox" value="1" checked="checked">
			  	@else
			  	<input type="checkbox" value="1" checked="checked" disabled="disabled">
			  	@endif
			</td>
			<td>
				{{$account->code}}
			</td>
			<td>
				{{$account->scholar->name}}
			</td>
			<td colspan="11">No payout</td>
		</tr>
		@endforelse
		@endforeach
		@endforeach
		@else
		<tr>
			<td colspan="14">No accounts</td>
		</tr>
		@endif
  	</tbody>
 </table>

 <br />
 <br />
 <br />

 <div class="sticky-footer w-100">
 	<div class="p-2 bg-white">
	 	<button type="button" class="btn btn-primary" id="finalize-all">Finalize <span>({{ $accounts->where('payout.can_finalize')->count()}})</span></button>
	 </div>
 </div>
@endsection


@push('added-modals')

@include('modals.manage-payout')
@include('modals.manage-account')

@endpush

@push('added-scripts')

<script>
$( document ).ready(function() {
	let checked = $("*[name='finalize[]']:checked").length;
	$("#finalize-all span").html("(" + checked + ")");
	
	$("*[name='finalize[]']").click(function(){
		checked = $("*[name='finalize[]']:checked").length;

		$("#finalize-all span").html("(" + checked + ")");
	});

	$("#finalize-all").click(function(){
		if(!$("#fx-rate").val())
		{
			Swal.fire({
	            title: "Invalid FX rate",
	            text: "Please enter a valid FX rate to use",
	            icon: "error",
	            confirmButtonText: "Ok",
	        });

			return false;
		}

		if(checked > 0)
		{
			Swal.fire({
	            title: "Finalize " + checked + " accounts?",
	            text: "You will not be able to edit them after",
	            icon: "warning",
	            confirmButtonText: "Confirm",
	            closeOnConfirm: false,
	            reverseButtons: true,
	            showCancelButton: true
	        }).then((result) => {
                if (result.isConfirmed) {
		        	let completed = 0;

		        	Swal.fire({
	                    title: "Please wait",
	                    text: "Finalizing your payouts...",
	                });
	                Swal.showLoading();

		            if (result.value) {
		                $("input[name='finalize[]']:checked").each(function(){
		                	let $tr = $(this).closest('tr');

		                	let id = $tr.data('id');
		                	let data = $tr.find(":input").serializeArray();
		                	data.push({"name":'id', 'value':id});
		                	data.push({"name":'rate', 'value':$("#fx-rate").val()});

		                	$.ajax({
					            type: 'post',
					            url: "{{route('finalizePayout')}}",
			                    headers: {
			                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			                    },
					            data: data,
					            success: function (response) {
					                console.log(response);
					                completed++;

					                if(completed == checked)
					                {
					                	document.location.reload();
					                }
					            },
					            error: function (data, text, error) {
					                console.log(data);
					            }
					        });
		                });
		            }
	            }
	        });
		}
		else
		{
			Swal.fire({
	            title: "No accounts selected",
	            text: "Please select account payouts to finalize",
	            icon: "error",
	            confirmButtonText: "Ok",
	        });

			return false;
		}
		
	});

	$("#payoutDate").change(function(){
		let $form = $(this).closest('form').submit();
	});

	$.ajax({
		type: 'get',
		url: "https://bloomx.app/rates.json",
		success: function (response) {
            console.log(response);

            if(response.SLP)
            {
            	$("#fx-rate").val(response.SLP.buy);
            }
        }
	});

	$("#fx-rate").change(function(){
		let rate = parseFloat($(this).val());

		$("*[data-slp_to_usd]").each(function(){
			let slp = $(this).data('slp_to_usd');
			$(this).html( "$ " + (slp * rate).toFixed(2) );
		});
	});
});
</script>
@endpush