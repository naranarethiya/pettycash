		<header id="header" class="navbar"> 
			<ul class="nav navbar-nav navbar-avatar pull-right"> 
				<li class="dropdown"> 
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
						<span class="hidden-xs-only">{{Auth::user()->name}}</span> 
						<span class="thumb-small avatar inline"><img src="images/user.png" class="img-circle"></span> 
						<b class="caret hidden-xs-only"></b> 
					</a> 
					<ul class="dropdown-menu pull-right">
						<li><a href="#">Profile</a></li>
						<li><a href="{{URL::to("logout")}}">Logout</a></li> 
					</ul> 
				</li> 
			</ul>
			<a class="navbar-brand" href="{{base_path()}}">first</a>
			
			<button type="button" class="btn btn-link pull-left nav-toggle visible-xs" data-toggle="class:slide-nav slide-nav-left" data-target="body"> 
				<i class="fa fa-bars fa-lg text-default"></i> 
			</button> 
		</header>
		