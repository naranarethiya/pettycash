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
		<header class="panel-heading">Last Transations</header>
            <div class="table-responsive">
				<table class="table b-t text-smal dataTables">
					<thead>
						<tr>
							<th>Source/Pay to</th>
							<th>Amount</th>
							<th>Balance</th>
							<th>Date</th>
							<th>Trans. Type</th>
							<th>Reason/Detail</th>
						</tr>
					</thead>
				<tbody>
					@foreach($data['transations'] as $row)
					<tr class="@if($row->type=='expense') danger @else success @endif">
						<td>{{ucwords($row->source)}}</td>
						<td>{{$row->amount}}</td>
						<td>{{$row->balance}}</td>
						<td>{{$row->date}}</td>
						<td>{{ucwords($row->type)}}</td>
						<td>{{$row->description}}</td>
					</tr>
					@endforeach
					@if(count($data) < 1)
						<tr>
							<td colspan="6">No data found</td>
						</tr>
					@endif
				</tbody>
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
        "scrollY": "220px",
        "bsort": true,
		"bPaginate": false
    });
</script>