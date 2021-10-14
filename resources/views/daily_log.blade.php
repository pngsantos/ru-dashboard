@extends('layout.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center my-3">
    <h1 class="h2">Daily SLP log</h1>
	<div>
	  	Toolbar here
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