#!/usr/bin/php -q
<?php
 require('phpagi.php'); #Use the phpAGI library
 $Cusnumber=$argv[1];
 $agent = "";
 $AgentExten = "";
 $agi = new AGI(); #Create a new Asterisk::AGI object
 $as = new AGI_AsteriskManager('/etc/asterisk/phpagi.conf' );
 $agi -> answer();
 $res=$as->connect();
 $res=$as->Command('queue show');
 if($Cusnumber != ""){  
  //connect database
  $servername = "192.168.36.187";
  $username = "mpcc";
  $password = "mpcc";
  $dbname = "cc_mptelecom";

  // Create connection
  $conn = mysql_connect($servername, $username, $password);
  mysql_select_db($dbname, $conn);
  // Check connection
  if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
  } 
  //select database
  $sql = "select GROUP_CONCAT(case LEFT(verb,8) when 'COMPLETE' then agent end) as agent from queue_log  GROUP BY call_id
		HAVING GROUP_CONCAT(data2) like '%$Cusnumber%' 
		and GROUP_CONCAT(verb) like '%COMPLETE%'
		ORDER BY min(time_id) DESC 
		limit 0,1";
  $result = mysql_query($sql, $conn);
  
  if (mysql_num_rows($result) > 0) {	   
	   while($row = mysql_fetch_assoc($result)) {
			$agent = trim($row["agent"], " "); 
	   }
  } 
  mysql_close($conn);
  
  if($agent != ""){
	   if (strpos($res['data'],$agent) > 0)
	   {
			$temp = substr($res['data'],strpos($res['data'], $agent), strlen($res['data']));			
			$AgentExten = substr($temp,strpos($temp,"(") + 1,strpos($temp,"from") - strpos($temp,"(") - 1 );
			$AgentExten = trim($AgentExten," ");  
			
	   }	   
   }
 }
 
 $agi->set_variable('AgentExten',$AgentExten);// result
 $agi->set_variable('AgentName',$agent);// result
 $agi->set_variable('AgentMobile','0936471187');// result
 
 
 $as->disconnect();
?>