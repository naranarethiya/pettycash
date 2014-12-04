@if(Session::has('error'))
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
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

<?php
	$errors_all=$errors->all();
 	if(count($errors) > 0) { 
?>
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button> 
		<ul>
			@foreach($errors_all as $error)
					<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
<?php } ?>