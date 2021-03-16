#!/usr/bin/php -q

<?php
$omsid=$argv[1];
$callid=$argv[2];
$timeid=$argv[3];
putenv("ODBCINI=etc/odbc.ini");
  $con = odbc_connect("mssql","crm_viettel","mp1234");
  if(!$con)
  die(odbc_errormsg());
  else{
  $sql="INSERT INTO [tblCallID]([idoms],[callid],[timeId]) VALUES('$omsid','$callid',$timeid)";
  $rs = odbc_exec($con,$sql);
  }
  odbc_free_result ( $rs );
  odbc_close( $con );

?>
