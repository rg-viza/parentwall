@extends('layouts.app')
	
	@section('content')
		@if($operation=="remove")
			<div class="statuscontainer">
				@foreach ( $matches as $key => $value )
		            		<div class="statustitle"><span>{{ $value }}</span> <a href="/whtlst/remove/{{ $value }}"><img class="status" src="/images/remove.png" height='32' width='32'/></a></div>  
		    		@endforeach
			</div>
		@elseif($operation=="manage")
			<div class="statuscontainer">
				@foreach ( $links as $key => $value )
		            		<div class="statustitle"><a href="{{ $value  }}"><span>{{ $key }}</span></a></div>  
		    		@endforeach
			</div>
		@elseif($operation=="approvelist")
			<div class="statuscontainer">
				@foreach ( $userlist as $key => $value )
		            		<div class="statustitle"><a href="/whtlst/approveuserlist/{{ $value  }}"><span>{{ $value }}</span></a></div>  
		    		@endforeach
			</div>
		@elseif($operation=="approveuserlist")
			<div class="statuscontainer">
				@foreach ( $domainlist as $key => $value )
		            		<div class="statustitle"><a href="/whtlst/approvedomain/{{ $value  }}"><span>{{ $value }}</span></a></div>  
		    		@endforeach
			</div>
		@endif
	@endsection
