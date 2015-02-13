<div class="col-md-12">
	<section class="panel">
		<header class="panel-heading">
			<div class="col-md-4" style="text-align:left">
		        <button class="btn btn-success" id="export">Export</button>
		        <a class="btn btn-sm btn-info" data-toggle="modal" href="#myModal">Modify Search</a>
			</div>
			<div class="col-md-4" style="text-align:center">
				<h3 style="margin:5px" id="export">Results</h3>
			</div>
		</header>
		<div class="table-responsive">
			<table class="table dataTables">
				<thead>
					<tr>
						<th>Date</th>
						<th>Source/Pay to</th>
						<th>Branch</th>
						<th>Expense</th>
						<th>Credit</th>
						<th>Debit</th>
						<th>Balance</th>
						<th>Cr/Dr Total</th>
						<th>Payment</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$total_in=0; 
						$total_out=0; 
					?>
					@if(count($data['transations'] > 0))
					@foreach($data['transations'] as $row)

					<tr class="@if($row->type=='expense') danger @else success @endif" id="tr{{$row->t_item_id}}">
						<td>{{formatDate($row->date,'d-m-Y')}}</td>
						<td>{{$row->source}}</td>
						<td>{{$row->branche}}</td>
						<td>{{$row->expense_type}}</td>
						<td>@if($row->type=='receipt') {{$row->amount}} <?php $total_in+=$row->amount;  ?> @else 0 @endif</td>
						<td>@if($row->type=='expense') {{$row->amount}} <?php $total_out+=$row->amount;  ?> @else 0 @endif</td>
						<td>{{$row->balance}}</td>
						<td>{{$row->amount}}</td>
						<td>{{$row->payment_type}}</td>
						<td>
							@if($row->type=='expense')
								<a target="_blank" href="{{URL::to("printDebitVoucher/".$row->tid)}}"><i class="fa fa-print"></i> Print</a>
							@endif
							@if($row->date==date('Y-m-d'))
								<a href="#" onclick="deleteTransation('{{$row->t_item_id}}')" ><i class="fa fa-trash-o"></i> Del</a>
							@endif
						</td>
					</tr>
					@endforeach
					@endif
				</tbody>
				<tfoot>
					<tr class="info">
						<th colspan="4">Total Amounts</th>
						<th>{{$total_in}}</th>
						<th>{{$total_out}}</th>
						<th></th>
						<th>{{$total_out+$total_in}}</th>
						<th colspan="3"></th>
					</tr>
				</tfoot>
			</table>
	</section>
</div>

<link rel="stylesheet" href="{{ URL::asset('js/datatables/jquery.dataTables.min.css') }}">
<script src="{{ URL::asset('js/datatables/jquery.dataTables.min.js') }}"></script>

<script>
	 $('.dataTables').DataTable({
        "bsort": true,
		"bPaginate": false,
		"order": []
    });

</script>

<!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Search form</h4>
        </div>
        <div class="modal-body">
			@include('searchForm')
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<!-- End modal -->

<script>
	$('#export').click(function() {
		$('#searchSubmit').val('export');
		$('#searchSubmit').click();
		$('#searchSubmit').val('Submit');
	});
</script>
