@extends('layout.app')

@section('content')
<div class="row">
	<div class="col-md-6 col-8">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center my-3">
		    <h1 class="h2">Scholars</h1>
			<div>
			  	Toolbar here
			</div>
		</div>

		<table class="table table-striped table-sm">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Code</th>
					<th scope="col">Name</th>
					<th scope="col">Owner</th>
					<th scope="col">Team Weight</th>
				</tr>
			</thead>
			<tbody>
				@forelse($accounts as $account)
				<tr>
					<td>
						<a href="{{route('accountView', [$account->id])}}" class="font-weight-bold">{{$account->code}}</a>
					</td>
					<td>
						<a href="{{route('accountView', [$account->id])}}" class="font-weight-bold">{{$account->name}}</a>
					</td>
					<td>
						<a href="{{route('accountView', [$account->id])}}" class="font-weight-bold">{{$account->owner}}</a>
					</td>
					<td>
						<a href="{{route('accountView', [$account->id])}}" class="font-weight-bold">{{$account->current_payout->weight}}</a>
					</td>
				</tr>
				@empty
				<tr>
					<td>
						No accounts
					</td>
				</tr>
				@endforelse
		  	</tbody>
		 </table>
	</div>
	<div class="col-md-6 col-4">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center my-3">
		    <h1 class="h2">Managers</h1>
			<div>
			  	Toolbar here
			</div>
		</div>

		<table class="table table-striped table-sm">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Manager</th>
					<th scope="col">Total Weight</th>
					<th scope="col">Team Count</th>
					<th scope="col">%</th>
				</tr>
			</thead>
			<tbody>
				@forelse($owners as $owner => $owned)
				<tr>
					<td>
						{{$owner}}
					</td>
					<td>
						
					</td>
					<td>
						{{$owned->count()}}
					</td>
					<td>
						{{$owned->sum('account.current_payout->weight')}}
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="4">
						No owbers
					</td>
				</tr>
				@endforelse
		  	</tbody>
		 </table>
	</div>
</div>

@endsection