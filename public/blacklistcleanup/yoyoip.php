<?php
	$yoyoip = file('/srv/parentwall/public/blacklistsraw/yoyoip');
	$display = false;
	foreach($yoyoip as $idx=>$line)
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
