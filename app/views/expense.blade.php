<div class="col-md-6">
<section class="panel">
	<header class="panel-heading">Add Expense</header>
	<div id="formContainer">
	<form class="form-horizontal" method="post" action="{{URL::to('expense/add')}}" style="margin-top:20px" id="smsForm">
		<div class="form-group">
			 <label class="col-xs-3 control-label">Trans.ID</label>
			  <div class="col-xs-8">
				{{Form::text('id','20',array('class'=>'form-control','readonly'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">Branch <span class="text-danger">*</span></label>
			  <div class="col-xs-8">
			  	{{Form::select('brid',$data['branchCombo'],NULL,array('class'=>'form-control','required','pattern'=>'[1-9]+'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">Exp. Type<span class="text-danger">*</span></label>
			  <div class="col-xs-8">
			  	{{Form::select('exid',$data['expTypeCombo'],NULL,array('class'=>'form-control','required'))}}
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
			 <label class="col-xs-3 control-label">Payment Type<span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				<label class="control-label">
					{{Form::radio('payment_type','cash',array('required'))}} Cash
				</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<label class="control-label">
					{{Form::radio('payment_type','cheque',array('required'))}} Cheque
				</label>
			  </div>
		</div>

		<div class="form-group" id="bankCombo" style="display:none">
			 <label class="col-xs-3 control-label">Select Bank<span class="text-danger">*</span></label>
			  <div class="col-xs-8">
			  	{{Form::select('bid',$data['bankCombo'],NULL,array('class'=>'form-control'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">Note/ Reason/ Description</label>
			<div class="col-xs-8">
				{{Form::textarea('note',Input::old('note'),array('placeholder'=>'Note/ Reason/ Description','class'=>'form-control','rows'=>'4'))}}
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
							<th>Branch</th>
							<th>Expense Type</th>
							<th>Amount</th>
							<th>Payment</th>
						</tr>
					</thead>
				<tbody>
					@foreach($data['transations'] as $row)
					<tr>
						<td>{{$row->date}}</td>
						<td>{{$row->branch_name}}</td>
						<td>{{$row->expense_type}}</td>
						<td>{{$row->amount}}</td>
					</tr>
					@endforeach
					@if(count($data['transations']) < 1)
						<tr>
							<td colspan="4">No data found</td>
						</tr>
					@endif
				</tbody>
				</table>
			</div>
	</section>
</div>

<script>
	$('input[name="payment_type"]').change(function() {
		var val=$(this).val();
		if(val=='cash') {
			$('#bankCombo').hide();
		}
		else {
			$('#bankCombo').show();
		}
	});
	$(document).ready(function() {
		var val=$('input[name="payment_type"]:checked').val();
		if(val=='cheque') {
			$('#bankCombo').show();
		}
		else {
			$('#bankCombo').hide();
		}
	});
</script>