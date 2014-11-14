	<!-- nav --> 
	<nav id="nav" class="nav-primary hidden-xs nav-vertical"> 
		<ul class="nav affix-top" data-spy="affix" data-offset-top="50"> 
			<li><a href="{{URL::to('/dashboard')}}"><i class="fa fa-dashboard fa-lg"></i><span>Dashboard</span></a></li>
			<li><a href="{{URL::to('/transations/receipt')}}"><i class="fa fa-sign-in fa-lg"></i><span>Money In</span></a></li>
			<li><a href="{{URL::to('/transations/expense')}}"><i class="fa fa-reply fa-lg"></i><span>Money Out</span></a></li> 
			<li class="dropdown-submenu">
				<a href=""><i class="fa fa-list-alt fa-lg"></i><span>Reports</span></a>
				<ul class="dropdown-menu"> 
					<li><a href="{{URL::to('report')}}">Cash in Hand</a></li> 
					<li><a href="">Expense</a></li> 
					<li><a href="">Cash Receipt</a></li> 
					<li><a href="">Closign Balanse</a></li> 
					<li><a href="">Statement</a></li> 
				</ul> 
			</li>
			<li class="dropdown-submenu"> 
				<a href=""><i class="fa fa-link fa-lg"></i><span>Settings</span></a> 
				<ul class="dropdown-menu"> 
					<li><a href="">Company</a></li> 
					<li><a href="">Branch</a></li> 
					<li><a href="">Expense Type</a></li> 
				</ul> 
			</li> 
		</ul>
	</nav>