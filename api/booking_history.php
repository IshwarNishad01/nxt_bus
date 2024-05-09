<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

if($data['uid'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
   
    $uid =  strip_tags(mysqli_real_escape_string($bus,$data['uid']));
	$status = $data['status'];
	$op = array();
	$vop = array();
	if($status == 'Pending')
	{
		$getbusinfo = $bus->query("SELECT id,ticket_price,boarding_city,drop_city,bus_picktime,bus_droptime,Difference_pick_drop,bus_id,subtotal FROM `tbl_book` where uid=".$uid." and book_status='Pending'");
	}
	elseif($status == 'Completed')
	{
		$getbusinfo = $bus->query("SELECT id,ticket_price,boarding_city,drop_city,bus_picktime,bus_droptime,Difference_pick_drop,bus_id,subtotal FROM `tbl_book` where uid=".$uid." and book_status='Completed'");
	}
	else 
	{
	$getbusinfo = $bus->query("SELECT id,ticket_price,boarding_city,drop_city,bus_picktime,bus_droptime,Difference_pick_drop,bus_id,subtotal FROM `tbl_book` where uid=".$uid." and book_status='Cancelled'");
	}
	while($row = $getbusinfo->fetch_assoc())
	{
		$businfo = $bus->query("SELECT * from tbl_bus where id=".$row["bus_id"]."")->fetch_assoc();
		
		$op['ticket_id'] = $row['id'];
		
		$op['bus_name'] = $businfo['title'];
		$op['bus_no'] = $businfo['bno'];
		$op['bus_img'] = $businfo['bus_img'];
		$op['is_ac'] = $businfo['bac'];
		$op['subtotal'] = $row['subtotal'];
		$op['ticket_price'] = $row['ticket_price'];
		$op['boarding_city'] = $row['boarding_city'];
	    $op['drop_city'] = $row['drop_city'];
		$op['bus_picktime'] = $row['bus_picktime'];
		$op['bus_droptime'] = $row['bus_droptime'];
		$op['Difference_pick_drop'] = $row['Difference_pick_drop'];
		$vop[] = $op;
	}
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Book Ticket Successfully!!!","tickethistory"=>$vop);
}
echo json_encode($returnArr);