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
			<b>SMS Template</b>
		</div> 

		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">SMS Template</h1>
			
			<div class="btn-toolbar mb-2 mb-md-0">
				<button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#add-template">
					<i class="bi bi-plus-lg pr-2"></i> New Template
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
		<div class="table-responsive">
			<table class="table table-hover" id="myTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Description</th>
						<th class="text-right"><i class="fas fa-cogs"></i></th>
					</tr>
				</thead>
				
				<tbody>
				@php
				$no = 1;
				@endphp
				@foreach ($x as $k => $t)
					<tr>
						<td>{{ $no++ }}</td>
						<td>{{ $t->title }}</td>
						<td>{{ $t->description }}</td>
						<td class="text-right">
							<a class="btn btn-dark" href="{{ url('smstemplate') }}/edit/{{ $t->id }}">
								<i class="bi bi-pencil"></i>
							</a>
							<a class="btn btn-danger" href="{{ url('smstemplate') }}/delete/{{ $t->id }}">
								<i class="bi bi-trash"></i>
							</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>   
		</div> 
	</div>
</div>

<div class="modal fade" id="add-template">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<h5 class="modal-title">Create New Template</h5>
				
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<form action="{{ url('smstemplate/add') }}" method="POST"> 
					@csrf
					Title:
					<input type="text" name="title" class="form-control" placeholder="Template Title" required/><br />
					
					Description:
					<textarea class="form-control" name="description" placeholder="Description" required></textarea><br />
					
					Content:
					<textarea class="form-control" id="textarea" name="content" maxlength="142" placeholder="Content" required></textarea>
					<div class="text-danger" id="textarea_feedback"></div>
					<hr>

					<span class="fw-bolder">For SMS auto blasting purpose only. Can leave it blank.</span><br>
					Class:
					<select class="form-control" name="class">
						<option value="">Select Event Class...</option>
						@foreach ($prods as $prod)
							<option value="{{ $prod->class }}">{{ $prod->class }}</option>
						@endforeach
					</select><br>
					
					<div class="row">
						<span class="text-danger text-sm">*<b>Choose</b> between <b>DAY</b> or <b>HOUR</b> before event start</span>
						<div class="col-md-6">
							Day:
							<input type="number" class="form-control" name="day" max="10" min="1" placeholder="Day Before Event Start"><br>
						</div>
						<div class="col-md-6">
							Hour:
							<input type="number" class="form-control" name="hour" max="23" min="1" placeholder="Hour Before Event Start">
						</div>
					</div>

					
					<div class='col-md-12 text-right px-4'>
						<button type='submit' class='btn btn-success'> 
							<i class="fas fa-save pr-1"></i> Save 
						</button>
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

		$('#textarea').keyup(function() {
			var text_length = $('#textarea').val().length;
			var text_remaining = text_max - text_length;

			$('#textarea_feedback').html(text_remaining + ' characters remaining');
		});

	});
</script>
@endsection



























