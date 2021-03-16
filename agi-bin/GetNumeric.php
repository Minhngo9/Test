#!/usr/bin/php -qn
<?php
# Purpose: Get string voice prompts of a numeric
# Input:
#	argv[1]: wave files fodler
#	argv[2]: a numeric (in string format)
# Output: voice prompts
#include ("include/phpagi-2.14/phpagi-asmanager.php");
require('phpagi.php'); #Use the phpAGI library
$agi = new AGI(); #Create a new Asterisk::AGI object
$sFolder=$argv[1];
$sInput=$argv[2];
$arrVoicePrompts=GetNumeric($sInput);
for($inti=0;$inti<count($arrVoicePrompts);$inti++) $sVoicePrompts.= $sFolder . $arrVoicePrompts[$inti] . "&";
if($sVoicePrompts!="") $sVoicePrompts=substr($sVoicePrompts,0,strlen($sVoicePrompts)-1);
#echo $sVoicePrompts;
$agi->set_variable('returnValue',"$sVoicePrompts");

function GetNumeric($x){
$intPointPos=stripos($x,".");
$arrSegment=Array();	
$arrIntSegment=Array();
$inti=0;
$SkipUnit=false;
	if($intPointPos>0){		
		$strFraction=substr($x,$intPointPos+1,strlen($x)-$intPointPos);
		$x=substr($x,0,$intPointPos);				
	}		
	if($x<0.0){
		$arrSegment[]="NEGATIVE";
		$x=substr($x,1,strlen($x));
	}	
	if($x==0)$arrSegment[]="N0";
	else{		
		// process for the thousand billions
		if($x>=1000000000000){
			$intx=floor($x/1000000000000);			
			$arrIntSegment=GetIntegerSegment($intx);
			for($inti=0;$inti<count($arrIntSegment);$inti++)$arrSegment[]=$arrIntSegment[$inti];
			$arrSegment[]="N_THOUSAND";
			$x=$x-($intx*1000000000000);	// Get hunderd billions
			if($x==0)$SkipUnit=true;			
		}
		// process for the billions
		if($x>=1000000000){
			$intx=floor($x/1000000000);
			$arrIntSegment=GetIntegerSegment($intx);
			for($inti=0;$inti<count($arrIntSegment);$inti++)$arrSegment[]=$arrIntSegment[$inti];
			$arrSegment[]="N_BILLION";
			$x=$x-($intx*1000000000);	// Get hunderd millions
			if($x==0)$SkipUnit=true;
		}
		// process for the millions
		if($x>=1000000){
			$intx=floor($x/1000000);
			$arrIntSegment=GetIntegerSegment($intx);
			for($inti=0;$inti<count($arrIntSegment);$inti++)$arrSegment[]=$arrIntSegment[$inti];
			$arrSegment[]="N_MILLION";
			$x=$x-($intx*1000000);		// Get hunderd thousands
			if($x==0)$SkipUnit=true;
		}
		// process for the thousands
		if($x>=1000){
			$intx=floor($x/1000);
			$arrIntSegment=GetIntegerSegment($intx);
			for($inti=0;$inti<count($arrIntSegment);$inti++)$arrSegment[]=$arrIntSegment[$inti];
			$arrSegment[]="N_THOUSAND";
			$x=$x-($intx*1000);
			if($x==0)$SkipUnit=true;
		}
		// process for the unit
		$arrIntSegment=Array();
		if($SkipUnit==false){			
			$arrIntSegment=GetIntegerSegment($x);
		}
		for($inti=0;$inti<count($arrIntSegment);$inti++)$arrSegment[]=$arrIntSegment[$inti];		
	}	
	// process for fraction
	if($intPointPos>0){
		$arrSegment[]="N_COMMA";
		$arrSegment[]="N" . $strFraction;		
	}
	return $arrSegment;
}

function GetIntegerSegment($intx){
$arrSegment=Array();
	if($intx==0) $arrSegment[]="N0";
	else{
		if($intx==100) $arrSegment[]="N100";	
		else{
			if($intx>100){				
				$arrSegment[]="N".floor($intx/100)."00";				
				$intx=$intx%100;					
			}
		//	else 
		//	{
		//		$arrSegment[]="N0";				
		//		$arrSegment[]="N_HUNDRED";
		//	}
			if($intx>9) $arrSegment[]="N".$intx;
			else
			if($intx>0) $arrSegment[]="N".$intx;
		}
	}
	return($arrSegment);
}
?>