<form class="form-horizontal" method="post" action="{{URL::to('search')}}" style="margin-top:20px" id="searchForm">
	<div class="form-group">
		<div class="col-md-6">
			<label class="col-xs-3 control-label">Date</label>
		  <div class="col-xs-8">
			{{Form::text('from',Input::get('from'),array('placeholder'=>'From Date','class'=>'form-control datepicker2','data-date-format'=>'yyyy-mm-dd'))}}
		  </div>
		</div>
		<div class="col-md-6">
			<label class="col-xs-3 control-label">Date</label>
		  <div class="col-xs-8">
			{{Form::text('to',Input::get('to'),array('placeholder'=>'To Date','class'=>'form-control datepicker2','data-date-format'=>'yyyy-mm-dd'))}}
		  </div>
		</div>			 
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<label class="col-xs-3 control-label">&nbsp;&nbsp;</label>
			<div class="col-xs-8">
				<label class="control-label">
					<input type="radio" name="type" value="expense" @if(Input::get('type')=='expense') checked="checked" @endif> Expense
				</label>&nbsp;&nbsp;&nbsp;
				<label class="control-label">
					<input type="radio" name="type" value="receipt" @if(Input::get('type')=='receipt') checked="checked" @endif> Receipt
				</label>&nbsp;&nbsp;&nbsp;
				<label class="control-label">
					<input type="radio" name="type" value="" @if(Input::get('type')=='') checked="checked" @endif> All
				</label>
			</div>
		</div>

		<div class="col-md-6">
			<label class="col-xs-3 control-label">Branch</label>
			<div class="col-xs-8">
				{{Form::select('brid',$data['branchCombo'],Input::get('brid'),array('class'=>'form-control'))}}
			</div>
		</div>
	</div>

	<div class="form-group" id="exOpt">
		<div class="col-md-6">
			<label class="col-xs-3 control-label">Exp.Type</label>
			<div class="col-xs-8">	{{Form::select('exid',$data['expTypeCombo'],Input::get('exid'),array('class'=>'form-control','placeholder'=>'Expense Type'))}}
			</div>
		</div>

		<div class="col-md-6">
			<label class="col-xs-3 control-label">Bank</label>
			<div class="col-xs-8">
				{{Form::select('bid',$data['bankCombo'],Input::get('bid'),array('class'=>'form-control'))}}
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<label class="col-xs-3 control-label">Source/ Pay to</label>
			<div class="col-xs-8">
				{{Form::text('source',Input::get('source'),array('class'=>'form-control','placeholder'=>'Source/ Pay to'))}}
			</div>
		</div>

		<div class="col-md-6">
			<label class="col-xs-3 control-label">Amount</label>
			<div class="col-xs-8">
				{{Form::text('amount',Input::get('amount'),array('class'=>'form-control','placeholder'=>'Amount'))}}
			</div>
		</div>
	</div>
	<div class="form-group">
			<div class="col-md-6">
				<label class="col-xs-3 control-label">Payment</label>
				<div class="col-xs-8">
					<label class="control-label">
						<input type="radio" name="payment_type" value="cash" @if(Input::get('payment_type')=='cash') checked="checked" @endif> Cash
					</label>&nbsp;&nbsp;&nbsp;
					<label class="control-label">
						<input type="radio" name="payment_type" value="cheque" @if(Input::get('payment_type')=='cheque') checked="checked" @endif> Cheque
					</label>&nbsp;&nbsp;&nbsp;
					<label class="control-label">
						<input type="radio" name="payment_type" value="" @if(Input::get('payment_type')=='') checked="checked" @endif> All
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
				<input type="reset" class="btn btn-white" value="Reset" />
				<input type="submit" name="submit" id="searchSubmit" class="btn btn-primary" Value="Submit" />
			</div>
		</div>
		</div>
</form>