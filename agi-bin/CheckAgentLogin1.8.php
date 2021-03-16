#!/usr/bin/php -qn
<?php
	require('phpagi.php'); #Use the phpAGI library
	$AgentExt = $argv[1];

	$agi = new AGI(); #Create a new Asterisk::AGI object
	$as = new AGI_AsteriskManager('/etc/asterisk/phpagi.conf' );
	$agi -> answer();
	$res=$as->connect();
	$res=$as->Command('queue show');
	$lines=split("\n",$res['data']);
	
	$agentstatus=0;
	$isagent='';
	$numlines=count($lines);
		for($i=1;$i<=$numlines;++$i)
		{
		
			$pos=strpos($lines[$i],$AgentExt);
			if($pos==true)
			{
				/*
				$pos=strpos($lines[$i],'(Not in use)');
				if($pos==true)
				{
					$existsext=1; //avaiable not in use
				}
				$pos=strpos($lines[$i],'(paused) (Not in use) ');
				if($pos==true)
				{					
					$existsext=2;	//avaiable pause
					break;
				}
				$pos=strpos($lines[$i],'(Available)');
				if($pos==true)
				{
					$existsext=3; //avaiable 
				}
				*/
				$agentarr=split(' ',$lines[$i]);
				//print_r($agentarr);
				$numarr=count($agentarr);
				for($k=0;$k<$numarr;++$k)
				{
					$dt=$agentarr[$k];
					//print "\n agent: ".$agentarr[$k];
					//$pos2=strpos($agentarr[$k],'Agent/demo4');
					if(strpos($dt,'Agent/') !== false)
					{
						//print "\n agent: ".$agentarr[$k]." \n";
						$isagent=$agentarr[$k];
						break;
					}
				}
				break;
			}
			
		}
		if($isagent=='')$isagent=$AgentExt;
		$agi->set_variable('isagent',$isagent);// result
	
	$as->disconnect();
?>