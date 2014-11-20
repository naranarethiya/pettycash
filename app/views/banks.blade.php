<div class="col-md-6">
<section class="panel">
	<header class="panel-heading">Bank Details</header>
	<div id="formContainer">
	@if($bank)
		{{Form::model($bank,array("url"=>array('setting/bank/add',$bank->bid),'method'=>'post','style'=>'margin-top:20px','id'=>'smsForm','class'=>'form-horizontal'))}}
	@else
		{{Form::open(array('class'=>'form-horizontal','url'=>'setting/bank/add','method'=>'post','style'=>'margin-top:20px','id'=>'smsForm'))}}
	@endif
		<div class="form-group">
			 <label class="col-xs-3 control-label">Title <span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::text('title',NULL,array('placeholder'=>'Title','class'=>'form-control','required'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">A/C No.<span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::number('ac_number',NULL,array('placeholder'=>'Account Number','class'=>'form-control','required'))}}
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
			@if($bank)
				<a href="{{URL::to('setting/bank')}}" class="btn btn-danger">Cancel</a>
			@endif
		  </div>
		</div>
	</form>
	</div>
</section>
</div>

<div class="col-md-6">
	<section class="panel">
		<header class="panel-heading">Bank List</header>
            <div class="table-responsive">
				<table class="table table-striped b-t text-small dataTable">
					<thead>
						<tr>
							<th>Title</th>
							<th>A/c No.</th>
							<th>Note</th>
							<th>Edit</th>
						</tr>
					</thead>
				<tbody>
					@foreach($data as $row)
					<tr>
						<td>{{$row->title}}</td>
						<td>{{$row->ac_number}}</td>
						<td>{{$row->note}}</td>
						<td>
							<a href="{{URL::to('setting/bank/'.$row->bid)}}">
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

