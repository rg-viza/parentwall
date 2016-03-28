@extends('layouts.app')
	@section('content')
           		<div class="title"><span>Welcome to</span> <p/> ParentWall <p/> <span>version .01</span></div>
	   		<div class="statuscontainer">
				<div class="statustitle"><span>Firewall:</span>
					@if(empty($firewallStatus))
						<img class="status" src="/images/transparent.png" height='32' width='32'/>
						<a href="/svcctl/firewall/Start"><img class="status" src="/images/playgreen.png" height='32' width='32'/></a>
						<img class="status" src="/images/cancel.png" height='32' width='32'/>
					@else
						<a href="/svcctl/firewall/Stop"><img class="status" src="/images/remove.png" height='32' width='32'/></a>
						<a href="/svcctl/firewall/Restart"><img class="status" src="/images/refresh.png" height='32' width='32'/></a>
						<img class="status" src="/images/validgreen.png" height='32' width='32'/>
					@endif
				</div>
				<div class="statustitle"><span>Proxy:</span>
					@if(empty($tinyproxyStatus))
						<img class="status" src="/images/transparent.png" height='32' width='32'/>
						<a href="/svcctl/proxy/Start"><img class="status" src="/images/playgreen.png" height='32' width='32'/></a>
						<img class="status" src="/images/cancel.png" height='32' width='32'/>
					@else
						<a href="/svcctl/proxy/Stop"><img class="status" src="/images/remove.png" height='32' width='32'/></a>
						<a href="/svcctl/proxy/Restart"><img class="status" src="/images/refresh.png" height='32' width='32'/></a>
						<img class="status" src="/images/validgreen.png" height='32' width='32'/>
					@endif
				</div>
				<p/>
				<div class="statustitle"><span>Internet:</span>
					@if(empty($internetStatus))
						<img class="status" src="/images/transparent.png" height='32' width='32'/>
						<img class="status" src="/images/playgreen.png" height='32' width='32'/>
						<img class="status" src="/images/cancel.png" height='32' width='32'/>
					@else
						<img class="status" src="/images/remove.png" height='32' width='32'/>
						<img class="status" src="/images/refresh.png" height='32' width='32'/>
						<img class="status" src="/images/validgreen.png" height='32' width='32'/>
					@endif
				</div>
				<p/>
				<div class="statustitle">
					<ul class="nav navbar-nav navbar-right">
		        	            <!-- Authentication Links -->
		        	            @if (!$isLoggedIn)
		        	                <li><a href="{{ url('/login') }}">Login</a></li>
		        	                <li><a href="{{ url('/register') }}">Register</a></li>
		        	            @else
		        	                <li class="dropdown">
		        	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
		        	                    	Logged In as {{ Auth::user()->name }} <span class="caret"></span>
		        	                    </a>
							<p/>&nbsp;	
			                            <ul class="dropdown-menu" role="menu">
							<li><a href="/whtlst/manage">Manage</a></li>
			                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
			                            </ul>
			                        </li>
			                    @endif
					</ul>
				</div>
			</div>
	@endsection
