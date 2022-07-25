@extends('layouts.app')

@section('title')
  SMS Bulk
@endsection

@section('content')
<div class="row px-4 py-4">
	<div class="col-md-12">
		<div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
			<a href="/dashboard"><i class="bi bi-arrow-left"></i></a> &nbsp; 
			<a href="/dashboard">Dashboard</a> /
			<a href="/smsblast">SMS Bulk</a> /
			<b>SMS Bulk Details</b>
		</div> 

		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			
				<h2 class="text-capitalize">{{$x->first()->title}}</h2>
			
		</div>

		@if($x->first()->type == "Schedule")
			@foreach($products as $p)
				@if ($x->first()->schedule->product_id == $p->product_id)
					<table class="table-responsive mb-3">
						<tr>
							<td class="col-md-2">Event</td>
							<td class="col-md-10 fw-bold">: {{ $p->name }}</td>
						</tr>
						<tr>
							<td class="col-md-2">Date Of Event</td>
							<td class="col-md-10 fw-bold">: {{ date('d/m/Y', strtotime($p->date_from)) }} 
								({{ date('g:i A', strtotime($p->time_from)) }}) - 
								{{ date('d/m/Y', strtotime($p->date_to)) }} 
								({{ date('g:i A', strtotime($p->time_to)) }})
							</td>
						</tr>
					</table>
				@endif
			@endforeach
		@endif
		
		
		<form action="{{ url('smsblast') }}/{{ $group_id }}" method="GET">
			<div class="row">
				<div class="col-md-11">
					<input type="text" class="form-control" name="search" value="{{ request()->query('search') ? request()->query('search') : '' }}" placeholder="Search Phone Number">
				</div>
				
				<div class="col-md-1">
					<button class="btn btn-block btn-outline-dark btn-lg">
						<span class="fas fa-search"></span>
					</button>
				</div>
			</div>
            
        </form>
		<br>
			
		@if (session('success'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-bs-dismiss="alert">×</button>	
			<strong>{{ session('success') }}</strong>
		</div>
		@endif
		
		@if (session('error'))
		<div class="alert alert-danger alert-block">
			<button type="button" class="close" data-bs-dismiss="alert">×</button>	
			<strong>{{ session('error') }}</strong>
		</div>
		@endif

		<!-- View event details in table ----------------------------------------->
		<div class="table-responsive">
			<table class="table table-hover" id="myTable">
				<thead>
					<tr class="text-center">
						<th>#</th>
						<th>Date</th>
						<th>Phone</th>
						<th>Template Title</th>
						<th>Message</th>
					</tr>
				</thead>
				
				<tbody>
					@php $no = (10 * ($x->currentPage() - 1)); @endphp
					@foreach ($x as $k => $t)
						<tr> 
							<td class="text-center">{{ ++$no }}</td>
							<td class="text-center fw-bold">{{ date('d-m-Y g:i A', strtotime($t->created_at."+8 hours")) }}</td>
							<td class="text-center">{{ $t->phone }}</td>
							<td>
								@if($t->type == "Bulk Excel" || $t->type == "Schedule")
									{{$t->template->title}}
								@else
									{{$t->title}}
								@endif
							</td>
							<td>{{ $t->message }}</td>
							<td></td>
							
						</tr>
					@endforeach
				</tbody>
			</table>
			{{ $x->links() }}
		</div> 
	</div>
</div>

@endsection


























