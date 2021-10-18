@extends('layout.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center my-3">
    <h1 class="h2">Scholars</h1>
	<div>
	  	<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text" id="fx-rate">FX</span>
			</div>
			<input type="number" class="form-control" placeholder="" aria-label="" aria-describedby="fx-rate">
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
			<th scope="col">Name</th>
			<th scope="col">Payout Start</th>
			<th scope="col">Next Payout</th>
			<th scope="col">SLP</th>
			<th scope="col">Days</th>
			<th scope="col" style="width:80px">Team Wgt</th>
			<th scope="col">Avg. SLP</th>
			<th scope="col">Split</th>
			<th scope="col">Manager (SLP)</th>
			<th scope="col">Scholar (SLP)</th>
			<th scope="col">Scholar (USD)</th>
			<th scope="col">Bonus</th>
		</tr>
	</thead>
	<tbody>
		@forelse($accounts as $account)
		<tr class="{{@$account->current_payout->status == 'final' ? 'table-success' : ''}}" data-id="{{@$account->current_payout->id}}">
			<td class="text-center">
				<div class="form-check">
					@if($account->current_payout && $account->current_payout->can_finalize)
				  	<input class="form-check-input" name="finalize[]" type="checkbox" value="1" checked="checked">
				  	@else
				  	<input class="form-check-input" type="checkbox" value="1" checked="checked" disabled="disabled">
				  	@endif
				</div>
			</td>
			<td>
				{{$account->code}}
			</td>
			<td>
				{{$account->name}}
			</td>
			@if($account->current_payout)
			<td>
				{{@$account->current_payout->from_date->format('M-d')}}
			</td>
			<td>
				{{@$account->current_payout->to_date->format('M-d')}}
			</td>
			<td>
				{{$account->scope->sum('slp')}}
			</td>
			<td>
				{{$account->current_payout->diff_days}}
			</td>
			<td>
				<input type="number" value="{{number_format($account->current_payout->team_weight ? $account->current_payout->team_weight : ($account->current_payout->diff_days/14), 2)}}" name="team_weight" {!! !$account->current_payout->can_finalize ? "disabled='disabled'" : "" !!} />
			</td>
			<td>
				{{number_format($account->scope->avg('slp'), 2)}}
			</td>
			<td>
				{{0.01 * $account->current_payout->split}}
			</td>
			<td>
				{{0.01 * $account->current_payout->split * $account->scope->avg('slp')}}
			</td>
			<td>
				{{0.01 * (100 - $account->current_payout->split) * $account->scope->avg('slp')}}
			</td>
			<td data-slp_to_usd="{{0.01 * (100 - $account->current_payout->split) * $account->scope->avg('slp')}}">
				-
			</td>
			<td>
				<input type="number" value="{{$account->current_payout->bonus}}" name="bonus" {!! $account->current_payout->status == 'final' ? "disabled='disabled'" : "" !!} />
			</td>
			@else
			<td colspan="11">No payout</td>
			@endif
		</tr>
		@empty
		<tr>
			<td colspan="13">No accounts added</td>
		</tr>
		@endforelse
  	</tbody>
 </table>

 <br />
 <br />
 <br />

 <div class="sticky-footer w-100">
 	<div class="p-2 bg-white">
	 	<button type="button" class="btn btn-primary" id="finalize-all">Finalize <span>({{ $accounts->where('current_payout.can_finalize')->count()}})</span></button>
	 </div>
 </div>
@endsection


@push('added-modals')

@include('modals.manage-account')

@endpush

@push('added-scripts')

<script>
$( document ).ready(function() {
	let checked = {{ $accounts->where('current_payout.can_finalize')->count()}};
	$("#finalize-all").click(function(){
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
		
	});
});
</script>
@endpush