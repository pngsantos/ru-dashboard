@extends('layout.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center my-3">
    <h1 class="h2">Daily SLP log</h1>
	<div>
		<form action="" class="form-inline">
			<label class="sr-only" for="inlineFormInputGroupUsername2">From</label>
			<div class="input-group mb-2 mr-sm-2">
				<div class="input-group-prepend">
					<div class="input-group-text">From</div>
				</div>
				<input type="date" class="form-control" id="" placeholder="From" value="{{\Carbon\Carbon::now()->subDays(14)->format('Y-m-d')}}" name="start_date">
			</div>
			<label class="sr-only" for="inlineFormInputGroupUsername2">To</label>
			<div class="input-group mb-2 mr-sm-2">
				<div class="input-group-prepend">
					<div class="input-group-text">To</div>
				</div>
				<input type="date" class="form-control" id="" placeholder="To" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" name="end_date">
			</div>
	  		<button type="submit" class="btn btn-primary mb-2">Filter</button>
	  		<button type="button" class="btn btn-secondary mb-2 ml-2" data-toggle="modal" data-target="#export-log-modal">Export</button>
		</form>
	</div>
</div>

<table class="table table-striped table-sm">
	<thead class="thead-dark">
		<tr>
			<th scope="col">Account</th>
			@foreach($period as $date)
			<th scope="col text-center">
				{{$date->format('m/d')}}
			</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		@forelse($accounts as $account)
		<tr>
			<td>
				<a href="{{route('accountView', [$account->id])}}" class="font-weight-bold">{{$account->name}}</a>
				@if($account->tags)
				<div>
					@foreach($account->tags as $tag)
					<span class="badge badge-secondary text-capitalize">{{$tag}}</span>
					@endforeach
				</div>
				@endif
			</td>
			@foreach($period as $date)
			<td scope="col text-center">
				{{@$account->logs->where('date', $date->startOfDay())->first()->slp}}
			</td>
			@endforeach
		</tr>
		@empty
		<tr>
			<td colspan="{{$period->count() + 1}}">
				No accounts
			</td>
		</tr>
		@endforelse
  	</tbody>
 </table>

@endsection

@push('added-modals')

@include('modals.export-log')

@endpush