<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
if($data['driver_id'] == '' || $data['bus_id'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
	$bus_id= $data['bus_id'];
	$driver_id = $data['driver_id'];
	$getboardid = $bus->query("SELECT GROUP_CONCAT(`id`) as main_board_id FROM `tbl_board_drop_points` where bus_id=".$bus_id."")->fetch_assoc();
    $getboardpointid = $bus->query("SELECT point_id, ptime FROM tbl_sub_route_time WHERE board_id IN (".$getboardid['main_board_id'].") GROUP BY point_id");
	$b = array();
	$po = array();
	while($row = $getboardpointid->fetch_assoc())
	{
		$getpoint = $bus->query("SELECT * FROM `tbl_points` where id=".$row['point_id']."")->fetch_assoc();
		$b['board_title'] = $getpoint['title'];
		$b['board_address'] = $getpoint['address'];
		$b['point_lats'] = $getpoint['lats'];
	    $b['point_longs'] = $getpoint['longs'];
		$b['board_time'] = $row['ptime'];
		$trip_date = date("Y-m-d");
		$c = array();
		$pl = array();
		$getcustomer = $bus->query("SELECT * from tbl_book where bus_id=".$bus_id." and DATE(bus_board_date)='".$trip_date."' and pickup_id=".$getpoint["id"]."");
		while($cust = $getcustomer->fetch_assoc())
		{
			$c['cust_name'] = $cust['name'];
			$c['cust_mobile'] = $cust['ccode'].$cust['mobile'];
			
			$seatlist = $bus->query("select * from tbl_book_pessenger where book_id=".$cust['id']." and book_date='".$trip_date."'");
			$roj = array();
			$bp = array();
			while($plc = $seatlist->fetch_assoc())
			{
				$bp['name'] = $plc['name'];
				$bp['age'] = $plc['age'];
				$bp['gender'] = $plc['gender'];
				$bp['seat_no'] = $plc['seat_no'];
				$bp['check_in'] = $plc['check_in'];
				$bp['cancle_reason'] = empty($plc['cancle_reason']) ? "" : $plc['cancle_reason'];
				$roj[] = $bp;
			}
			$c['pessenger_data'] = $roj;
			$pl[] = $c;
		}
		$b['customer_data'] = $pl;
		$po[] = $b;
	}
	
	
	$getdroppointid = $bus->query("SELECT point_id, ptime FROM tbl_drop_sub_route WHERE board_id IN (".$getboardid['main_board_id'].") GROUP BY point_id");
	$bs = array();
	$pos = array();
	while($row = $getdroppointid->fetch_assoc())
	{
		$getpoint = $bus->query("SELECT * FROM `tbl_points` where id=".$row['point_id']."")->fetch_assoc();
		$bs['drop_title'] = $getpoint['title'];
		$bs['drop_address'] = $getpoint['address'];
		$bs['point_lats'] = $getpoint['lats'];
	    $bs['point_longs'] = $getpoint['longs'];
		$bs['drop_time'] = $row['ptime'];
		$trip_date = date("Y-m-d");
		$cs = array();
		$plz = array();
		$getcustomer = $bus->query("SELECT * from tbl_book where bus_id=".$bus_id." and DATE(bus_board_date)='".$trip_date."' and drop_id=".$getpoint["id"]."");
		while($cust = $getcustomer->fetch_assoc())
		{
			$cs['cust_name'] = $cust['name'];
			$cs['cust_mobile'] = $cust['ccode'].$cust['mobile'];
			$seatlist = $bus->query("select * from tbl_book_pessenger where book_id=".$cust['id']." and book_date='".$trip_date."'");
			$rojs = array();
			$bps = array();
			while($pls = $seatlist->fetch_assoc())
			{
				$bps['name'] = $pls['name'];
				$bps['age'] = $pls['age'];
				$bps['gender'] = $pls['gender'];
				$bps['seat_no'] = $pls['seat_no'];
				$bps['check_in'] = $pls['check_in'];
				$rojs[] = $bps;
			}
			$cs['pessenger_data'] = $rojs;
			$plz[] = $cs;
		}
		$bs['customer_data'] = $plz;
		$pos[] = $bs;
	}
	
	
	$query1 = "SELECT point_id, ptime FROM tbl_sub_route_time WHERE board_id IN (".$getboardid['main_board_id'].") GROUP BY point_id";
$query2 = "SELECT point_id, ptime FROM tbl_drop_sub_route WHERE board_id IN (".$getboardid['main_board_id'].") GROUP BY point_id";

$combinedQuery = $query1 . " UNION " . $query2;

$result = $bus->query($combinedQuery);

$posp = array();
$bsp = array();
while ($row = $result->fetch_assoc()) {
    $getpoint = $bus->query("SELECT * FROM `tbl_points` WHERE id=" . $row['point_id'])->fetch_assoc();
    
    
    $bsp['drop_title'] = $getpoint['title'];
    $bsp['drop_address'] = $getpoint['address'];
	$bsp['point_lats'] = $getpoint['lats'];
	$bsp['point_longs'] = $getpoint['longs'];
    $bsp['drop_time'] = $row['ptime'];
    
    // Additional processing if needed
    
    $posp[] = $bsp;
}

	

$returnArr = array("BoardingArr"=>$po,"Droppoint"=>$pos,"Total_point_list"=>$posp,"Total_point"=>count($posp),"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Trip Details Get Successfully!!");
}
echo json_encode($returnArr);
?>