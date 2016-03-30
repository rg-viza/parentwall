<?php
	$dansadblacklist = file('/srv/parentwall/public/blacklistsraw/dansadblacklist');
	$display = false;
	foreach($dansadblacklist as $idx=>$line)
	{
		if(preg_match('/\#/', $line))
		{
			continue;
		}
		echo $line;
	}
		
?>
