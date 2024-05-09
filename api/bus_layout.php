<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
function isSeatBooked($bus, $busId, $tripDate, $seatNumber)
{
    $count = $bus->query("SELECT COUNT(*) FROM tbl_book_pessenger WHERE bus_id = $busId AND seat_no = '$seatNumber' AND book_date = '$tripDate'")->fetch_row()[0];
    return $count > 0;
}

function getgender($bus, $busId, $tripDate, $seatNumber)
{
    $result = $bus->query("SELECT gender FROM tbl_book_pessenger WHERE bus_id = $busId AND seat_no = '$seatNumber' AND book_date = '$tripDate'");
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $gender = $row['gender'];
        return $gender;
    } else {
        return null; // Handle the case where no gender is found in the database.
    }
}

if($data['uid'] == '' or $data['bus_id'] == '' or $data['trip_date'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
    $uid =  strip_tags(mysqli_real_escape_string($bus,$data['uid']));
	$bus_id = $data['bus_id'];
	$trip_date = strip_tags(mysqli_real_escape_string($bus,$data['trip_date']));



	$busfetch = $bus->query("SELECT seat_layout,driver_direction,tick_price,decker,totl_seat,seat_limit from tbl_bus where id=".$bus_id."");
$bu = array();
$vo = array();
while($row = $busfetch->fetch_assoc())
{
	$bu['driver_direction'] = $row['driver_direction'];
	$bu['ticket_price'] = $row['tick_price'];
	$bu['decker'] = $row['decker'];
	
	$bu['totl_seat'] = $row['totl_seat'];
	$bu['book_limit'] = $row['seat_limit'];
	$seatLayoutData = explode('$;', $row['seat_layout']);
    $seatLayout = array();
	
	
    
     $low = array();
	 $up = array();
    foreach ($seatLayoutData as $layout) {
        if (strpos($layout, 'LOWER') !== false) {
            // If it contains "LOWER", add to the lower array
			$lowerLayout = array();
            $seatLayout = explode(',', str_replace(',LOWER', '', $layout));
            foreach ($seatLayout as $seatNumber) {
                
                    $lowerLayout[] = [
                        "seat_number" => $seatNumber,
                        "is_booked" => empty($seatNumber) ? false : isSeatBooked($bus,$bus_id, $trip_date, $seatNumber),
						"gender"=>getgender($bus,$bus_id, $trip_date, $seatNumber)
                    ];
                
            }
            $low[] = $lowerLayout;
        } elseif (strpos($layout, 'UPPER') !== false) {
			$upperLayout = array();
            // If it contains "UPPER", add to the upper array
            $seatLayout = explode(',', str_replace(',UPPER', '', $layout));
            foreach ($seatLayout as $seatNumber) {
                
                    $upperLayout[] = [
                        "seat_number" => $seatNumber,
                        "is_booked" => empty($seatNumber) ? false : isSeatBooked($bus,$bus_id, $trip_date, $seatNumber),
						"gender"=>getgender($bus,$bus_id, $trip_date, $seatNumber)
                    ];
                
            }
            $up[] = $upperLayout;
        }
    }

    $bu['lower_layout'] = $low;
    $bu['upper_layout'] = empty($up) ? [] : $up;
	$vo[] = $bu;	
}
$tbwallet = $bus->query("select * from tbl_user where id=".$uid."")->fetch_assoc();

	$returnArr = array("BusLayoutData"=>$vo,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Bus Search successfully!","wallet"=>$tbwallet['wallet']);						 
}
echo json_encode($returnArr);

?>