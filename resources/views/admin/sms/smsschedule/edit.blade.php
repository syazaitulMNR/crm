@extends('layouts.app')

@section('title')
  Edit SMS Template
@endsection

@section('content')
<div class="row px-4 py-4">
	<div class="col-md-12">
		<div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
			<a href="/smstemplate"><i class="bi bi-arrow-left"></i></a> &nbsp; 
			<a href="/dashboard">Dashboard</a> / 
			<a href="/smsblast">SMS Bulk</a> / 
			<a href="/smsschedule">SMS Schedule</a> / 
			<b>Edit SMS Schedule</b>
		</div> 

		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Edit SMS Schedule</h1>

			<div class="btn-toolbar mb-2 mb-md-0">
				<a href="/smsblast" class="btn bg-dark text-white">
					<i class="bi bi-chat-right-quote pr-2"></i> SMS Bulk
				</a>&nbsp;

				<a href="/smstemplate" class="btn bg-dark text-white">
					<i class="bi bi-receipt-cutoff pr-2"></i> SMS Template
				</a>
			</div>
		</div><br>
			
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
		
		@if($sched->count() > 0)
			<form action="{{ url('smsschedule/edit') }}/{{ $sched->first()->id }}" method="POST">
			{{ method_field('PUT') }}
				@csrf
				Name:
				<input type="text" name="name" class="form-control" placeholder="SMS Schedule Name" value="{{ $sched->first()->name }}" required><br>

				<div class="row">
					<div class="col-md-6">
						For Event:
						<select class="form-select multi-select" name="product_id" required>
							@foreach ($prods as $prod)
								<option value="{{ $prod->product_id }}" @if($prod->product_id == $sched->first()->product_id) selected @endif>{{ $prod->name }}</option>
							@endforeach
						</select><br>
					</div>

					<div class="col-md-6">
						SMS Template:
						<select name="template_id" id="template_id" class="form-select dynamic" data-dependent="content" required>
							@foreach ($templates as $tem)
								<option value="{{ $tem->id }}" @if($tem->id == $sched->first()->template_id) selected @endif>{{ $tem->title }}</option>
							@endforeach
						</select><br>
					</div>
				</div>

				Message:
				<div class="some" id="some_0" style="display:block;">
					<textarea class="form-control" rows="5" readonly>{{ $sched->first()->smstemp->content }}</textarea>
				</div>
				@foreach ($templates as $tem)
					<div class="some" id="some_{{ $tem->id }}" style="display:none;">
						<textarea class="form-control" rows="5" readonly>{{ $tem->content }}</textarea>
					</div>
				@endforeach <br>				 

				Auto Blasting Type:
				<select class="form-select" id="type" name="type" required>
					<option value="datetime"  @if($sched->first()->day_before == NULL) selected @endif>Date and Time</option>
					<option value="day" @if($sched->first()->day_before != NULL) selected @endif>Day Before Event</option>
				</select><br>

				@if($sched->first()->day_before == NULL)
					<div style="display: block;" id="datetime">
						<div class="row">
							<div class="col-md-6">
								Date:
								<input type="date" name="date" class="form-control" value="{{ $sched->first()->date }}"><br>
							</div>

							<div class="col-md-6">
								Time:
								<input type="time" name="time" class="form-control" value="{{ $sched->first()->time }}"><br>
							</div>
						</div>
					</div>

					<div style="display: none;" id="day">
						<div class="row">
							<div class="col-md-6">
								Day:
								<input type="number" class="form-control" name="day_before" max="10" min="1" placeholder="Day Before Event Start"><br>
							</div>

							<div class="col-md-6">
								Time:
								<input type="time" name="time_day" class="form-control"><br>
							</div>
						</div>
					</div>
				@elseif($sched->first()->day_before != NULL)
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
					
					<div style="display: block;" id="day">
						<div class="row">
							<div class="col-md-6">
								Day:
								<input type="number" class="form-control" name="day_before" max="10" min="1" value="{{ $sched->first()->day_before }}" placeholder="Day Before Event Start"><br>
							</div>

							<div class="col-md-6">
								Time:
								<input type="time" name="time_day" class="form-control" value="{{ $sched->first()->time }}"><br>
							</div>
						</div>
					</div>
				@endif
				
				<div class='col-md-12 text-right px-4'>
					<br><button type='submit' class='btn btn-success'> 
						<i class="fas fa-save pr-1"></i> Save 
					</button>
				</div>
		@else
			<div class="alert alert-danger alert-block">
				<strong>Selected data is not availble in database. Please select a correct data.</strong>
			</div>
		@endif
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
			document.getElementById('datetime').style.display = 'block';
			document.getElementById('day').style.display = 'block';
		}
	});
</script>

@endsection




























