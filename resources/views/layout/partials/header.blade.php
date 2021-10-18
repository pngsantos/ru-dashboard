<header class="sticky-top">
	<nav class="navbar navbar-dark  bg-dark flex-md-nowrap p-0 shadow">
		<a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">RU Port</a>
		<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	
		<ul class="navbar-nav px-3">
			<li class="nav-item text-nowrap">
				@if(Auth::check())
			  	<a class="nav-link" href="{{route('doLogout')}}">Sign out</a>
			  	@else
			  	<a class="nav-link" href="{{route('login')">Sign in</a>
			  	@endif
			</li>
		</ul>
	</nav>
</header>