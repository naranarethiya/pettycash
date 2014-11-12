<!DOCTYPE html>
<html lang="en">
<head>
  <title>Petty cash management</title>
  <link href="{{ URL::asset('css/app.v2.css') }}"  rel="stylesheet">
  <link href="{{ URL::asset('css/font.css') }}" rel="stylesheet">
  <script scr="{{ URL::asset('js/jquery.min.js')}}"></script>
</head>
<body>
  <!-- header -->
  <header id="header" class="navbar bg bg-black">
	<!--<a class="navbar-brand" href="#">first</a>-->
  </header><!-- / header -->

  <section id="content">
    <div class="main padder">
      <div class="row">
        <div class="col-lg-4 col-lg-offset-4 m-t-large">
          <section class="panel">
            <header class="panel-heading text-center">
              Sign in
            </header>
      			@foreach($errors->all() as $error)
              <div class="alert alert-danger">{{ $error }}</div>
      			@endforeach
      			 @if(Session::has('error'))
      				<div class="alert alert-danger">{{ Session::get('error') }}</div>
      			@endif
            {{ Form::open(array('url'=>URl::to('/login'), 'method'=>'POST',"class"=>"panel-body")) }}
              <div class="block">
                <label class="control-label">Email</label> 
				<input type="text" id="username" name="email" placeholder="Email" class="form-control">
              </div>

              <div class="block">
                <label class="control-label">Password</label> 
				<input type="password" name="password" id="Password" placeholder="Password"
                class="form-control">
              </div>

              <div class="checkbox">
              </div>
			  <input type="submit" class="btn btn-info" value="Sign in" />
             {{ Form::close() }}
          </section>
        </div>
      </div>
    </div>
  </section><!-- footer -->
</body>
</html>
