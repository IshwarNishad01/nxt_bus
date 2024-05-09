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
	$check_user_verify = $bus->query("select * from tbl_user where id=".$data['uid']."")->fetch_assoc();
	$is_verify = empty($check_user_verify["is_verify"]) ? "0" : $check_user_verify["is_verify"];
	$is_block = empty($check_user_verify["status"]) ? "1" : ($check_user_verify["status"] == 1 ? "0" : "1");
	$vop =array();
	$ban = array();
	
	
	$sql = $bus->query("select * from tbl_banner where status=1");
	while($rp = $sql->fetch_assoc())
	{
		$vop['id'] = $rp['id'];
		$vop['img'] = $rp['img'];
		$ban[] = $vop;
	}
	
	
	$uid =  strip_tags(mysqli_real_escape_string($bus,$data['uid']));
	$op = array();
	$vops = array();
	$timestamp    = date("Y-m-d H:i:s");
	$getbusinfo = $bus->query("SELECT id,ticket_price,boarding_city,drop_city,bus_picktime,bus_droptime,Difference_pick_drop,bus_id FROM `tbl_book` where uid=".$uid." and bus_board_date >='".$timestamp."' and book_status='Pending'");
	while($row = $getbusinfo->fetch_assoc())
	{
		$businfo = $bus->query("SELECT * from tbl_bus where id=".$row["bus_id"]."")->fetch_assoc();
		
	
		$op['ticket_id'] = $row['id'];
		$op['bus_name'] = $businfo['title'];
		$op['bus_no'] = $businfo['bno'];
		$op['bus_img'] = $businfo['bus_img'];
		$op['is_ac'] = $businfo['bac'];
		$op['ticket_price'] = $row['ticket_price'];
		$op['boarding_city'] = $row['boarding_city'];
	    $op['drop_city'] = $row['drop_city'];
		$op['bus_picktime'] = $row['bus_picktime'];
		$op['bus_droptime'] = $row['bus_droptime'];
		$op['Difference_pick_drop'] = $row['Difference_pick_drop'];
		$vops[] = $op;
	}
	
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Home Data Get Successfully!!!","tickethistory"=>$vops,"banner"=>$ban,'is_verify'=>$is_verify,'is_block'=>$is_block,'withdraw_limit'=>$set['agent_limit'],"currency"=>$set['currency'],"tax"=>$set['tax']);	
}
echo json_encode($returnArr);