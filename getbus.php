<?php 
require 'inc/Config.php';
$vendor_id = $_POST['vendor_id'];
$fromCity = $_POST['fromCity'];
$toCity = $_POST['toCity'];
$trip_date = $_POST['journeyDate'];

$trip_day_of_week_numeric = date('w', strtotime($trip_date));

// Define an array to map numeric day of the week to its name
$days_of_week = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

// Get the day of the week as its name
$trip_day_of_week = $days_of_week[$trip_day_of_week_numeric];

$offday_check = "AND FIND_IN_SET('" . $trip_day_of_week . "', bus.offday) = 0";

$currentTimestamp = strtotime(date("H:i:s"));
$twoHoursAgoTimestamp = $currentTimestamp + (2 * 60 * 60); // Subtract 2 hours in seconds
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
JOIN (SELECT title FROM tbl_city WHERE id = " . $fromCity . ") as boarding_city
JOIN (SELECT title FROM tbl_city WHERE id = " . $toCity . ") as drop_city
WHERE bp.bpoint = " . $fromCity . "
AND bus.bstatus = 1
AND bp.dpoint = " . $toCity . "
AND bus.operator_id=".$vendor_id."
" . $offday_check . "";
	$busfetch = $bus->query($sql);
	while($row = $busfetch->fetch_assoc())
{
	$busId = $row['bus_id'];
	$count = $bus->query("SELECT * FROM tbl_book_pessenger WHERE bus_id = $busId  AND book_date = '$trip_date'")->num_rows;
	$lft =$row['totl_seat'] - $count;
	
	$pick_datetime = new DateTime($trip_date . ' ' . $row['pick_time']);
$drop_datetime = new DateTime($trip_date . ' ' . $row['drop_time']);

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
$bac = $bdata['bac'];
$is_sleeper = $bdata['is_sleeper'];
if($is_sleeper == 1 && $bac == 1)
{
	$bus_type = 'A/c Sleeper'; 
}
else if($is_sleeper == 1 && $bac == 0)
{
	$bus_type = 'Non A/c Sleeper'; 
}
else if($is_sleeper == 0 && $bac == 1)
{
	$bus_type = 'A/c Seater'; 
}
else 
{
	$bus_type = 'Non A/c Seater';
}
?>
<div class="col-sm-4">
        <div class="card">
            <div class="card-body">
			 <div class="row">
			 <div class="col-9 mb-3">
                <img src="<?php echo $row['bus_img'];?>" class="rounded-circle shadow-4-strong" width="60px" height="60px" style="float: left; margin-right: 10px;"/>
                <div style="float: left;">
                    <h4 class="b_title" style="margin-bottom: 0;"><?php echo $row['title'];?></h4>
                    <p style="margin-bottom: 0;"><?php echo $bus_type;?> <span class="badge badge-primary"><?php echo $lft;?> <?php echo $lang['seat_left'];?></span></p>
                   
                </div>
				</div>
				<div class="col-3 mb-3">
                <div style="float:right;">
                    <h4 style="margin-bottom: 0;"><b><?php echo $row['tick_price'].$set['currency'];?></b></h4>
                </div>
				</div>
				<div class="col-4 text-start mb-3">
				<p class="fw-bolder"><?php echo $row['boarding_city'];?><br>
				<span class="text text-primary"><?php echo date("h:i A", strtotime($row['pick_time']));?></span><br>
				<?php echo $pick_date;?></p>
				</div>
				<div class="col-4 mb-3 text-center">
				<img src="images/bicon.png">
				<p class="fw-bolder"><?php echo $row['Difference_pick_drop'];?></p>
				</div>
				<div class="col-4 text-end mb-3">
				<p class="fw-bolder"><?php echo $row['drop_city'];?><br>
				<span class="text text-primary"><?php echo date("h:i A", strtotime($row['drop_time']));?></span><br>
				<?php echo $dropdate;?></p>
				</div>
				<hr>
				<div class="col-4">
				<p class="text text-danger fw-bolder"><?php echo $lang['Amenities'];?></p>
				</div>
				<div class="col-4">
				<p class="text text-danger fw-bolder"><?php echo $lang['Review'];?></p>
				</div>
				<div class="col-4">
				<p class="text text-danger fw-bolder"><?php echo $lang['Cancellation_Policy'];?></p>
				<a href="seatlayout.php?bus_id=<?php echo $busId;?>&book_date=<?php echo $trip_date;?>&main_drop_pick_id=<?php echo $row['id_pickup_drop'];?>&fromCity=<?php echo $fromCity;?>&toCity=<?php echo $toCity;?>"><button class="btn btn-danger btn-set"><?php echo $lang['VIEW_SEATS'];?></button></a>
				</div>
				
            </div>
			</div>
        </div>
    </div>
<?php } ?>
