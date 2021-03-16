#!/usr/bin/php -qn
<?php
	require('phpagi.php'); #Use the phpAGI library
	$AgentExt=$argv[1];

	$agi = new AGI(); #Create a new Asterisk::AGI object
	$as = new AGI_AsteriskManager('/etc/asterisk/phpagi.conf' );
	$agi -> answer();
	$res=$as->connect();
	$res=$as->Command('queue show');
	$lines=split("\n",$res['data']);
	$existsext=0;
	$numlines=count($lines);
	
		for($i=1;$i<=$numlines;++$i)
		{
			$pos=strpos($lines[$i],$AgentExt);
			if($pos==true)
			{
				$pos=strpos($lines[$i],'(Not in use)');
				if($pos==true)
				{
					$existsext=1; //avaiable not in use
				}
				$pos=strpos($lines[$i],'(paused) (Not in use) ');
				if($pos==true)
				{					
					$existsext=2;	//avaiable pause				
				}
				$pos=strpos($lines[$i],'(Available)');
				if($pos==true)
				{
					$existsext=3; //avaiable 
				}
 

				
			}
			
		}
		
		$agi->set_variable('Available',$existsext);// result
	
	$as->disconnect();
?>