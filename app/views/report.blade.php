<div class="col-md-12">
<section class="panel">
	<header class="panel-heading">Search</header>
	    <div class="table-responsive" style="padding:10px;text-align:center;">
			{{Form::open(array('action'=>'ReportController@index','class'=>'form-inline','method'=>'get'))}}
				  <div class="form-group">
					{{Form::label('type','Trans. Type')}}
					{{Form::select('type',array('all'=>'All','expense'=>'Money Out','receipt'=>'Money In'),Input::get('type','all'),array('class'=>'form-control'))}}
				  </div>
				<div class="form-group">
					{{Form::label('from','From date')}}
					{{Form::text('from',Input::get('from'),array('class'=>'form-control datepicker','id'=>'from_date','placeholder'=>'From date','data-date-format'=>'yyyy-mm-dd','readonly'))}}
			  	</div>
			  	<div class="form-group">
					{{Form::label('from','To date')}}
					{{Form::text('to',Input::get('to'),array('class'=>'form-control datepicker','id'=>'to_date','placeholder'=>'to date','data-date-format'=>'yyyy-mm-dd','readonly'))}}

				</div>
				  <div class="form-group" style="margin-left:20px">
				  	{{Form::submit('SEARCH',array('class'=>'btn btn-sm btn-info','style'=>'padding:7px 23px'))}}
					<a href="{{URL::to('report')}}" class="btn btn-danger">RESET</a>
				  </div>
			{{Form::close()}}
		</div>
</section>
</div>

<!-- Table -->
<div class="col-md-12">
	<section class="panel">
		<header class="panel-heading">Data</header>
	    <div class="table-responsive">
    		<table class="table table-striped b-t text-small dataTable">
					<thead>
						<tr>
							<th>Date</th>
							<th>Bill/Ref No.</th>
							<th>Reason/Detail</th>
							<th>Amount</th>
						</tr>
					</thead>
				<tbody>
					@foreach($data as $row)
					<tr>
						<td>{{formatDate($row->date,'d-m-Y')}}</td>
						<td>{{$row->ref_no}}</td>
						<td>{{$row->description}}</td>
						<td>{{$row->amount}}</td>
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