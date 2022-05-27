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
			<a href="/smstemplate">SMS Template</a> / 
			<b>Edit SMS Template</b>
		</div> 

		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Edit SMS Template</h1>
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
		
		@if($x->count() > 0)
		<form action="{{ url('smstemplate/edit') }}/{{ $x->first()->id }}" method="POST">
			{{ method_field('PUT') }}
			@csrf
			
			Title:
			<input type="text" name="title" class="form-control" placeholder="Template Title" value="{{ $x->first()->title }}" required/><br/>
			
			Description:
			<textarea class="form-control" name="description" placeholder="Description" required>{{ $x->first()->description }}</textarea><br/>
			
			Content:
			<textarea class="form-control" id="textarea" name="content" maxlength="142" placeholder="Content" required>{{ $x->first()->content }}</textarea>
			<div class="text-danger" id="textarea_feedback"></div>

			<div class='col-md-12 text-right px-4'>
				<button type='submit' class='btn btn-success'> 
					<i class="fas fa-save pr-1"></i> Save 
				</button>
			</div>
			
		</form>
		@else
			<div class="alert alert-danger alert-block">
				<strong>Selected data is not availble in database. Please select a correct data.</strong>
			</div>
		@endif
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




























