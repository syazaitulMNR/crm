@extends('layouts.app')

@section('title')
  SMS Template
@endsection

@section('content')
<div class="row px-4 py-4">
	<div class="col-md-12">
		<div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
			<a href="/dashboard"><i class="bi bi-arrow-left"></i></a> &nbsp; 
			<a href="/dashboard">Dashboard</a> / 
			<a href="/smsblast">SMS Bulk</a> / 
			<b>SMS Schedule</b>
		</div> 

		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">SMS Schedule</h1>
			
			<div class="btn-toolbar mb-2 mb-md-0">
				<a href="/smsblast" class="btn bg-dark text-white">
					<i class="bi bi-chat-right-quote pr-2"></i> SMS Bulk
				</a>&nbsp;

				<a href="/smstemplate" class="btn bg-dark text-white">
					<i class="bi bi-receipt-cutoff pr-2"></i> SMS Template
				</a>&nbsp;

				<button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#add-template">
					<i class="bi bi-plus-lg pr-2"></i> New Schedule
				</button>
			</div>
		</div>
		
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
		@if(!empty($schedules) && $schedules->count())
			<div class="table-responsive">
				<table class="table table-hover" id="myTable">
					<thead>
						<tr class="text-center">
							<th>#</th>
							<th>Name</th>
							<th>Event</th>
							<th>Event Date</th>
							<th>Template</th>
							<th>Blasting Info</th>
							<th>Status</th>
							<th class="text-right"><i class="fas fa-cogs"></i></th>
						</tr>
					</thead>
					
					<tbody>
						@php $no = 1; @endphp
						@foreach ($schedules as $schedule => $sched)
							<tr>
								<td class="text-center">{{ $no++ }}</td>
								<td>{{ $sched->name }}</td>
								<td>{{ $sched->products->name }}</td>
								<td class="text-center">{{ $sched->products->date_from }}</td>
								<td class="text-center">{{ $sched->smstemp->title }}</td>
								<td class="text-center fw-bold">{{ date('d-m-Y', strtotime($sched->date)) }} {{ date('g:i A', strtotime($sched->time)) }}</td>
								<td class="text-center">
									@if ($sched->status == "In Progress")
										<div class="text-danger fw-bolder">{{ $sched->status }}</div>
									@elseif ($sched->status == "Sent")
										<div class="text-success fw-bolder">{{ $sched->status }}</div>
									@endif
								</td>
								<td class="text-right">
									@if ($sched->status == "In Progress")
										<a class="btn btn-dark" href="{{ url('smsschedule') }}/edit/{{ $sched->id }}">
											<i class="bi bi-pencil"></i>
										</a> 
									@endif
									<a class="btn btn-danger" href="{{ url('smsschedule') }}/delete/{{ $sched->id }}">
										<i class="bi bi-trash"></i>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>   
			</div> 
		@else
			<div>
				No SMS Schedule has been created.
			</div>
		@endif
	</div>
</div>

<div class="modal fade" id="add-template">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<h5 class="modal-title">Create New Schedule</h5>
				
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<form action="{{ url('smsschedule/add') }}" method="POST"> 
					@csrf
					Name:
					<input type="text" name="name" class="form-control" placeholder="SMS Schedule Name" required><br>

					For Event:
					<select class="form-select multi-select" name="product_id" required>
						<option value="">Select Event...</option>
						@foreach ($products as $prod)
							<option value="{{ $prod->product_id }}">{{ $prod->name }}</option>
						@endforeach
					</select><br>
					
					SMS Template:
					<select name="template_id" id="template_id" class="form-select dynamic" data-dependent="content" required>
						<option value="">Select Template...</option>
						@foreach ($templates as $tem)
							<option value="{{ $tem->id }}">{{ $tem->title }}</option>
						@endforeach
					</select><br>

					Message:
					<div class="some" id="some_0" style="display:block;">
						<textarea class="form-control" rows="5" readonly></textarea>
					</div>
					@foreach ($templates as $tem)
						<div class="some" id="some_{{ $tem->id }}" style="display:none;">
							<textarea class="form-control" rows="5" readonly>{{ $tem->content }}</textarea>
						</div>
					@endforeach <br>				 

					Auto Blasting Type:
					<select class="form-select" id="type" name="type" required>
						<option value="">Select Type...</option>
						<option value="datetime">Date and Time</option>
						<option value="day">Day Before Event</option>
					</select><br>

					<div style="display: none;" id="datetime">
						<div class="row">
							<div class="col-md-6">
								Date:
								<input type="date" name="date" class="form-control"><br>
							</div>

							<div class="col-md-6">
								Time:
								<input type="time" name="time" class="form-control"><br>
							</div>
						</div>
					</div>

					<div style="display: none;" id="day">
						<div class="row">
							<div class="col-md-6">
								Day Before Event:
								<input type="number" class="form-control" name="day_before" max="10" min="1" placeholder="How Many Day Before"><br>
							</div>

							<div class="col-md-6">
								Time:
								<input type="time" name="time_day" class="form-control" placeholder="Set Time Blasting"><br>
							</div>
						</div>
					</div>

					<div style="display: none;" id="hour">
						Hour:
						<input type="number" class="form-control" name="time_before" max="23" min="1" placeholder="Hour Before Event Start">
					</div>
					
					<div class='col-md-12 text-right px-4'>
						<br><button type='submit' class='btn btn-success'> 
							<i class="fas fa-save pr-1"></i> Save 
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$('#template_id').on('change',function(){
		$(".some").hide();
		var some = $(this).find('option:selected').val();
		if (some != '') {
			$("#some_" + some).show();
			$("#some_0").hide();
		} else {
			$("#some_" + some).hide();
			$("#some_0").show();
		}
		
	});

	document.getElementById('type').addEventListener("change", function (e) {
		if (e.target.value === 'datetime') {
			document.getElementById('datetime').style.display = 'block';
			document.getElementById('day').style.display = 'none';

		} else if (e.target.value === 'day') {
			document.getElementById('datetime').style.display = 'none';
			document.getElementById('day').style.display = 'block';

		} else {
			document.getElementById('datetime').style.display = 'none';
			document.getElementById('day').style.display = 'none';
		}
	});
</script>

@endsection