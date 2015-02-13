<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pettycash Management</title>
  <link href="{{ URL::asset('css/app.v2.css') }}"  rel="stylesheet">
  <link href="{{ URL::asset('css/font.css') }}" rel="stylesheet">
  <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
</head>
<body>
	@include("layouts.header")
	@include("navbar")
	
	<section id="content">
		<section class="main padder">
			<div class="clearfix"> <h4>{{$title}}</h4> </div>
			<div class="clearfix">
				@include("layouts.message")
			</div>
			<div class="row">
				{{$content}}
			</div>
		</section>
	</section>
	<input type="hidden" id="active_dates" value='{{Session::get('active_dates')}}' />
	<script>
		var base_url = "{{ URL::to('/') }}/";
	</script>


<!-- Modal -->
  <div class="modal fade" id="DailyReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Daily Report</h4>
        </div>
        <div class="modal-body">
			<form action="{{URL::to("PrintDailyReport")}}" class="form-horizontal" method="post" >
				<div class="form-group">
						<label class="col-xs-2 control-label">Date</label>
					  <div class="col-xs-6">
						{{Form::text('dailyDate',date('Y-m-d'),array('placeholder'=>'From Date','class'=>'form-control dailyDatepicker','data-date-format'=>'yyyy-mm-dd'))}}
					  </div>
					  <div class="col-xs-3">
					  	<input type="submit" class="btn btn-primary" Value="Submit" />
				  	</div>
				</div>
			</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<!-- End modal -->
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/script.js?ssd45dd') }}"></script>
</body>
</html>