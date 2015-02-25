<div class="col-md-6">
<section class="panel">
	<header class="panel-heading">Bank Transactions</header>
	<div id="formContainer">
	<form class="form-horizontal" method="post" action="{{URL::to('bank_book/add')}}" style="margin-top:20px" id="smsForm">
		
		<div class="form-group">
		  	<label class="col-xs-3 control-label"></label>
			<label>{{Form::radio('type', 'credit',array('required'))}} Credit </label>
			<label>{{Form::radio('type', 'debit',array('required'))}} Debit</label>
	  	</div>
		<!--<div class="form-group">
			 <label class="col-xs-3 control-label">Source/ Pay to <span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::text('source',Input::old('source'),array('placeholder'=>'Source/Pay to','class'=>'form-control','required'))}}
			  </div>
		</div>-->

		<div class="form-group">
			 <label class="col-xs-3 control-label">Date <span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::text('date',Input::old('date'),array('placeholder'=>'Select Date','class'=>'form-control datepicker','required','data-date-format'=>'yyyy-mm-dd'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">Bank <span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::select('bid',$bankCombo,Input::old('bid'),array('class'=>'form-control','required'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">Amount<span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::text('amount',Input::old('amount'),array('placeholder'=>'Amount','class'=>'form-control','required'))}}
			  </div>
		</div>

		<div class="form-group">
			 <label class="col-xs-3 control-label">Cheque No. <span class="text-danger">*</span></label>
			  <div class="col-xs-8">
				{{Form::text('ref_no',Input::old('ref_no'),array('placeholder'=>'Reference Number','class'=>'form-control'))}}
			  </div>
		</div>
		
		<div class="form-group">
			 <label class="col-xs-3 control-label">Particular </label>
			<div class="col-xs-8">
				{{Form::textarea('note',Input::old('note'),array('placeholder'=>'Particular/ Note','class'=>'form-control','rows'=>'4'))}}
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
		<header class="panel-heading">Last 10 Transactions</header>
            <div class="table-responsive">
				<table class="table table-condensed">
					<thead>
						<tr>
							<th>Date</th>
							<th>Particular</th>
							<th>Bank</th>
							<th>Amount</th>
							<th>Cheque No.</th>
							<th>#</th>
						</tr>
					</thead>
				<tbody>
					@foreach($data as $row)
					<tr id="tr{{$row->id}}" class="@if($row->type=='debit')danger @else success @endif">
						<td>{{formatDate($row->date,'d, M')}}</td>
						<td>{{$row->note}}</td>
						<td>{{$row->bank}}</td>
						<td>{{$row->amount}}</td>
						<td>{{$row->ref_no}}</td>
						<td>
							<a onclick="deleteBankTransation('{{$row->id}}')" href="#"><i class="fa fa-trash-o"></i></a>
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
<script>
	$('select[name="bid"]').change(function() {
		var val=$(this).val();
		url=base_url+"bank_book/getTransation";
		$.ajax({
			method:"post",
			url:url,
			data:{bid:val},
			dataType:"json",
		}).done(function(data) {
			var tbody="";
			$.each(data,function(key,val) {
				if(val.type=='debit') {
					var cls='danger';
				}
				else {
					var cls='success';
				}
				tbody+='<tr id="tr'+val.id+'" class="'+cls+'"><td>'+val.date+'</td><td>'+val.note+'</td><td>'+val.bank+'</td><td>'+val.amount+'</td><td>'+val.ref_no+'</td><td><a onclick="deleteBankTransation(\''+val.id+'\')" href="#"><i class="fa fa-trash-o"></i></a></td></tr>';
			})
			$('table tbody').html(tbody);
		});
	});
</script>