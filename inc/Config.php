<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// $currentLang = $_SESSION["sel_lan"];
include_once "languages/en.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
//   $bus = new mysqli("localhost", "cmuvxxwkzy", "4D5mPxv2Dv", "cmuvxxwkzy");
  $bus = new mysqli("localhost", "root", "", "nxt_bus");
  $bus->set_charset("utf8mb4");
} catch(Exception $e) {
  error_log($e->getMessage());
  //Should be a message a typical user could understand
}
    
$set = $bus->query("SELECT * FROM `tbl_setting`")->fetch_assoc();
date_default_timezone_set($set['timezone']);
$prints = $bus->query("select * from tbl_bud")->fetch_assoc();	
if(isset($_SESSION['stype']))
	{
		if($_SESSION['stype'] == 'sowner')
		{
			$sdata = $bus->query("SELECT * FROM `tbl_bus_operator` where email='".$_SESSION['busname']."'")->fetch_assoc();
		}
	}
	
?>