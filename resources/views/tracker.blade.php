@extends('layout.app')

@section('content')

<div class="pt-3 pb-3 mb-3 border-bottom">
	<div class="row">
		<div class="col-6">
			<div class="card mb-3">
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
					<h5 class="card-title">Card title</h5>
					<h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
					<p class="card-text">Some quick example</p>
				</div>
			</div>
		</div>
		<div class="col-3 mb-3">
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
		    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#create-account-modal">Add Account</button>
		    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#import-accounts-modal">Upload Excel</button>
	  	</div>
	</div>
</div>

<table class="table">
	<thead class="thead-dark">
		<tr>
			<th scope="col" style="width: 40px;"></th>
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
				<button class="btn btn-link">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
					  <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
					</svg>
				</button>
			</td>
			<td>
				<div>
					<a href="{{route('accountView', [$account->id])}}" class="font-weight-bold">{{$account->name}}</a>
					@if($account->tags)
					@foreach($account->tags as $tag)
					<span class="badge badge-secondary text-capitalize">{{$tag}}</span>
					@endforeach
					@endif
					
				</div>
				<div class="text-muted">
					{{$account->code}}
				</div>
			</td>
			<td>
				{{@$account->logs->last()->slp}}
			</td>
			<td>
				{{@$account->logs->take(-2)->first()->slp}}
			</td>
			<td>
				{{@$account->logs->pluck('slp')->avg()}}
			</td>
			<td>
				-
			</td>
			<td>
				{{$account->next_claim_date->format("M d, Y")}}
			</td>
			<td>
				{{$account->unclaimed_slp}}
			</td>
			<td>
				{{0.01 * (100 - $account->split) * $account->unclaimed_slp}}
			</td>
			<td>
				{{0.01 * $account->split * $account->unclaimed_slp}}
			</td>
			<td class="text-right">
				<button type="button" class="btn btn-sm btn-outline-secondary">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
					  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
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

@include('modals.create-account')
@include('modals.upload-accounts')

@endpush