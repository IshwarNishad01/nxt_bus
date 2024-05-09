<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

if($data['uid'] == '' or $data['boarding_id'] == '' or $data['drop_id'] == '' or $data['trip_date'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $boarding_id = strip_tags(mysqli_real_escape_string($bus,$data['boarding_id']));
	$drop_id = strip_tags(mysqli_real_escape_string($bus,$data['drop_id']));
	$trip_date = strip_tags(mysqli_real_escape_string($bus,$data['trip_date']));
    $uid =  strip_tags(mysqli_real_escape_string($bus,$data['uid']));
	$sort = $data['sort'];
	$pickupfilter = $data['pickupfilter'];
	$dropfilter = $data['dropfilter'];
	$bustype = $data['bustype'];
	$operatorlist = $data['operatorlist'];
	$facilitylist = $data['facilitylist'];
$trip_day_of_week_numeric = date('w', strtotime($trip_date));

// Define an array to map numeric day of the week to its name
$days_of_week = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

// Get the day of the week as its name
$trip_day_of_week = $days_of_week[$trip_day_of_week_numeric];

$offday_check = "AND FIND_IN_SET('" . $trip_day_of_week . "', bus.offday) = 0";

$currentTimestamp = strtotime(date("H:i:s"));
$twoHoursAgoTimestamp = $currentTimestamp + (2 * 60 * 60); // Subtract 2 hours in seconds
$facilityValues = explode(',', $facilitylist);
$conditions = [];

foreach ($facilityValues as $value) {
    $conditions[] = "FIND_IN_SET('$value', bus.bus_facility) > 0";
}

$facilityCondition = implode(' OR ', $conditions);

$sqlf = "AND ('$facilitylist' = '0' OR ('$facilitylist' != '0' AND ($facilityCondition)))";


$operatorValues = explode(',', $operatorlist);
$conditions = [];

foreach ($operatorValues as $value) {
    $conditions[] = "FIND_IN_SET('$value', bus.operator_id) > 0";
}

$operatorCondition = implode(' OR ', $conditions);

$sqlp = "AND ('$operatorlist' = '0' OR ('$operatorlist' != '0' AND ($operatorCondition)))";


$twoHoursAgo = date("H:i:s", $twoHoursAgoTimestamp);
$sql = "
SELECT 
    bp.bus_id, 
    bus.operator_id,
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
    
    IF('" . $trip_date . "' = CURDATE(), bp.btime >= '" . $twoHoursAgo . "', 1) as apply_time_filter,
    boarding_city.title as boarding_city,
    drop_city.title as drop_city
FROM tbl_board_drop_points as bp
JOIN tbl_bus as bus ON bp.bus_id = bus.id
JOIN (SELECT title FROM tbl_city WHERE id = " . $boarding_id . ") as boarding_city
JOIN (SELECT title FROM tbl_city WHERE id = " . $drop_id . ") as drop_city
WHERE bp.bpoint = " . $boarding_id . "
AND bus.bstatus = 1
AND bp.dpoint = " . $drop_id . "
AND (
        ($pickupfilter = 0) OR
        ($pickupfilter = 1 AND TIME(bp.btime) BETWEEN '06:00:00' AND '12:00:00') OR
        ($pickupfilter = 2 AND TIME(bp.btime) BETWEEN '12:00:00' AND '18:00:00') OR
        ($pickupfilter = 3 AND TIME(bp.btime) BETWEEN '18:00:00' AND '23:59:59') OR
        ($pickupfilter = 4 AND (TIME(bp.btime) BETWEEN '00:00:00' AND '06:00:00' OR TIME(bp.btime) = '00:00:00'))
    )
	AND (
        ($dropfilter = 0) OR
        ($dropfilter = 1 AND TIME(bp.dtime) BETWEEN '06:00:00' AND '12:00:00') OR
        ($dropfilter = 2 AND TIME(bp.dtime) BETWEEN '12:00:00' AND '18:00:00') OR
        ($dropfilter = 3 AND TIME(bp.dtime) BETWEEN '18:00:00' AND '23:59:59') OR
        ($dropfilter = 4 AND (TIME(bp.dtime) BETWEEN '00:00:00' AND '06:00:00' OR TIME(bp.dtime) = '00:00:00'))
    )
AND (
        ($bustype = 0) OR
        ($bustype = 1 AND bus.is_sleeper = 0) OR
        ($bustype = 2 AND bus.is_sleeper = 1) OR
        ($bustype = 3 AND bus.bac = 1) OR
        ($bustype = 4 AND bus.bac = 0)
    )
	".$sqlp."
	".$sqlf."
" . $offday_check . "
HAVING apply_time_filter = 1 " . (
    $sort == 1 ? "ORDER BY bus.tick_price ASC" :
    ($sort == 2 ? "ORDER BY bus_rate DESC" :
    ($sort == 3 ? "ORDER BY pick_time ASC" :
    ($sort == 4 ? "ORDER BY pick_time DESC" : ""))
)) . "";


	$busfetch = $bus->query($sql);



$bu = array();
$vo = array();
while($row = $busfetch->fetch_assoc())
{
	$bu['bus_id'] = $row['bus_id'];
	$getcommission = $bus->query("select * from  tbl_bus_operator where id=".$row['operator_id']."")->fetch_assoc();
	$busId = $row['bus_id'];
	$bu['agent_commission'] = $getcommission['agent_commission'];
	$bu['id_pickup_drop'] = $row['id_pickup_drop'];
	$bu['operator_id'] = $row['operator_id'];
	$bu['bus_title'] = $row['title'];
	$bu['bus_no'] = $row['bno'];
	$bu['bus_img'] = $row['bus_img'];
	$bu['bus_picktime'] = $row['pick_time'];
	$bu['bus_droptime'] = $row['drop_time'];
	$bu['boarding_city'] = $row['boarding_city'];
	$bu['drop_city'] = $row['drop_city'];
	$bu['bus_rate'] = $row['bus_rate'];
	$bu['Difference_pick_drop'] = $row['Difference_pick_drop'];
	$bu['ticket_price'] = $row['tick_price'];
	$bu['decker'] = $row['decker'];
	$count = $bus->query("SELECT * FROM tbl_book_pessenger WHERE bus_id = $busId  AND book_date = '$trip_date'")->num_rows;
	$bu['left_seat'] = ''.$row['totl_seat'] - $count;
	$bu['totl_seat'] = $row['totl_seat'];
	$bu['book_limit'] = $row['seat_limit'];
	$bu['bus_ac'] = $row['bac'];
	$bu['is_sleeper'] = $row['is_sleeper'];
	$bus_facilities = explode(',',$row['bus_facilities']);
	$bus_facilities_img = explode(',',$row['facility_imgs']);
	$counts = $bus->query("SELECT count(*) as total_review FROM `tbl_book` where bus_id =".$row['bus_id']." and is_rate=1")->fetch_assoc();
	$bu['total_review'] = intval($counts['total_review']);
	$combinedFacilities = array();

// Loop through both arrays and combine facility names and images
for ($i = 0; $i < count($bus_facilities); $i++) {
    $facilityName = $bus_facilities[$i];
    $facilityImg = isset($bus_facilities_img[$i]) ? $bus_facilities_img[$i] : '';

    $combinedFacilities[] = array(
        'facilityname' => $facilityName,
        'facilityimg' => $facilityImg
    );
}

// $combinedFacilities now contains both facility names and images
$bu['bus_facilities'] = $combinedFacilities;
	
	$vo[] = $bu;	
}


   
	$returnArr = array("BusData"=>$vo,"currency"=>$set['currency'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Bus Search successfully!");						 
}
echo json_encode($returnArr);

?>