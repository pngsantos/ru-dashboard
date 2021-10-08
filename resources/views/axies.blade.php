@extends('layout.app')

@section('content')

<div class="pt-3 pb-3 mb-3 border-bottom">
	<div class="row">
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
    <h1 class="h2">Your Axies</h1>
	<div>
	  	Toolbar here
	</div>
</div>

<div class="row">
	@forelse($axies as $axie)
	<div class="col-md-6">
		<div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative bg-white">
			<div class="col-9 p-4 d-flex flex-column position-static">
				<strong class="d-block mb-2 text-primary">{{$axie->name}}</strong>
				<h3 class="mb-0">{{$axie->axie_id}}</h3>
				<div class="mb-1 text-muted">{{$axie->class}} &middot; Breed Count: {{$axie->breed}}</div>
				<a href="https://marketplace.axieinfinity.com/axie/{{$axie->axie_id}}" target="_blank" class="stretched-link">Open in Market</a>
			</div>
			<div class="col-3">
				<img src="{{$axie->image}}" alt="" class="img-fluid">
			</div>
		</div>
	</div>
	@empty
	<p class="col-12">
		No axies found for all your accounts
	</p>
	@endforelse
</div>

@endsection