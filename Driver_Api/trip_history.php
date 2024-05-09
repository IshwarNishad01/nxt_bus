<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
if($data['driver_id'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
	$driver_id = $data['driver_id'];
   $businfo = $bus->query("select * from tbl_bus where driver_id=".$data['driver_id']."")->fetch_assoc();
 
   $busId = $businfo['id'];
  $query = $bus->query("SELECT bo.*,(
        SELECT 
            CASE 
                WHEN COUNT(*) != 0 THEN 
                    FORMAT(SUM(total_rate) / COUNT(*), IF(SUM(total_rate) % COUNT(*) > 0, 2, 0))
                ELSE 
                    5 
            END 
        FROM tbl_book 
        WHERE bus_id = bo.bus_id 
            AND book_status = 'Completed' 
            AND is_rate = 1
    ) AS bus_rate FROM `tbl_book` as bo WHERE bo.bus_id=".$busId." GROUP by bo.bus_board_date ORDER by bo.bus_board_date limit 5");

    $bu = array();
	$vop = array();
	while($row = $query->fetch_assoc())
	{
		
		$pick_datetime = new DateTime($row['bus_board_date']);
$drop_datetime = new DateTime($row['bus_drop_date']);
    $dropdate = $drop_datetime->format('Y-m-d');
	$pick_date = $pick_datetime->format('Y-m-d');

	$bu['bus_id'] = $businfo['id'];
	$bu['bus_title'] = $businfo['title'];
	$bu['bus_no'] = $businfo['bno'];
	$bu['pick_date'] = $pick_date;
	$bu['drop_date'] = $dropdate;
	$bu['bus_img'] = $businfo['bus_img'];
	$bu['bus_picktime'] = $row['bus_picktime'];
	$bu['bus_droptime'] = $row['bus_droptime'];
	$bu['boarding_city'] = $row['boarding_city'];
	$bu['drop_city'] = $row['drop_city'];
	$bu['bus_rate'] = $row['bus_rate'];
	$bu['Difference_pick_drop'] = $row['Difference_pick_drop'];
	$bu['ticket_price'] = $row['ticket_price'];
	$bu['decker'] = $businfo['decker'];
	$count = $bus->query("SELECT * FROM tbl_book_pessenger WHERE bus_id = $busId  AND book_date = '$pick_date'")->num_rows;
	$bu['left_seat'] = ''.$businfo['totl_seat'] - $count;
	$bu['book_seat'] =  $count;
	$bu['totl_seat'] = $businfo['totl_seat'];
	$bu['book_limit'] = $businfo['seat_limit'];
	$bu['bus_ac'] = $businfo['bac'];
	$bu['is_sleeper'] = $businfo['is_sleeper'];
	$vop[] = $bu;
	}
	 $returnArr = array("TripHistory"=>$vop,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Trip History Get Successfully!!");
}

echo json_encode($returnArr);