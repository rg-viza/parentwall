<?php
	$yoyohostname = file('/srv/parentwall/public/blacklistsraw/yoyohostname');
	$display = false;
	foreach($yoyohostname as $idx=>$line)
	{
		if(empty($line)||preg_match("/\</", $line))
		{
			continue;
		}
		else
		{
			echo $line;
		}
	}
		
?>
