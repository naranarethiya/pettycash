<div class="row">
	<div class="col-md-6">
		<div class="col-md-4">
		  <section class="panel">
			<header class="panel-heading bg-white">
				<div class="text-center h5"> 
					<strong>Cash in hand</strong>
				</div>
			</header>
			<div class="panel-body pull-in text-center">
			  <div class="inline">
				<div>
					<span class="h2" style="margin-left:10px;margin-top:10px;display:inline-block">
						{{$cash_in_hand}}
					</span>
				</div>
			  </div>
			</div>
		  </section>
		</div>
		<div class="col-md-4">
		  <section class="panel">
			<header class="panel-heading bg-white">
				<div class="text-center h5"> 
					<strong>Today Money Out</strong>
				</div>
			</header>
			<div class="panel-body pull-in text-center">
			  <div class="inline">
				<div>
					<span class="h2" style="color:#DF3737;margin-left:10px;margin-top:10px;display:inline-block">
						{{$data['today_out']}}
					</span>
				</div>
			  </div>
			</div>
		  </section>
		</div>

		<div class="col-md-4">
		  <section class="panel">
			<header class="panel-heading bg-white">
				<div class="text-center h5"> 
					<strong>Today Money In</strong>
				</div>
			</header>
			<div class="panel-body pull-in text-center">
			  <div class="inline">
				<div>
					<span class="h2 text-success" style="margin-left:10px;margin-top:10px;display:inline-block">
						{{$data['today_in']}}
					</span>
				</div>
			  </div>
			</div>
		  </section>
		</div>
		<div class="col-md-4">
		  <section class="panel">
			<header class="panel-heading bg-white">
				<div class="text-center h5"> 
					<strong>Monthly Money Out</strong>
				</div>
			</header>
			<div class="panel-body pull-in text-center">
			  <div class="inline">
				<div>
					<span class="h2" style="margin-left:10px;margin-top:10px;display:inline-block">
						{{$data['month_out']}}
					</span>
				</div>
			  </div>
			</div>
		  </section>
		</div>
		<div class="col-md-4">
		  <section class="panel">
			<header class="panel-heading bg-white">
				<div class="text-center h5"> 
					<strong>Monthly Money In</strong>
				</div>
			</header>
			<div class="panel-body pull-in text-center">
			  <div class="inline">
				<div>
					<span class="h2" style="margin-left:10px;margin-top:10px;display:inline-block">
						{{$data['month_in']}}
					</span>
				</div>
			  </div>
			</div>
		  </section>
		</div>
	</div>
	<div class="col-md-6">
	<section class="panel">
		<header class="panel-heading">Last Transations</header>
            <div class="table-responsive">
				<table class="table table-striped b-t text-small dataTable">
					<thead>
						<tr>
							<th>Date</th>
							<th>Trans. Type</th>
							<th>Reason/Detail</th>
							<th>Amount</th>
							<th>Balace</th>
						</tr>
					</thead>
				<tbody>
					@foreach($data['transations'] as $row)
					<tr>
						<td>{{$row->date}}</td>
						<td>{{ucwords($row->type)}}</td>
						<td>{{$row->description}}</td>
						<td>{{$row->amount}}</td>
						<td>{{$row->balance}}</td>
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