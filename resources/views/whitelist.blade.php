@extends('layouts.app')
	@section('content')
	<div class="statuscontainer">
		@foreach ( $matches as $key => $value )
            		<div class="statustitle"><span>{{ $value }}</span> <a href="/whtlst/remove/{{ $value }}"><img class="status" src="/images/remove.png" height='32' width='32'/></a></div>  
    		@endforeach
	</div>
	@endsection
