<?php
require 'inc/Config.php';
if(isset($_POST['bus_id']) && isset($_POST['book_date']))
{
$bus_id = $_POST['bus_id'];
$book_date = $_POST['book_date'];

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

function generateSeatLayout($seatLayoutData, $seatType, $isSleeper, $bus_id, $book_date, $bus)
{
    $seatLayout = "";
    foreach ($seatLayoutData as $layout) {
        if (strpos($layout, $seatType) !== false) {
            $seatLayoutArray = explode(',', str_replace(',' . $seatType, '', $layout));
            $seatLayout .= "<tr>";
            foreach ($seatLayoutArray as $seatNumber) {
                $seatLayout .= "<td style='position: relative;'>";
                if (empty($seatNumber)) {
                    $seatLayout .= "<img src='images/white.jpg' width='50px'/>";
                } else {
					$is_book = isSeatBooked($bus,$bus_id, $book_date, $seatNumber);
					$gender = getgender($bus,$bus_id, $book_date, $seatNumber);
					if(!$is_book)
					{
						$book =0;	
                    $imageSource = $isSleeper ? 'images/sofavisible.png' : 'images/chairvisible.png';
					}
					else 
					{
						$book =1;
						if($gender == 'FEMALE')
						{
							$imageSource = $isSleeper ? 'images/sofaladis.png' : 'images/chairladis.png';
						}
						else 
						{
						$imageSource = $isSleeper ? 'images/sofabooked.png' : 'images/chairbooked.png';
						}
					}
                    $seatLayout .= "<img src='$imageSource' data-book='$book' data-id='$bus_id' data-date='$book_date' data-seat='$seatNumber' class='imgclick' width='50px'/>";
                    $leftPosition = ($isSleeper ? '30%' : '40%') . ';'; // Default left position

                    // Check if $seatNumber is a 2-digit number
                    if (strlen($seatNumber) == 2) {
                        $leftPosition = ($isSleeper ? '30%' : '30%') . ';';
                    }

                    $seatLayout .= "<p style='position: absolute; top: " . ($isSleeper ? '38%' : '20%') . "; font-size: 15px; left: " . $leftPosition . " font-weight: 800;'>" . $seatNumber . "</p>";
                }
                $seatLayout .= "</td>";
            }
            $seatLayout .= "</tr>";
        }
    }
    return $seatLayout;
}




$data = $bus->query("select * from tbl_bus where id=" . $bus_id . "")->fetch_assoc();
    $decker = $data['decker'];
    
    $is_sleeper = $data['is_sleeper'];
    $driver_direction = $data['driver_direction'];
    $seatLayoutData = explode('$;', $data['seat_layout']);
	?>
	<div class="col-sm-3">
            <h5><?php echo $lang['LOWER_BERTH'];?></h5>

            <table class="display">
                <!-- Your header rows here -->
                
                
                <?php echo generateSeatLayout($seatLayoutData, 'LOWER', $is_sleeper,$bus_id,$book_date,$bus); ?>
            </table>
        </div>
    <?php if($decker != 1)
	{
		?>
        <div class="col-sm-3">
            <h5><?php echo $lang['UPPER_BERTH'];?></h5>

            <table class="display">
                <!-- Your header rows here -->
               
               
                <?php echo generateSeatLayout($seatLayoutData, 'UPPER', $is_sleeper,$bus_id,$book_date,$bus); ?>
            </table>
        </div>
	<?php } ?>
	<div class="col-sm-6">
	<h5><?php echo $lang['Passenger_Details'];?></h5>
	<div class="loaddata">
	<div class="passenger">
	<?php echo $lang['After_Click_Book_Ticket_You_Received_Pessenger_Details'];?>.
	</div>
	</div>
	</div>
	<?php 
}
?>
