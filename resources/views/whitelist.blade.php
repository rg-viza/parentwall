@extends('layouts.app')
	
	@section('content')
		<div class="statuscontainer">
		@if($operation=="remove")
			@foreach ( $matches as $key => $value )
				<div class="statustitle"><span>{{ $value }}</span> <a href="/whtlst/remove/{{ $value }}"><img class="status" src="/images/remove.png" height='32' width='32'/></a></div>  
		    	@endforeach
		@elseif($operation=="manage")
			@foreach ( $links as $key => $value )
		        	<div class="statustitle"><a href="{{ $value  }}"><span>{{ $key }}</span></a></div>  
		    	@endforeach
		@elseif($operation=="approvelist")
			@foreach ( $userlist as $key => $value )
		        	<div class="statustitle"><a href="/whtlst/approveuserlist/{{ $value  }}"><span>{{ $value }}</span></a></div>  
		    	@endforeach
		@elseif($operation=="approveuserlist")
			@foreach ( $domainlist as $key => $value )
		        	<div class="statustitle"><a href="/whtlst/previewdomain/{{ $value  }}"><span>{{ $value }}</span></a></div>  
		    	@endforeach
		@elseif($operation=="previewdomain")
			<form name="addtowhitelist" action="/whtlst/approvesite" method="POST">
				{{ csrf_field() }}
				<fieldset>
				@foreach ( $filteredhostnames as $key => $value )
					<div class="statustitle"><label for="cbx{{ $value }}"><span>{{ $value }}</span></label><input class="status" id="cbx{{ $value }}" type="checkbox" name="domains[]" value="{{ $value  }}" checked/></div>
				@endforeach	
				</fieldset>		
				<input type="submit" value="Approve"/>
			</form>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		</div>
		<div class="statuscontainer" id="contentframe" name="contentframe" style="height:100%;width:100%;border-width:2px;border-color:black;">
			<iframe src="http://{{ $domain }}" style="height:100%;width:100%;" sandbox></iframe>
		@endif
		</div>
	@endsection
