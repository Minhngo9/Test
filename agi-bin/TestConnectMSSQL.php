#!/usr/bin/php -q
<?php
putenv("ODBCINI=etc/odbc.ini");
  $con = odbc_connect("mssql","sa","Sql#minhphuc2009");
  if(!$con)
  Print "Khong Ket Noi";
  else 
  Print "Connect Successful !!!";
  $sql="SELECT TOP 100 * FROM CallDetail";
  $rs = odbc_exec($con,$sql);
	$val = array();
  while ( $row = odbc_fetch_array($rs) ){
        array_push($val, $row);
  }
	print_r($val);
  odbc_free_result ( $rs );
  odbc_close( $con );
?>