<div class="col-md-6">
<section class="panel">
	<header class="panel-heading">Expense Type Detail</header>
	<div id="formContainer">
	@if($expense)
		{{Form::model($expense,array("url"=>array('setting/expense/add',$expense->exid),'method'=>'post','style'=>'margin-top:20px','id'=>'smsForm','class'=>'form-horizontal'))}}
	@else
		{{Form::open(array('class'=>'form-horizontal','url'=>'setting/expense/add','method'=>'post','style'=>'margin-top:20px','id'=>'smsForm'))}}
	@endif
		<div class="form-group">
			 <label class="col-xs-3 control-label">Title <span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::text('title',NULL,array('placeholder'=>'Title','class'=>'form-control','required'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">Note</label>
			<div class="col-xs-8">
				{{Form::textarea('note',NULL,array('placeholder'=>'Note','class'=>'form-control','rows'=>'4'))}}
			</div>
		</div>

		 <div class="form-group">
			<div class="col-xs-7"></div>
			<div class="col-xs-5">
			<input type="reset" class="btn btn-white" value="Reset" />
			<input type="submit" class="btn btn-primary" Value="Submit" />
			@if($expense)
				<a href="{{URL::to('setting/expense')}}" class="btn btn-danger">Cancel</a>
			@endif
		  </div>
		</div>
	</form>
	</div>
</section>
</div>

<div class="col-md-6">
	<section class="panel">
		<header class="panel-heading">Expense type List</header>
            <div class="table-responsive">
				<table class="table table-striped b-t text-small dataTable">
					<thead>
						<tr>
							<th>Title</th>
							<th>Note</th>
							<th>Edit</th>
						</tr>
					</thead>
				<tbody>
					@foreach($data as $row)
					<tr>
						<td>{{$row->title}}</td>
						<td>{{$row->note}}</td>
						<td>
							<a href="{{URL::to('setting/expense/'.$row->exid)}}">
								<i class="fa fa-edit"></i> Edit 
							</a>
						</td>
					</tr>
					@endforeach
					@if(count($data) < 1)
						<tr>
							<td colspan="4">No data found</td>
						</tr>
					@endif
				</tbody>
				</table>
			</div>
	</section>
</div>

