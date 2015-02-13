 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      google.setOnLoadCallback(drawChart);

      function drawChart() {
        var today = new google.visualization.DataTable();
        today.addColumn('string', 'Topping');
        today.addColumn('number', 'Slices');
        today.addRows([
          ['Receipt', {{$data['today_in']}}],
          ['Expense', {{$data['today_out']}}],
        ]);

        var monthly = new google.visualization.DataTable();
        monthly.addColumn('string', 'Topping');
        monthly.addColumn('number', 'Slices');
        monthly.addRows([
          ['Receipt', {{$data['month_in']}}],
          ['Expense', {{$data['month_out']}}],
        ]);

		var weekly = google.visualization.arrayToDataTable(
			{{json_encode($data['chatData'],JSON_NUMERIC_CHECK)}}
		);

		var weeklyOptions = { title: 'Last Week Transations',colors: ['#3fcf7f','#d9534f']};

        // Set chart options
        var todayOptions = { 
        	legend: 'none',
        	title:'Today',
        	colors: ['#3fcf7f','#d9534f']
        };
        var monthlyOptions = { legend: 'none',title:'Monthly',colors: ['#3fcf7f','#d9534f']};

        // Instantiate and draw our chart, passing in some options.
        var todayDraw = new google.visualization.PieChart(document.getElementById('today'));
        todayDraw.draw(today, todayOptions);

        var monthlyDraw = new google.visualization.PieChart(document.getElementById('monthly'));
        monthlyDraw.draw(monthly, monthlyOptions);      

        var weeklyDraw = new google.visualization.LineChart(document.getElementById('weekly'));
  		weeklyDraw.draw(weekly, weeklyOptions);
      }
</script>

<div class="row">
	<div class="col-md-5">
		<div class="col-md-6">
			<div id="today"></div>
		</div>
		<div class="col-md-6">
			<div id="monthly"></div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="col-md-12">
			<div id="weekly"></div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<br/>
<div class="row">
	<div class="col-lg-12">
	<div class="col-md-12">
	<section class="panel">
            <div class="table-responsive">
				<table class="table b-t text-smal dataTables">
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
					@foreach($data['transations'] as $row)
					@if($row->type=='receipt')
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
					@endif
					@endforeach
					
					@foreach($data['transations'] as $row)
					@if($row->type=='expense')
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
					@endif
					@endforeach
				</tbody>
				<tfoot>
					<tr class="info">
						<th colspan="4">Total Amounts</th>
						<th>{{$total_in}}</th>
						<th>{{$total_out}}</th>
						<th>{{$total_out+$total_in}}</th>
						<th colspan="3"></th>
					</tr>
				</tfoot>
				</table>
			</div>
	</section>
</div>
</div>
</div>
</div>
<link rel="stylesheet" href="{{ URL::asset('js/datatables/jquery.dataTables.min.css') }}">
<script src="{{ URL::asset('js/datatables/jquery.dataTables.min.js') }}"></script>
<script>
	 $('.dataTables').DataTable({
		"bPaginate": false
    });
</script>