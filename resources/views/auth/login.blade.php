@extends('layouts.app')
	@section('content')
 	<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
      	{!! csrf_field() !!}
           	<div class="title"><span>Login to</span> <p/> ParentWall <p/> <span>version .01</span></div>
	   	<div class="statuscontainer">
			<div class="statustitle"><span>Email: </span>
        	                       <input type="email" class="form-control" name="email" value="{{ old('email') }}">
			</div>
			@if ($errors->has('email'))
				<div class="statustitle">
					<div class="error">
						<span>
                                	      		{{ $errors->first('email') }}
						</span>
					</div>
				</div>
			@endif
			<div class="statustitle"><span>Password:</span>
				<input type="password" class="form-control" name="password">
			</div>
			@if ($errors->has('password'))
				<div class="statustitle">
					<div class="error">
						<span>
							{{ $errors->first('password') }}
						</span>
					</div>
				</div>
			@endif
			<div class="statustitle"><span>Remember Me: </span>
        	        	<input type="checkbox" name="remember">
			</div>
			<div class="statustitle">
				<input type="submit" value="Log In" class="formsubmit">
			</div>
			<div class="statustitle">
				<ul class="nav navbar-nav navbar-right">
		        	            <!-- Authentication Links -->
				@if (Auth::guest())
					<li>
						<a href="{{ url('/register') }}">Register</a>
					</li>
				@else
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							{{ Auth::user()->name }} <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
						<ul>
					</li>
				@endif
				</ul>
			</div>
	    	</div>
	</form>
	@endsection
