#!/usr/bin/php -q
<?php
require('phpagi.php');
require('QueryDatabase.php');
	$time_id=$argv[1];
	$call_id=$argv[2];
	$agent=$argv[3];
	$verb=$argv[4];
	$data1=$argv[5];
	$data2=$argv[6];
	$data3=$argv[7];
	//$agi=new AGI();
	//$agi -> answer();
	$SqlStr="INSERT INTO cc_mptelecom.queue_log(time_id,call_id,agent,verb,data1,data2,data3) 
			VALUES(UNIX_TIMESTAMP(NOW()),$call_id,$agent,$verb,$data1,$data2,$data3)";
	InsertData($SqlStr);
?>