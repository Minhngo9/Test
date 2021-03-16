#!/usr/bin/php -qn
<?php
	require('phpagi.php'); #Use the phpAGI library
	$AgentExt=$argv[1];

	$agi = new AGI(); #Create a new Asterisk::AGI object
	$as = new AGI_AsteriskManager('/etc/asterisk/phpagi.conf' );
	$agi -> answer();
	$res=$as->connect();
	$res=$as->Command('queue show');
	//$lines=split("\n",$res['data']);
	$result;
	//$numlines=count($lines);
	if (strpos($res['data'],$AgentExt))
	{
		$temp = substr($res['data'],0,strpos($res['data'], $AgentExt));
		$result = substr($temp,strripos($temp,"\n") + 1,strlen($temp));
		$result = trim($result," (");
		//$result = strripos($temp,"\n");
	}
		// for($i=1;$i<=$numlines;++$i)
		// {
			// $pos=strpos($lines[$i],$AgentExt);
			// if($pos==true)
			// {
				// $result = strstr($lines[$i],$AgentExt,true)
 			// }
		// }
		
		
		$agi->set_variable('AgentID',$result);// result
	
	$as->disconnect();
?>