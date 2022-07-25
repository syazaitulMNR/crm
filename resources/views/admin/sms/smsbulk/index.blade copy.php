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
			<b>SMS Bulk</b>
		</div> 

		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">SMS Bulk</h1>
			
			<div class="btn-toolbar mb-2 mb-md-0">
				<a href="/smstemplate" class="btn bg-dark text-white">
					<i class="bi bi-receipt-cutoff pr-2"></i> SMS Template
				</a>&nbsp;

				<a href="/smsschedule" class="btn bg-dark text-white">
					<i class="bi bi-calendar2-week-fill pr-2"></i> SMS Schedule
				</a>&nbsp;

				<button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#new-bulk-sms">
					<i class="bi bi-plus-lg pr-2"></i> New Bulk SMS
				</button>&nbsp;
				
				<button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#new-sms">
					<i class="bi bi-plus-lg pr-2"></i> New SMS
				</button>
			</div>
		</div>
		
		
		<form action="{{ url('smsblast') }}" method="GET">
			<div class="row">
				<div class="col-md-8">
					<input type="text" class="form-control" name="search" value="{{ request()->query('search') ? request()->query('search') : '' }}" placeholder="Search keyword">
				</div>
				
				<div class="col-md-3">
					<select class="form-control" name="search_template">
						<option value="0">All Template</option>
					@foreach($y as $t)
						<option value="{{ $t->id }}" {{ request()->query('search_template') == $t->id ? 'selected' : '' }}>
							{{ $t->title }}
						</option>
					@endforeach
					</select>
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
				@php
				$no = (10 * ($x->currentPage() - 1));
				@endphp
				@foreach ($x as $k => $t)
					<tr>
						<td class="text-center">{{ ++$no }}</td>
						<td class="fw-bold text-center">{{ date('d-m-Y g:i A', strtotime($t->created_at)) }}</td>
						<td class="text-center">{{ $t->phone }}</td>
						<td>
							@if (!isset($t->template->title) || $t->template->title == "")
								{{ $t->title }}
							@else
								{{ $t->template->title }}
							@endif
						</td>
						<td>{{ $t->message }}</td>
					</tr>
					
				@endforeach
				</tbody>
			</table>
			{{ $x->links() }}
		</div> 
	</div>
</div>

<div class="modal fade" id="new-sms">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<h5 class="modal-title">Send New SMS</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<form action="{{ url('smsblast/send') }}" method="POST"> 
					@csrf
					Title:
					<input class="form-control" name="title" placeholder="SMS Title or Event Name" required><br />

					Message:
					<textarea class="form-control" name="message" maxlength="142" id="message" placeholder="Avoid using '&' in this message." required></textarea>
					<div class="text-danger" id="textarea_feedback"></div><br>

					Phone Number:
					<textarea class="form-control" name="phone" placeholder="seperated by comma ','" required></textarea><br>
					
					<div class='col-md-12 text-right'>
						<button type='submit' class='btn btn-success'> 
							<i class="fas fa-paper-plane"></i> Send 
						</button>
						<div class="text-danger">By click the Send button, this SMS will be send to customer on the spot.</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="new-bulk-sms">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<h5 class="modal-title">Send New Bulk SMS</h5>
				
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<form action="{{ url('smsblast/send_bulk') }}" method="POST" enctype="multipart/form-data"> 
					@csrf
					
					SMS Template:
					<select class="form-control" name="template">
					@foreach ($y as $k => $t)
						<option value="{{ $t->id }}">{{ $t->title }}</option>
					@endforeach
					</select><br />
					
					Excel Data:
					<input type="file" name="file" /><br />
					<em>Click <a href="{{ url('download-phoneno-template') }}" class="text-primary">here</a> to get the upload template.</em>
					
					<div class='col-md-12 text-right'>
						<button type='submit' class='btn btn-success'> 
							<i class="fas fa-paper-plane"></i> Send 
						</button>
						<div class="text-danger">By click the Send button, this SMS will be send to customer on the spot.</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		var text_max = 142;
		$('#textarea_feedback').html(text_max + ' characters remaining');

		$('#message').keyup(function() {
			var text_length = $('#message').val().length;
			var text_remaining = text_max - text_length;

			$('#textarea_feedback').html(text_remaining + ' characters remaining');
		});

	});
</script>
@endsection


























