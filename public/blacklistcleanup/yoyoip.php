<?php
	$yoyoip = file('/srv/parentwall/public/blacklists/yoyoip');
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
