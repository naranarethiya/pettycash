@if(Session::has('error'))
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button> 
		<i class="fa fa-times"></i>
		{{ Session::get('error') }}
	</div>
@endif

@if(Session::has('success'))
	<div class="alert alert-success"> 
		<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button> 
		<i class="fa fa-ban-circle fa-lg"></i>
		{{ Session::get('success') }}
	</div>
@endif

@foreach($errors->all() as $error)
	<div class="alert alert-danger">{{ $error }}</div>
@endforeach