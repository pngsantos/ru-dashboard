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
				@if($payout->status != 'final')
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
				<input type="date" name="from_date" value="{{@$payout->from_date->format('Y-m-d')}}" />
			</td>
			<td>
				<input type="date" name="to_date" value="{{@$payout->to_date->format('Y-m-d')}}" />
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

	$("*[name='from_date'], *[name='to_date'], *[name='bonus']").change(function(){
		let $tr = $(this).closest('tr');

    	let id = $tr.data('id');
    	let data = $tr.find(":input").serializeArray();
    	data.push({"name":'id', 'value':id});

    	$.ajax({
            type: 'post',
            url: "{{route('updatePayout')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (response) {
                console.log(response);
            },
            error: function (data, text, error) {
                console.log(data);
            }
        });
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
		url: "https://api.coingecko.com/api/v3/coins/smooth-love-potion",
		success: function (response) {
            console.log(response);

            if(response.market_data.current_price.usd)
            {
            	$("#fx-rate").val(response.market_data.current_price.usd);

            	updateUSD(parseFloat(response.market_data.current_price.usd));
            }
        }
	});

	$("#fx-rate").change(function(){
		let rate = parseFloat($(this).val());

		updateUSD(rate);
	});
});

function updateUSD(rate)
{
	$("*[data-slp_to_usd]").each(function(){
		let slp = $(this).data('slp_to_usd');
		$(this).html( "$ " + (slp * rate).toFixed(2) );
	});
}
</script>
@endpush