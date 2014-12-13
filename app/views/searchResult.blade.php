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
						<th>Trans. ID</th>
						<th>Date</th>
						<th>Source/Pay to</th>
						<th>Branch</th>
						<th>Amount</th>
						<th>Expense</th>
						<th>Payment</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($data['transations'] > 0))
					@foreach($data['transations'] as $row)

					<tr class="@if($row->type=='expense') danger @else success @endif" id="tr{{$row->t_item_id}}">
						<td>Trans{{$row->tid}}</td>
						<td>{{$row->date}}</td>
						<td>{{$row->source}}</td>
						<td>{{$row->branche}}</td>
						<td>{{$row->amount}}</td>
						<td>{{$row->expense_type}}</td>
						<td>{{$row->payment_type}}</td>
						<td>
							@if($row->type=='expense')
								<a target="_blank" href="{{URL::to("printDebitVoucher/".$row->tid)}}"><i class="fa fa-print"></i> Print</a>
							@endif
							@if($row->date==date('Y-m-d'))
								<a onclick="deleteTransation('{{$row->t_item_id}}')" href="#"><i class="fa fa-trash-o"></i> Del</a>
							@endif
						</td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
	</section>
</div>

<link rel="stylesheet" href="{{ URL::asset('js/datatables/jquery.dataTables.min.css') }}">
<script src="{{ URL::asset('js/datatables/jquery.dataTables.min.js') }}"></script>

<script>
	 $('.dataTables').DataTable({
        "scrollY": "350px",
        "bsort": true,
		"bPaginate": false
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
	});
</script>
