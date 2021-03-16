#!/usr/bin/php -q
<?php
require('phpagi.php');
$user=$argv[1];
$pass=$argv[2];
$Addressee=$argv[3];//so dt nhan sms
$CurrentPort=$argv[4];
$GsmGateWay=$argv[5];
$PhoneNumber=$argv[6];
$status=$argv[7];

$dt=getdate();
$agi=new AGI();
	/*$path_log="/var/log/SMS/";
	$Log_File='Ping-'.$client.'-'.$dt['year'].'-'.$dt['mon'].'-'.$dt['mday'].'.log';
	$file=$path_log.'/'.$Log_File;
	
$user='admin';
$pass='admin';
$Addressee='0907644220';
$CurrentPort='7';
$GsmGateWay='172.20.0.15';
$PhoneNumber="0907644220";
$status='ANSWER';
*/
//if($PhoneNumber=="0907644220")$Addressee="0906246488";
$message='Anh%2Fchi%20co%20hai%20long%20ve%20noi%20dung%20tu%20van%20tu%20tong%20dai%20vien%20khong%3F%20Hai%20long%20nhan%201%3B%20Chua%20hai%20long%20nhan%202%20';
$Link=@'http://'.$user.':'.$pass.'@'.$GsmGateWay.'/goform/WIAMsgSend?CurrentPort='.$CurrentPort.'&Addressee='.$Addressee.'&MsgInfo='.$message;
//var_dump($Link);
if($status =='ANSWER')
{
	//echo "Answer";
	$Link.="%20Answered%20Call";
	$send=file_get_contents($Link);
	//$send=fopen($Link,'r');
	//$agi->set_variable("SendSMS","Send SMS Successfull...");
	//if(!$send)
	//{
		//WriteLogFile("error: send".$PhoneNumber,$path_log,$file);
	//}else WriteLogFile("Success: ".$PhoneNumber,$path_log,$file);
	/*$send2=fopen($SMS_MP,'r');
	if(!$send2)
	{
		WriteLogFile("error: send".$PhoneNumber,$path_log,$file);
	}else WriteLogFile("Success: ".$PhoneNumber,$path_log,$file);
	*/
}
else
{
	//echo "Misscall";
	//$Link.="%20Missed%20Call";
	$Link.="";
	$send=file_get_contents($Link);
	//$send=fopen($Link,'r');
	//if(!$send)
	//{
	//	WriteLogFile("error: ".$PhoneNumber,$path_log,$file);
	//}
	//else WriteLogFile("Success: ".$Link,$path_log,$file);
	/*$send2=fopen($SMS_MP,'r');
	if(!$send2)
	{
		WriteLogFile("error: ".$PhoneNumber,$path_log,$file);
	}else WriteLogFile("Success: ".$PhoneNumber,$path_log,$file);
	*/
}
Sleep(10); //BacHN change delay 5 to 10
exit;
//$agi->set_variable("SendSMS","Send SMS Fail !!!");
//$agi->set_variable("StatusSMS","$status");
//echo $message;
//$send=fopen($Link,'r');
//if(!$send)//echo "error \n";
//print_r($dt);
?>