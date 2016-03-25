@extends('layouts.app')
	@section('content')
		@foreach ( $matches as $key => $value )
            		{{ $value }} <br/> 
    		@endforeach
	@endsection
