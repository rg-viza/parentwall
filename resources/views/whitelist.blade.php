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
		            		<div class="statustitle"><a href="/whtlst/previewdomain/{{ $value  }}"><span>{{ $value }}</span></a></div>  
		    		@endforeach
			</div>
		@elseif($operation=="previewdomain")
			<?php
				$links = array();
				$html = file_get_contents("http://".$domain);
				$regexp = "<a\s[^>]*href=([\"\']??)([^\\1 >]*?)\\1[^>]*>";
				preg_match_all("/$regexp/Siu", $html, $matches);
				foreach($matches[0] as $idx=>$a)
				{
					if(preg_match("/http/",$a))
					{
						$arrLink1 = explode('href=', $a);
						$arrLink2 = explode(" ", $arrLink1[1]);
						$arrLink3 = explode(">", $arrLink2[0]);
						$arrLink4 = explode("/",$arrLink3[0]);
						$hostname = preg_replace("/[^\w\d\.\-\_]/","",$arrLink4[2]);
						$item = $hostname;
						$links[]=$item;
					}
				}
				preg_match_all('/<img[^>]+>/i',$html, $images); 
				foreach($images[0] as $idx=>$a)
				{
					if(preg_match("/http/",$a))
					{
						$arrLink1 = explode('src=', $a);
						$arrLink2 = explode(" ", $arrLink1[1]);
						$arrLink3 = explode(">", $arrLink2[0]);
						$arrLink4 = explode("/",$arrLink3[0]);
						$hostname = preg_replace("/[^\w\d\.\-\_]/","",$arrLink4[2]);
						$item = $hostname;
						$links[]=$item;
					}
				}
				preg_match_all('/<script[^>]+>/i',$html, $images); 
				foreach($images[0] as $idx=>$a)
				{
					if(preg_match("/http/",$a))
					{
						$arrLink1 = explode('src=', $a);
						$arrLink2 = explode(" ", $arrLink1[1]);
						$arrLink3 = explode(">", $arrLink2[0]);
						$arrLink4 = explode("/",$arrLink3[0]);
						$hostname = preg_replace("/[^\w\d\.\-\_]/","",$arrLink4[2]);
						$item = $hostname;
						$links[]=$item;
					}
				}
				preg_match_all('/<link[^>]+>/i',$html, $images); 
				foreach($images[0] as $idx=>$a)
				{
					if(preg_match("/http/",$a))
					{
						$arrLink1 = explode('href=', $a);
						$arrLink2 = explode(" ", $arrLink1[1]);
						$arrLink3 = explode(">", $arrLink2[0]);
						$arrLink4 = explode("/",$arrLink3[0]);
						$hostname = preg_replace("/[^\w\d\.\-\_]/","",$arrLink4[2]);
						$item = $hostname;
						$links[]=$item;
					}
				}
                                $adserverblacklist = file_get_contents('http://www.volkerschatz.com/net/adpaths');
                                echo $adserverblacklist;
				$links = array_values(array_unique($links));
				sort($links);
				print_r($links);
			?>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
			<div class="statuscontainer" id="contentframe" name="contentframe" style="height:100%;width:100%;border-width:2px;border-color:black;">
				<iframe src="http://{{ $domain }}" style="height:100%;width:100%;"></iframe>
			</div>
		@endif
	@endsection
