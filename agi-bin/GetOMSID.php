#!/usr/bin/php -q
<?php
require('phpagi.php'); #Use the phpAGI library
$agi = new AGI(); #Create a new Asterisk::AGI object
$phone=$argv[1];
	$pos=strpos($phone,'_');
	if($pos==true)
	{
		list($dphone, $idoms) = split('[_]', $phone);
		$agi->set_variable('dphone',"$dphone");
		$agi->set_variable('idoms',"$idoms");
	}
	else 
	{
		$agi->set_variable('dphone',"$phone");
		$agi->set_variable('idoms',"");
	}
?>