<div class="col-md-6">
<section class="panel">
	<header class="panel-heading">Add User</header>
	<div id="formContainer">
		@if($user)
			{{Form::model($user,array("url"=>array('user/add',$user->uid),'method'=>'post','style'=>'margin-top:20px','id'=>'userForm','class'=>'form-horizontal'))}}
		@else
			{{Form::open(array('class'=>'form-horizontal','url'=>'user/add','method'=>'post','style'=>'margin-top:20px','id'=>'userForm'))}}
		@endif
			<div class="form-group">
				 <label class="col-xs-3 control-label">Name <span class="text-danger">*</span></label>
				  <div class="col-xs-8">
					{{Form::text('name',NULL,array('placeholder'=>'Name','class'=>'form-control','required'))}}
				  </div>
			</div>

			<div class="form-group">
				 <label class="col-xs-3 control-label">Email <span class="text-danger">*</span></label>
				  <div class="col-xs-8">
					{{Form::email('email',NULL,array('placeholder'=>'Email Address','class'=>'form-control','required'))}}
				  </div>
			</div>

			<div class="form-group">
				 <label class="col-xs-3 control-label">Mobile <span class="text-danger">*</span></label>
				  <div class="col-xs-8">
					{{Form::text('mobile',NULL,array('placeholder'=>'Mobile Number','class'=>'form-control','required'))}}
				  </div>
			</div>

			<div class="form-group">
				 <label class="col-xs-3 control-label">Password <span class="text-danger">*</span></label>
				  <div class="col-xs-8">
					{{Form::password('password',array('placeholder'=>'Login Password','class'=>'form-control'))}}
				  </div>
			</div>

			<div class="form-group">
				 <label class="col-xs-3 control-label">Confirm password <span class="text-danger">*</span></label>
				  <div class="col-xs-8">
					{{Form::password('confirm_password',array('placeholder'=>'Confirm Password','class'=>'form-control'))}}
					@if($user) <code>Left blank if not wants to change</code> @endif
				  </div>
			</div>

			<div class="form-group">
				 <label class="col-xs-3 control-label">User Type <span class="text-danger">*</span></label>
				  <div class="col-xs-8">
				  	<?php 
				  		$userTypes=array('user'=>'User','viewer'=>'Viewer','admin'=>'Admin');
				  	?>
					{{Form::select('user_type',$userTypes,NULL,array('class'=>'form-control','required'))}}
				  </div>
			</div>

			<div class="form-group">
				<div class="col-xs-7"> </div>
				<div class="col-xs-5">
					<input type="submit" class="btn btn-primary" Value="Submit" />
					@if($user)
						<a href="{{URL::to('user/add')}}" class="btn btn-danger">Cancle</a>
					@endif
					<input type="reset" class="btn btn-white" value="Reset" />
			 	</div>
			</div>
		{{Form::close()}}
	</div>
</section>
</div>


<div class="col-md-6">
	<section class="panel">
		<header class="panel-heading">Last Receipts</header>
            <div class="table-responsive">
				<table class="table table-striped b-t text-small dataTables">
					<thead>
						<tr>
							<th>Name</th>
							<th>email</th>
							<th>Mobile</th>
							<th>Type</th>
							<th>Parent</th>
						</tr>
					</thead>
				<tbody>
					@foreach($data['users'] as $row)
					<tr>
						<td><a href="{{URL::to('user/add/'.$row->uid)}}">{{$row->name}}</a></td>
						<td>{{$row->email}}</td>
						<td>{{$row->mobile}}</td>
						<td>{{$row->user_type}}</td>
						<td>{{$row->parent_name}}</td>
					</tr>
					@endforeach
				</tbody>
				</table>
			</div>
	</section>
</div>
<link rel="stylesheet" href="{{ URL::asset('js/datatables/jquery.dataTables.min.css') }}">
<script src="{{ URL::asset('js/datatables/jquery.dataTables.min.js') }}"></script>
<script>
	 $('.dataTables').DataTable({
        "scrollY": "350px",
        "bsort": true,
		"bPaginate": false
    });
</script>