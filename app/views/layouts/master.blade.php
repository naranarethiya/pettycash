<!DOCTYPE html>
<html lang="en">
<head>
  <title>Petty cash management</title>
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
	<script>
		var base_url = "{{ URL::to('/') }}/";
	</script>

<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/script.js') }}"></script>
</body>
</html>