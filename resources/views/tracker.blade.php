@extends('layout.app')

@section('content')

<div class="pt-3 pb-3 mb-3 border-bottom">
	<div class="row">
		<div class="col-6 mb-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Card title</h5>
					<h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
					<p class="card-text">Some quick example</p>
				</div>
			</div>
		</div>
		<div class="col-3 mb-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Unclaimed SLP</h5>
					<h6 class="card-subtitle mb-2 text-muted">{{$accounts->sum('unclaimed_slp')}}</h6>
					<p class="card-text">-</p>
				</div>
			</div>
		</div>
		<div class="col-3 mb-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Average SLP</h5>
					<h6 class="card-subtitle mb-2 text-muted">-</h6>
					<p class="card-text">-</p>
				</div>
			</div>
		</div>
		<div class="col-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Card title</h5>
					<h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
					<p class="card-text">Some quick example</p>
				</div>
			</div>
		</div>
		<div class="col-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Card title</h5>
					<h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
					<p class="card-text">Some quick example</p>
				</div>
			</div>
		</div>
		<div class="col-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Card title</h5>
					<h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
					<p class="card-text">Some quick example</p>
				</div>
			</div>
		</div>
		<div class="col-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Card title</h5>
					<h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
					<p class="card-text">Some quick example</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
    <h1 class="h2">RU Accounts</h1>
	<div class="btn-toolbar">
	  	<div class="btn-group">
		    <button type="button" class="btn btn-light" data-modal="#manage-account-modal" data-view="modals.partials.add-account-form">Add Account</button>
		    <button type="button" class="btn btn-light" data-modal="#manage-account-modal" data-view="modals.partials.import-accounts-form">Upload Accounts</button>
		    <button type="button" class="btn btn-light" data-modal="#manage-account-modal" data-view="modals.partials.import-logs-form">Upload Account Logs</button>
	  	</div>
	</div>
</div>

<table class="table">
	<thead class="thead-dark">
		<tr>
			<th scope="col">Name</th>
			<th scope="col">Today</th>
			<th scope="col">Yesterday</th>
			<th scope="col">Average</th>
			<th scope="col">MMR</th>
			<th scope="col">Next Claim</th>
			<th scope="col">SLP</th>
			<th scope="col">Scholar</th>
			<th scope="col">Manager</th>
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
		@forelse($accounts as $account)
		<tr>
			<td>
				<div>
					<a href="{{route('accountView', [$account->id])}}" class="font-weight-bold">{{$account->name}}</a>

					@if($account->scholar)
					&middot;
					<a href="{{route('accountView', [$account->id])}}" class="font-weight-bold">{{Str::limit($account->scholar->name, 16)}}</a>
					@endif
				</div>
				<div class="text-muted">
					{{$account->code}} &middot; Started {{$account->date_started->diffForHumans()}}
				</div>
				<div>
					@if($account->tags)
					@foreach($account->tags as $tag)
					<span class="badge badge-secondary text-capitalize">{{$tag}}</span>
					@endforeach
					@endif
				</div>
			</td>
			<td>
				{{@$account->logs->last()->slp}}
			</td>
			<td>
				{{@$account->logs->first()->slp}}
			</td>
			<td>
				{{@$account->logs->pluck('slp')->avg()}}
			</td>
			<td>
				-
			</td>
			<td>
				{{$account->next_claim_date ? $account->next_claim_date->format("M d, Y") : "-"}}
			</td>
			<td>
				{{@$account->unclaimed_slp}}
			</td>
			<td>
				{{0.01 * (100 - $account->split) * $account->unclaimed_slp}} <small class="text-muted">({{(100 - $account->split)}}%)</small>
			</td>
			<td>
				{{0.01 * $account->split * $account->unclaimed_slp}} <small class="text-muted">({{$account->split}}%)</small>
			</td>
			<td class="text-right">
				<a href="" class="btn btn-sm btn-outline-primary" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
					  <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
					</svg>
				</a>
				<button type="button" class="btn btn-sm btn-outline-secondary" data-modal="#manage-account-modal" data-route="{{route('accountEdit', [$account->id])}}">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
					  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
					</svg>
				</button>
				<button type="button" class="btn btn-sm btn-outline-secondary account-delete" data-id="{{$account->id}}">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
					  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
					  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
					</svg>
				</button>
			</td>
		</tr>
		@empty
		<tr>
			<td colspan="10">
				No accounts
			</td>
		</tr>
		@endforelse
  	</tbody>
 </table>

@endsection

@push('added-modals')

@include('modals.manage-account')

@endpush

@push('added-scripts')

<script>
$( document ).ready(function() {
	$(".account-delete").click(function(){
		let account_id = $(this).data('id');
		let $tr = $(this).closest('tr');

		Swal.fire({
            title: "Delete this account?",
            icon: "warning",
            confirmButtonText: "Confirm",
            closeOnConfirm: false,
            reverseButtons: true,
            showCancelButton: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
		            type: 'post',
		            url: "{{route('accountDelete')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
		            data: {
		            	account_id : account_id
		            },
		            success: function (response) {
		                console.log(response);
		                $tr.remove();
		            },
		            error: function (data, text, error) {
		                console.log(data);
		            }
		        });
            }
        });

	});
});
</script>

@endpush