<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

if($data['uid'] == '' || $data['ticket_id'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
   
    $uid =  strip_tags(mysqli_real_escape_string($bus,$data['uid']));
	$ticket_id =  strip_tags(mysqli_real_escape_string($bus,$data['ticket_id']));
	$op = array();
	$vop = array();
	$getbusinfo = $bus->query("SELECT * FROM `tbl_book` where uid=".$uid." and id=".$ticket_id."");
	while($row = $getbusinfo->fetch_assoc())
	{
		 
		 
		$businfo = $bus->query("SELECT * from tbl_bus where id=".$row["bus_id"]."")->fetch_assoc();
		$pname = $bus->query("select * from tbl_payment_list where id=".$row['payment_method_id']."")->fetch_assoc();
	   
		$op['ticket_id'] = $row['id'];
		$op['bus_name'] = $businfo['title'];
		$currentTime = time(); // Get the current timestamp
$busBoardTimestamp = strtotime($row['bus_board_date']); // Convert bus_board_date to timestamp
$busDropTimestamp = strtotime($row['bus_drop_date']); // Convert bus_drop_date to timestamp

        $currentDatetime = new DateTime();
		
	    $specificDatetime = new DateTime(''.$row['bus_board_date'].'');
		
// Calculate 1 hour before bus_board_date
$oneHourBeforeBoard = $busBoardTimestamp - 3600; // 3600 seconds = 1 hour

// Check if the current time is within the specified range
if ($currentTime >= $oneHourBeforeBoard && $currentTime < $busDropTimestamp) {
		$op['bus_no'] = $businfo['bno'];
		$op['driver_mobile'] = $businfo['driver_mobile'];
		$op['driver_name'] = $businfo['driver_name'];
		}
		else 
		{
			$op['bus_no'] = "";
			$op['driver_mobile'] ="";
			$op['driver_name'] = "";
		}
		$op['bus_img'] = $businfo['bus_img'];
		
		if ($currentDatetime < $specificDatetime) {
    // Calculate the difference in hours
    $interval = $currentDatetime->diff($specificDatetime);
    $hoursDifference = $interval->h + ($interval->days * 24);
   $getzero = $bus->query("select hour from tbl_policy order by rmat asc limit 1")->fetch_assoc();
    // Check if the difference is less than 12 hours
    if ($hoursDifference >=  $getzero['hour']) {
        $op['cancle_show'] = 1;
    } else {
        $op['cancle_show'] = 0;
    }
} else {
    // Specific datetime is in the past, so show button 0
    $op['cancle_show'] = 0;
}

		$op['is_ac'] = $businfo['bac'];
		
		$op['ticket_price'] = $row['ticket_price'];
		$op['boarding_city'] = $row['boarding_city'];
	    $op['drop_city'] = $row['drop_city'];
		$op['bus_picktime'] = $row['bus_picktime'];
		$op['bus_droptime'] = $row['bus_droptime'];
		$op['Difference_pick_drop'] = $row['Difference_pick_drop'];
		$op['total_seat'] = $row['total_seat'];
		$op['cou_amt'] = $row['cou_amt'];
		$op['wall_amt'] = $row['wall_amt'];
		$op['book_date'] = $row['book_date'];
		$op['total'] = $row['total'];
		$op['is_rate'] = $row['is_rate'];
		$op['subtotal'] = $row['subtotal'];
		$op['tax'] = $row['tax'];
		$op['tax_amt'] = $row['tax_amt'];
		$op['transaction_id'] = $row['transaction_id'];
		$op['p_method_name'] = $pname['title'];
		$op['contact_name'] = $row['name'];
		$op['contact_email'] = $row['email'];
		$op['contact_mobile'] = $row['ccode'].$row['mobile'];
		$op['sub_pick_time'] = $row['sub_pick_time'];
        $op['sub_pick_place'] = $row['sub_pick_place'];
        $op['sub_pick_address'] = $row['sub_pick_address'];
        $op['sub_pick_mobile'] = $row['sub_pick_mobile'];
        $op['sub_drop_time'] = $row['sub_drop_time'];
        $op['sub_drop_place'] = $row['sub_drop_place'];
        $op['sub_drop_address'] = $row['sub_drop_address'];
		
		$fetchpro = $bus->query("select *  from tbl_book_pessenger where book_id=".$row['id']."");
		$kop = array();
		$pdata = array();
		while($jpro = $fetchpro->fetch_assoc())
		{
			$kop['name'] = $jpro['name'];
			$kop['age'] = $jpro['age'];
			$kop['gender'] = $jpro['gender'];
			$kop['seat_no'] = $jpro['seat_no'];
			$pdata[] = $kop;
		}
		$op['Order_Product_Data'] = $pdata;
		$vop[] = $op;
	}
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Book Ticket Successfully!!!","tickethistory"=>$vop);
}
echo json_encode($returnArr);