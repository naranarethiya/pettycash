<div class="col-md-12">
	<section class="panel">
		<header class="panel-heading">
			<div class="col-md-4" style="text-align:left">
		        <button class="btn btn-success" id="export">Export</button>
		        <a class="btn btn-sm btn-info" data-toggle="modal" href="#myModal">Modify Search</a>
			</div>
			<div class="col-md-4" style="text-align:center">
				<h3 style="margin:5px" id="export">Search Results</h3>
			</div>
		</header>
		<div class="table-responsive">
			<table class="table dataTables">
				<thead>
					<tr>
						<th>Date</th>
						<th>Chqeue No.</th>
						<th>Bank</th>
						<th>Particular</th>
						<th>Credit</th>
						<th>Debit</th>
						<th>Balance</th>
						<th>Cr/Dr Total</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$credit=0; 
						$debit=0; 
					?>
					@if(count($data['transations'] > 0))
					@foreach($data['transations'] as $row)

					<tr class="@if($row->type=='debit') danger @else success @endif" id="tr{{$row->id}}">
						<td>{{$row->date}}</td>
						<td>{{$row->ref_no}}</td>
						<td>{{$row->bank}}</td>
						<td>{{$row->note}}</td>
						<td>@if($row->type=='credit') {{$row->amount}} <?php $credit+=$row->amount;  ?> @else 0 @endif</td>
						<td>@if($row->type=='debit') {{$row->amount}} <?php $debit+=$row->amount;  ?> @else 0 @endif</td>
						<td>{{$row->balance}}</td>
						<td>{{$row->amount}}</td>
						<td>
							<a href="#" onclick="deleteBankTransation('{{$row->id}}')" ><i class="fa fa-trash-o"></i> Del</a>
						</td>
					</tr>
					@endforeach
					@endif
				</tbody>
				<tfoot>
					<tr class="info">
						<th colspan="4">Total Amounts</th>
						<th>{{$credit}}</th>
						<th>{{$debit}}</th>
						<th></th>
						<th>{{$credit+$debit}}</th>
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
          <h4 class="modal-title">Modify Search</h4>
        </div>
        <div class="modal-body">
			@include('bankBookSearchForm')
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
