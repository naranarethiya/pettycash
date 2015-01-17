<form class="form-horizontal" method="post" action="{{URL::to('bank_book/search')}}" style="margin-top:20px" id="searchForm">
	<div class="form-group">
		<div class="col-md-6">
			<label class="col-xs-3 control-label">From Date</label>
		  <div class="col-xs-8">
			{{Form::text('from',Input::get('from'),array('placeholder'=>'From Date','class'=>'form-control datepicker2','data-date-format'=>'yyyy-mm-dd'))}}
		  </div>
		</div>
		<div class="col-md-6">
			<label class="col-xs-3 control-label">To Date</label>
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
					<input type="radio" name="type" value="debit" @if(Input::get('type')=='debit') checked="checked" @endif> Debit
				</label>&nbsp;&nbsp;&nbsp;
				<label class="control-label">
					<input type="radio" name="type" value="credit" @if(Input::get('type')=='credit') checked="checked" @endif> Credit
				</label>&nbsp;&nbsp;&nbsp;
				<label class="control-label">
					<input type="radio" name="type" value="" @if(Input::get('type')=='') checked="checked" @endif> All
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			<label class="col-xs-3 control-label">Bank</label>
			<div class="col-xs-8">
				{{Form::select('bid',$bankCombo,Input::get('bid'),array('class'=>'form-control'))}}
			</div>
		</div>
		<div class="col-md-6">
			<label class="col-xs-3 control-label">Ref. No.</label>
		  <div class="col-xs-8">
			{{Form::text('ref_no',Input::get('ref_no'),array('placeholder'=>'Referense No.','class'=>'form-control'))}}
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
				<input type="reset" class="btn btn-white" value="Reset" />
				<input type="submit" name="submit" id="searchSubmit" class="btn btn-primary" Value="Submit" />
			</div>
		</div>
		</div>
</form>