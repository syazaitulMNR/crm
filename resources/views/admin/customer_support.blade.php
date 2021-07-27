@extends('layouts.app')

@section('title')
    Dashboard
@endsection


@section('content')
<style>
html, body {
	height: 100%;
}

.issue-card {
	height: calc(100% - 100px);
}

.container-fluid {
	height: calc(100% - 50px);
}

.h-100{
	height: 100%;
}

.h-m-100 {
	height: calc(100% - 75px)
}
</style>
<div class="row h-100">
	<div class="col-md-12 h-100">     
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Customer Support</h1>
			<p class="lead">Chat base customer support</p>
		</div>
		
		@if ($maintenance)
			<div class="alert alert-danger alert-block">	
				<strong>This page is currently closed for while due to constrcution in progress.</strong>
			</div>
		@else
		
		<div class="row h-m-100">
			<div class="col-md-4 h-100">
				<div class="card h-100">
					<div class="card-header">
						<span class="fas fa-list"></span> Issues Listing
					</div>
					
					<div class="card-body">
						<div class="row">
							
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-8">
				
			</div>
		</div>
		@endif
	</div>
</div>

@endsection
