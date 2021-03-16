#!/usr/bin/php -q
<?php
require('phpagi.php');

$callerID = $argv[1];		// so dien thoai goi len
$pathIntro=$argv[2];   		// duong dan file gioi thieu
$agi = new AGI();
$agi -> answer();

//variable connect to database
	$host='localhost';
	$user='root';
	$pass='rootmp2013';
	//Print "Create Connect Database\n";

$connect = mysql_connect($host, $user, $pass) or
                    die ("Lỗi kết nối, kiểm tra lại việc kết nối đến server.");

					mysql_query("SET CHARACTER SET utf8");
                mysql_query("SET SESSION collation_connection ='utf8_general_ci'") or die (mysql_error());
					
					mysql_select_db("asterisk");
//$query="Select name, position, kbCode, pathFileIntro, pathFileFacebook, dateModified from kbList where sex='$gioitinh' order by dateModified desc limit 10";
$query="INSERT INTO kbList (callerIn,pathFileIntro,dateInsert) VALUES ('$callerID','$pathIntro',now())";
$results = mysql_query($query, $connect)
                        or die(mysql_error());
			mysql_close($connect);
?>