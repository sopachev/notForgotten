<?php

	include('bungieNet.php');
	$bungieNet = new bungieNet();
	
	if($input = fopen('input.log', 'r'))
	{
		if($output = fopen('output.log', 'w'))
		{
			while(($line = fgets($input)) !== false)
			{
				$nick = trim($line);
				$result = $nick.' - '.($bungieNet->checkNotForgotten($nick) ? 'has' : 'no').PHP_EOL;
				echo $result;
				fwrite($output, $result);
			}
			fclose($output);
		}
		else echo "can't create output.log";
		fclose($input);
	}
	else echo 'input.log not found';

?>