<?php
	$dbblacklist = file('/srv/parentwall/public/blacklistsraw/db.blacklist');
	$display = false;
	foreach($dbblacklist as $idx=>$line)
	{
		if(preg_match('/\*/', $line) || preg_match('/TXT/', $line) || preg_match('/MX/', $line))
		{
			continue;
		}
		if($line == "\n")
		{
			continue;
		}
		$arrLine = explode("\t", $line);
		echo trim($arrLine[0], ".")."\n";		
	}
		
?>
