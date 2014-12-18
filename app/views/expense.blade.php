<?php 
	$oldData=Input::old('amount.0');
?>
<div class="col-md-12">
<section class="panel">
	<header class="panel-heading">Money Out</header>
	<div id="formContainer">
	<form class="form-horizontal" method="post" action="{{URL::to('expense/add')}}" style="margin-top:20px" id="expeseForm">
		<!--<div class="form-group">
			 <label class="col-xs-3 control-label">Trans.ID</label>
			  <div class="col-xs-8">
				{{Form::text('id','20',array('class'=>'form-control','readonly'))}}
			  </div>
		</div> -->

		<div class="form-group">
			<div class="col-md-6">
				<label class="col-xs-2 control-label">Pay to <span class="text-danger">*</span></label>
				<div class="col-xs-8">
					{{Form::text('source',NULL,array('class'=>'form-control','required'))}}
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-xs-2 control-label">Branch <span class="text-danger">*</span></label>
			  <div class="col-xs-8">
			  	{{Form::select('brid',$data['branchCombo'],NULL,array('class'=>'form-control','required','pattern'=>'^[1-9][0-9]*$'))}}
			  </div>
			</div>
		</div>

		<a href="javascript:addRow();" style="color:green;margin-left:10px" title="Add transation"><i class="fa fa-plus fa-lg"></i> Add</a>
		<table class="table table-bordered" id="transContainer" style="margin:5px;width:98%">
			<thead>
				<tr>
					<th width="15%">Exp. Type <span class="text-danger">*</span></th>
					<th width="10%">Amount <span class="text-danger">*</span></th>
					<th width="10%">Payment <span class="text-danger">*</span></th>
					<th width="50%">Particular</th>
					<th width="10%">Bank</th>
					<th width="5%">#</th>
				</tr>
			</thead>
			<tbody>
				
				@if($oldData =='')
					<tr id="rowClon">
						<td>{{Form::select('exid[]',$data['expTypeCombo'],NULL,array('class'=>'form-control','required'))}}</td>
						<td>{{Form::text('amount[]','0',array('placeholder'=>'Amount','class'=>'form-control','required'))}}</td>
						<td>
								{{Form::select('payment_type[]',array('cash'=>'Cash','cheque'=>'Cheque'),NULL,array('class'=>'form-control','required'))}}
						</td>
						<td>
							{{Form::textarea('trans_note[]','',array('class'=>'form-control','rows'=>'2'))}}
						</td>
						<td>
							{{Form::select('bid[]',$data['bankCombo'],NULL,array('class'=>'form-control'))}}
						</td>
						<td><a href="javascript:none" onclick="removeRow(this);"  style="color:red" title="Remove"><i class="fa fa-times"></i></a></td>
					</tr>
				@else
					<?php 
						echo $count=count(Input::old('amount'));
						//dsm(Input::old("amount"));
						//dsm(Input::old("exid"));
					?>
					@for($i=0;$i<$count;$i++)
					<tr id="rowClon">
						<td>{{Form::select('exid[]',$data['expTypeCombo'],Input::old("exid.".$i),array('class'=>'form-control','required'))}}</td>
						<td>
							{{Form::text('amount[]','0',array('placeholder'=>'Amount','class'=>'form-control','required'))}}
						</td>
						<td>
							{{Form::select('payment_type[]',array('cash'=>'Cash','cheque'=>'Cheque'),Input::old("payment_type.".$i),array('class'=>'form-control','required'))}}
						</td>
						<td>
							{{Form::select('bid[]',$data['bankCombo'],Input::old("bid.".$i),array('class'=>'form-control'))}}
						</td>
						<td><a href="javascript:none" onclick="removeRow(this);"  style="color:red" title="Remove"><i class="fa fa-times"></i></a></td>
					</tr>
					@endfor
				@endif
			</tbody>
		</table>

		<div class="form-group">
			 <label class="col-xs-1 control-label">Note</label>
			<div class="col-xs-Form col-md-8">
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

<div class="col-md-12">
	<section class="panel">
		<header class="panel-heading">Last Expenses</header>
            <div class="table-responsive">
				<table class="table table-striped b-t text-small dataTables">
					<thead>
						<tr>
							<th>Pay to</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Branch</th>
							<th>Expense</th>
							<th>#</th>
						</tr>
					</thead>
				<tbody>
					@foreach($data['transations'] as $row)
					<tr id="tr{{$row->t_item_id}}">
						<td>{{$row->source}}</td>
						<td>{{$row->amount}}</td>
						<td>{{formatDate($row->date,'d, M')}}</td>
						<td>{{$row->branche}}</td>
						<td>{{$row->expense_type}}</td>
						<td>
							<a target="_blank" title="Print" href="{{URL::to("printDebitVoucher/".$row->tid)}}"><i class="fa fa-print"></i></a>
							@if($row->date==date('Y-m-d'))
								<a title="Delete" onclick="deleteTransation('{{$row->t_item_id}}')"><i class="fa fa-trash-o"></i></a>
							@endif
						</td>
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
	var clonRow="<tr>"+$('#rowClon').html()+"</tr>";

	function addRow() {
		$('#transContainer tbody').append(clonRow);
	}

	function removeRow(ele) {
		$(ele).parent().parent().remove();
	}

	/*$('input[name="payment_type"]').change(function() {
		var val=$(this).val();
		if(val=='cash') {
			$('#bankCombo').hide();
		}
		else {
			$('#bankCombo').show();
		}
	});*/

	$(document).ready(function() {
		var val=$('input[name="payment_type"]:checked').val();
		if(val=='cheque') {
			$('#bankCombo').show();
		}
		else {
			$('#bankCombo').hide();
		}
	});

	$('#expeseForm').submit(function(e) {
		var cnt=0;

		$('#expeseForm text,email,number[required="required"]').each(function() {
			var val=$(this).val();
			if(val=='0' || val=='') {
				$(this).addClass('parsley-error');
				cnt=cnt+1;
			}
			else {
				$(this).removeClass('parsley-error');
			}
		});

		$('#expeseForm select[required="required"]').each(function() {
			var val=$(this).val();
			if(val=='0' || val=='') {
				$(this).addClass('parsley-error');
				cnt=cnt+1;
			}
			else {
				$(this).removeClass('parsley-error');
			}
		});

		$('select[name^="payment_type"]').each(function() {
			var payment=$(this).val();
			var bEle=$(this).parent().parent().find('[name^="bid"]');
			var val=$(bEle).val();

			if(payment == 'cheque') {
				if(val=='0' || val=='') {
					$(bEle).addClass('parsley-error');
					cnt=cnt+1;
				}
				else {
					$(bEle).removeClass('parsley-error');
				}		
			}
			else {
					$(bEle).removeClass('parsley-error');
			}
		});


		if(cnt > 0) {
			alert("Please Fix the errors");
			return false;
		}
		else {
			return true;
		}
	});
</script>
