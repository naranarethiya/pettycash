<div class="col-md-6">
<section class="panel">
	<header class="panel-heading">Add Receipt</header>
	<div id="formContainer">
	<form class="form-horizontal" method="post" action="{{URL::to('receipt/add')}}" style="margin-top:20px" id="smsForm">
		<div class="form-group">
			 <label class="col-xs-3 control-label">Trans.ID</label>
			  <div class="col-xs-8">
				{{Form::text('id','20',array('class'=>'form-control','readonly'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">Source <span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::text('source',Input::old('source'),array('placeholder'=>'Source of fund','class'=>'form-control'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">Date<span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::text('date',Input::old('date'),array('placeholder'=>'Select Date','class'=>'form-control datepicker','required','data-date-format'=>'yyyy-mm-dd','readonly'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">Amount<span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::number('amount',Input::old('amount'),array('placeholder'=>'Amount','class'=>'form-control','required'))}}
			  </div>
		</div>
		
		<div class="form-group">
			 <label class="col-xs-3 control-label">Note/ Description</label>
			<div class="col-xs-8">
				{{Form::textarea('note',Input::old('note'),array('placeholder'=>'Note/ Description','class'=>'form-control','rows'=>'4'))}}
			</div>
		</div>
		 <div class="form-group">
			<div class="col-xs-7"></div>
			<div class="col-xs-5">
			<input type="reset" class="btn btn-white" value="Reset" />
			<input type="submit" class="btn btn-primary" Value="Submit" />
		  </div>
		</div>
	</form>
	</div>
</section>
</div>

<div class="col-md-6">
	<section class="panel">
		<header class="panel-heading">Last Receipts</header>
            <div class="table-responsive">
				<table class="table table-striped b-t text-small dataTable">
					<thead>
						<tr>
							<th>Date</th>
							<th>Source</th>
							<th>Reason/Detail</th>
							<th>Amount</th>
						</tr>
					</thead>
				<tbody>
					@foreach($data as $row)
					<tr>
						<td>{{$row->date}}</td>
						<td>{{$row->source}}</td>
						<td>{{$row->note}}</td>
						<td>{{$row->amount}}</td>
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