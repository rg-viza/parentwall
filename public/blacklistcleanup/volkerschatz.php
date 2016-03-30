<?php
	$volkerschatz = file('/srv/parentwall/public/blacklistsraw/volkerschatz');
	$display = false;
	foreach($volkerschatz as $idx=>$line)
	{
		$arrLine = explode('/', $line);
		if(empty($arrLine[1]))
		{
			continue;
		}
		else
		{
			echo $arrLine[1]."\n";
		}
	}
		
?>
