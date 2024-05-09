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
   $businfo = $bus->query("select id from tbl_bus where driver_id=".$data['driver_id']."")->fetch_assoc();
   $getboardinfo = $bus->query("select * from tbl_board_drop_points where bus_id=".$businfo['id']." limit 1")->fetch_assoc();
   $bus_id = $businfo['id'];
   $fromCity = $getboardinfo['bpoint'];
$toCity = $getboardinfo['dpoint'];
$trip_date = date("Y-m-d");

$trip_day_of_week_numeric = date('w', strtotime($trip_date));

// Define an array to map numeric day of the week to its name
$days_of_week = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

// Get the day of the week as its name
$trip_day_of_week = $days_of_week[$trip_day_of_week_numeric];

$offday_check = "AND FIND_IN_SET('" . $trip_day_of_week . "', bus.offday) = 0";


$sql = "
SELECT 
    bp.bus_id,
    bp.bpoint,
    bp.id AS id_pickup_drop, 
    bp.dpoint, 
    bp.btime AS pick_time, 
    bp.dtime AS drop_time,
    bp.differncetime As Difference_pick_drop,    
    bus.title, 
    bus.bno, 
    bus.bus_img,
    bus.bstatus, 
    bus.rate, 
    bus.tick_price, 
    bus.decker, 
    bus.driver_direction, 
    bus.totl_seat, 
    bus.seat_limit, 
    bus.bac, 
    bus.is_sleeper, 
    bus.seat_layout, 
    bus.offday,
    (
        SELECT 
            CASE 
                WHEN COUNT(*) != 0 THEN 
                    FORMAT(SUM(total_rate) / COUNT(*), IF(SUM(total_rate) % COUNT(*) > 0, 2, 0))
                ELSE 
                    bus.rate 
            END 
        FROM tbl_book 
        WHERE bus_id = bp.bus_id 
            AND book_status = 'Completed' 
            AND is_rate = 1
    ) AS bus_rate,
    (
        SELECT GROUP_CONCAT(title) 
        FROM tbl_facility 
        WHERE FIND_IN_SET(tbl_facility.id, bus.bus_facility)
    ) AS bus_facilities,
    (
        SELECT GROUP_CONCAT(img) 
        FROM tbl_facility 
        WHERE FIND_IN_SET(tbl_facility.id, bus.bus_facility)
    ) AS facility_imgs,
    
    boarding_city.title as boarding_city,
    drop_city.title as drop_city
FROM tbl_board_drop_points as bp
JOIN tbl_bus as bus ON bp.bus_id = bus.id
JOIN (SELECT title FROM tbl_city WHERE id = " . $fromCity . ") as boarding_city
JOIN (SELECT title FROM tbl_city WHERE id = " . $toCity . ") as drop_city
WHERE bp.bpoint = " . $fromCity . "
AND bus.bstatus = 1
AND bp.dpoint = " . $toCity . "
AND bus.driver_id=".$driver_id."
" . $offday_check . "";
	$busfetch = $bus->query($sql)->fetch_assoc();
	
	$pick_datetime = new DateTime($trip_date . ' ' . $busfetch['pick_time']);
$drop_datetime = new DateTime($trip_date . ' ' . $busfetch['drop_time']);

// Check if the drop time is on the next date
if ($drop_datetime < $pick_datetime) {
    // Drop time is on the next date
	$pick_date = $pick_datetime->format('Y-m-d');
    $next_date = $drop_datetime->modify('+1 day');
    $dropdate = $next_date->format('Y-m-d');
} else {
    // Drop time is on the same date
    $dropdate = $drop_datetime->format('Y-m-d');
	$pick_date = $pick_datetime->format('Y-m-d');
}

 $bu = array();
	$bu['bus_id'] = $busfetch['bus_id'];
	$busId = $busfetch['bus_id'];
	$bu['id_pickup_drop'] = $busfetch['id_pickup_drop'];
	$bu['bus_title'] = $busfetch['title'];
	$bu['bus_no'] = $busfetch['bno'];
	$bu['pick_date'] = $pick_date;
	$bu['drop_date'] = $dropdate;
	$bu['bus_img'] = $busfetch['bus_img'];
	$bu['bus_picktime'] = $busfetch['pick_time'];
	$bu['bus_droptime'] = $busfetch['drop_time'];
	$bu['boarding_city'] = $busfetch['boarding_city'];
	$bu['drop_city'] = $busfetch['drop_city'];
	$bu['bus_rate'] = $busfetch['bus_rate'];
	$bu['Difference_pick_drop'] = $busfetch['Difference_pick_drop'];
	$bu['ticket_price'] = $busfetch['tick_price'];
	$bu['decker'] = $busfetch['decker'];
	$count = $bus->query("SELECT * FROM tbl_book_pessenger WHERE bus_id = $busId  AND book_date = '$trip_date'")->num_rows;
	$bu['left_seat'] = "".($busfetch['totl_seat'] - $count)."";
	$bu['book_seat'] =  $count;
	$bu['totl_seat'] = $busfetch['totl_seat'];
	$bu['book_limit'] = $busfetch['seat_limit'];
	$bu['bus_ac'] = $busfetch['bac'];
	$bu['is_sleeper'] = $busfetch['is_sleeper'];
	 $returnArr = array("TripDetails"=>$bu,"currency"=>$set['currency'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Trip Details Get Successfully!!");
}

echo json_encode($returnArr);