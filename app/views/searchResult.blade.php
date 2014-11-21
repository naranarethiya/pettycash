<div class="col-md-12">
	<section class="panel">
		<header class="panel-heading">
			<div class="col-md-4" style="text-align:left">
		        <a href="" class="btn btn-success">Export All</a>
		        <a class="btn btn-sm btn-info" data-toggle="modal" href="#myModal">Modify Search</a>
			</div>
			<div class="col-md-4" style="text-align:center">
				<h3 style="margin:5px">Results</h3>
			</div>
		</header>
		<div class="table-responsive">
			<table class="table table-striped dataTables">
				<thead>
					<tr>
						<th>Trans. ID</th>
						<th>Trnas. Type</th>
						<th>Branch</th>
						<th>Date</th>
						<th>Amount</th>
						<th>Source/Pay to</th>					
						<th>Ref. No.</th>
						<th>Expense Type</th>
						<th>Payment Type</th>
						<th>Note</th>
					</tr>
				</thead>
				<tbody>
					@if(count($data['transations'] > 0))
					@foreach($data['transations'] as $row)
					<tr>
						<td>{{$row->tid}}</td>
						<td>{{$row->type}}</td>
						<td>{{$row->branche}}</td>
						<td>{{$row->date}}</td>
						<td>{{$row->amount}}</td>
						<td>{{$row->source}}</td>
						<td>{{$row->ref_no}}</td>
						<td>{{$row->expense_type}}</td>
						<td>{{$row->payment_type}}</td>
						<td>{{$row->note}}</td>
					</tr>
					@endforeach
					@endif;
				</tbody>
			</table>
	</section>
</div>

<link rel="stylesheet" href="{{ URL::asset('js/datatables/jquery.dataTables.min.css') }}">
<script src="{{ URL::asset('js/datatables/jquery.dataTables.min.js') }}"></script>

<script>
	 $('.dataTables').DataTable({
        "scrollY": "330px",
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
          <h4 class="modal-title">Modal title</h4>
        </div>
        <div class="modal-body">
			@include('searchForm')
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<!-- End modal -->
