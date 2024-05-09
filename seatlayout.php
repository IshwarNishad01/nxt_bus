<?php 
require 'inc/Header.php';

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
					if ($book == 0) {
    $seatLayout .= "<input type='checkbox' class='book-checkbox' style='position: absolute; top: 5%; left: 5%; display: none; z-index: -1;' data-seat-number='$seatNumber' />";
}
                    $leftPosition = ($isSleeper ? '40%' : '40%') . ';'; // Default left position

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

?>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
    <?php require 'inc/Navbar.php';?>
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
       <?php require 'inc/Sidebar.php';?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-sm-6">
				<?php 
				if(isset($_GET["bus_id"]))
				{
					?>
					<h3><?php echo $lang['Seat_Layout_Management'];?></h3>
					<?php 
				}
				else if(isset($_GET['drop_step']))
				{
					?>
					<h3><?php echo $lang['Drop_Pickup_Point_Management'];?></h3>
					<?php 
				}
				
				
				else if(isset($_GET['pessenger_step']))
				{
					$fromcity = $bus->query("select * from tbl_city where id=".$_GET["fromCity"]."")->fetch_assoc();
					$tocity = $bus->query("select * from tbl_city where id=".$_GET["toCity"]."")->fetch_assoc();
					$selecteddate = $_GET["selecteddate"];
					$id_pickup_drop = $_GET['main_drop_pick_id'];
	                $pick = $bus->query("select b.ptime,b.id,b.point_id,p.title,p.address,p.mobile from tbl_sub_route_time as b,tbl_points as p  where b.status=1 and b.board_id=".$id_pickup_drop." and p.id = b.point_id and b.id=".$_GET["pickup_point_id"]."")->fetch_assoc();
					$drop = $bus->query("select b.ptime,b.id,b.point_id,p.title,p.address,p.mobile from tbl_drop_sub_route as b,tbl_points as p  where b.status=1 and b.board_id=".$id_pickup_drop." and p.id = b.point_id and b.id=".$_GET["drop_point_id"]."")->fetch_assoc();
					?>
					<h3><?php echo $fromcity['title'].' to '.$tocity['title']; ?></h3>
					<p><?php 
					$dateObj = new DateTime($selecteddate);

echo $dateObj->format('jS F Y');
					?></p>
					<?php 
				}
				?>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-default">
            <div class="row">
           <div class="col-sm-12">
                <div class="card">
				<div class="card-body">
				
				<div class="<?php if (isset($_GET["bus_id"])) {}else if(isset($_GET['drop_step']))
{}else if(isset($_GET['pessenger_step'])){}else{ echo "table-responsive";} ?>">
				<?php
if (isset($_GET["bus_id"])) {
    $data = $bus->query("select * from tbl_bus where id=" . $_GET["bus_id"] . "")->fetch_assoc();
    $decker = $data['decker'];
    
    $is_sleeper = $data['is_sleeper'];
    $driver_direction = $data['driver_direction'];
    $seatLayoutData = explode('$;', $data['seat_layout']);
	$bus_id = $_GET['bus_id'];
	$book_date = $_GET['book_date'];
    ?>
	
	<div class="d-flex">
	<?php 
	if($is_sleeper == 1)
	{
		?>
		<div class="float-end d-flex col-md-6">
    <div class="text-center passenger">
        <img src="images/sofabooked.png" height="23px">
        <p style="margin-bottom: 0;margin-top: 4px;font-size: 10px;"><?php echo $lang['Booked_Sleeper'];?></p>
    </div>
    <div class="text-center passenger">
        <img src="images/sofavisible.png" height="23px">
        <p style="margin-bottom: 0;margin-top: 4px;font-size: 10px;"><?php echo $lang['Available_Sleeper'];?></p>
    </div>
    <div class="text-center passenger">
        <img src="images/sofaladis.png" height="23px">
        <p style="margin-bottom: 0;margin-top: 4px;font-size: 10px;"><?php echo $lang['Ladis_Booked_Sleeper'];?></p>
    </div>
</div>

		<?php
	}
	else 
	{
		?>
		<div class="float-end d-flex col-md-6">
    <div class="text-center passenger">
        <img src="images/chairbooked.png" height="23px">
        <p style="margin-bottom: 0;margin-top: 4px;font-size: 10px;"><?php echo $lang['Booked_Seat'];?></p>
    </div>
    <div class="text-center passenger">
        <img src="images/chairvisible.png" height="23px">
        <p style="margin-bottom: 0;margin-top: 4px;font-size: 10px;"><?php echo $lang['Available_Seat'];?></p>
    </div>
    <div class="text-center passenger">
        <img src="images/chairladis.png" height="23px">
        <p style="margin-bottom: 0;margin-top: 4px;font-size: 10px;"><?php echo $lang['Ladis_Booked_Seat'];?></p>
    </div>
</div>
		<?php
	}
	?>
</div>
    <div class="d-flex date-Search">
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
	<button type="button" id="bookTicketButton"   class="btn btn-primary"><?php echo $lang['Proceed_To_Select_Stops'];?></button>
	</div>
    </div>

    <?php
}
else if(isset($_GET['drop_step']))
{
	?>
	<div id="error-message"></div>
	<div class="d-flex">
	<div class="col-6">
	<h4><?php echo $lang['Boarding_Points'];?></h4>
	<hr style="border:1px solid;">
	<?php 
	$id_pickup_drop = $_GET['main_drop_pick_id'];
	$pick = $bus->query("select b.ptime,b.id,b.point_id,p.title,p.address,p.mobile from tbl_sub_route_time as b,tbl_points as p  where b.status=1 and b.board_id=".$id_pickup_drop." and p.id = b.point_id");
	?>
	<div class="form-group">
  <?php 
  while ($row = $pick->fetch_assoc()) {
  ?>
    <label>
      <input type="radio" name="pick_points" value="<?php echo $row["id"];?>">
      <strong><?php echo $row['title'];?></strong><br>
      <?php echo $row['address'];?><br>
      <?php echo date("h:i A", strtotime($row['ptime']));?>
    </label><br><br>
  <?php 
  }
  ?>
</div>
</div>

<div class="col-6">
	<h4><?php echo $lang['Drop_Points'];?></h4>
	<hr style="border:1px solid;">
	<?php 
	$id_pickup_drop = $_GET['main_drop_pick_id'];
	$picks = $bus->query("select b.ptime,b.id,b.point_id,p.title,p.address,p.mobile from tbl_drop_sub_route as b,tbl_points as p  where b.status=1 and b.board_id=".$id_pickup_drop." and p.id = b.point_id");
	?>
	<div class="form-group">
  <?php 
  while ($rows = $picks->fetch_assoc()) {
  ?>
    <label>
      <input type="radio" name="drop_points" value="<?php echo $rows["id"];?>">
      <strong><?php echo $rows['title'];?></strong><br>
      <?php echo $rows['address'];?><br>
      <?php echo date("h:i A", strtotime($rows['ptime']));?>
    </label><br><br>
  <?php 
  }
  ?>
</div>
</div>

</div>
<div class="col-12 ">
<button type="button" id="nextsteppes"   class="btn btn-primary float-end"><?php echo $lang['Proceed_To_Fill_Pessenger_Data'];?></button>
</div>
	<?php
}
else if(isset($_GET['pessenger_step']))
{   
    $seatlist = explode(',', $_GET['seatlist']);
	$busprice = $bus->query("select * from tbl_bus where id=".$_GET["selbus_id"]."")->fetch_assoc();
	$board_drop_points = $bus->query("select * from tbl_board_drop_points where id=".$_GET['main_drop_pick_id']."")->fetch_assoc();
	$price = $busprice['tick_price'];
	$totalprice = $price * count($seatlist);
	$tax = $set['tax'];
	$tprice = $totalprice * $tax/100;
	$total_amt = $tprice + $totalprice;
	
	$pick_datetime = new DateTime($_GET['selecteddate'] . ' ' . $board_drop_points['btime']);
$drop_datetime = new DateTime($_GET['selecteddate'] . ' ' . $board_drop_points['dtime']);

// Check if the drop time is on the next date
if ($drop_datetime < $pick_datetime) {
    // Drop time is on the next date
	$pick_date = $pick_datetime->format('Y-m-d H:i:s');
    $next_date = $drop_datetime->modify('+1 day');
    $dropdate = $next_date->format('Y-m-d H:i:s');
} else {
    // Drop time is on the same date
    $dropdate = $drop_datetime->format('Y-m-d H:i:s');
	$pick_date = $pick_datetime->format('Y-m-d H:i:s');
}
	?>
	<div class="d-flex mb-3">
	<div class="col-4">
	<h5><?php echo $pick['title'];?> <br> <?php echo $fromcity['title'];?></h5>
	<p><?php echo date("h:i A", strtotime($pick['ptime']));?></p>
	</div>
	<div class="col-4 text-center">
	<img src="images/rightarr.png" height="80px"/>
	</div>
	<div class="col-4 text-end">
	<h5><?php echo $drop['title'];?> <br> <?php echo $tocity['title'];?></h5>
	<p><?php echo date("h:i A", strtotime($drop['ptime']));?></p>
	</div>
	</div>
	<form>
	<h4><?php echo $lang['Passenger_Details'];?></h4>
	<input type="hidden" name="uid" value="0"/>
	<input type="hidden" name="bus_id" value="<?php echo $_GET['selbus_id'];?>"/>
	<input type="hidden" name="operator_id" value="<?php echo $sdata['id'];?>"/>
	<input type="hidden" name="seatlist" value="<?php echo $_GET['seatlist'];?>"/>
	<input type="hidden" name="book_date" value="<?php echo $_GET['selecteddate'];?>"/>
	<input type="hidden" name="pickup_id" value="<?php echo $_GET['pickup_point_id'];?>"/>
	<input type="hidden" name="drop_id" value="<?php echo $_GET['drop_point_id'];?>"/>
	<input type="hidden" name="tax" value="<?php echo $tax;?>"/>
	<input type="hidden" name="tax_amt" value="<?php echo $tprice;?>"/>
	<input type="hidden" name="cou_amt" value="0"/>
	<input type="hidden" name="wall_amt" value="0"/>
	<input type="hidden" name="subtotal" value="<?php echo $totalprice;?>"/>
	<input type="hidden" name="total" value="<?php echo $total_amt;?>"/>
	<input type="hidden" name="total_seat" value="<?php echo count($seatlist);?>"/>
	<input type="hidden" name="payment_method_id" value="16"/>
	<input type="hidden" name="transaction_id" value="0"/>
	<input type="hidden" name="user_type" value="Operator"/>
	<input type="hidden" name="commission" value="0"/>
	<input type="hidden" name="comm_per" value="0"/>
	<input type="hidden" name="ope_commission" value="<?php echo $sdata['admin_commission'];?>"/>
	<input type="hidden" name="boarding_city" value="<?php echo $fromcity['title'];?>"/>
	<input type="hidden" name="drop_city" value="<?php echo $tocity['title'];?>"/>
	<input type="hidden" name="ticket_price" value="<?php echo $price;?>"/>
	<input type="hidden" name="bus_picktime" value="<?php echo $board_drop_points['btime'];?>"/>
	<input type="hidden" name="bus_droptime" value="<?php echo $board_drop_points['dtime'];?>"/>
	<input type="hidden" name="Difference_pick_drop" value="<?php echo $board_drop_points['differncetime'];?>"/>
	<input type="hidden" name="sub_pick_time" value="<?php echo $pick['ptime'];?>"/>
	<input type="hidden" name="sub_pick_place" value="<?php echo $pick['title'];?>"/>
	<input type="hidden" name="sub_pick_address" value="<?php echo $pick['address'];?>"/>
	<input type="hidden" name="sub_pick_mobile" value="<?php echo $pick['mobile'];?>"/>
	<input type="hidden" name="sub_drop_time" value="<?php echo $drop['ptime'];?>"/>
	<input type="hidden" name="sub_drop_place" value="<?php echo $drop['title'];?>"/>
	<input type="hidden" name="sub_drop_address" value="<?php echo  $drop['address'];?>"/>
	<input type="hidden" name="bus_board_date" value="<?php echo  $pick_date;?>"/>
	<input type="hidden" name="bus_drop_date" value="<?php echo  $dropdate;?>"/>
	<input type="hidden" name="type" value="book_ticket"/>
    <?php
    

    for ($i = 0; $i < count($seatlist); $i++) {
        $seat = $seatlist[$i];
		
    ?>
    <div class="row mb-3">
        <div class="col-4">
            <div class="form-group">
                <label><?php echo $lang['Passenger'];?> <?php echo $i + 1; ?> || <?php echo $lang['Seats'];?> - <?php echo $seat; ?></label>
                <input type="text" name="pname[]" placeholder="Enter Name" class="form-control" required />
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                <label><?php echo $lang['Age'];?></label>
                <input type="text" name="page[]" placeholder="Enter Age" class="form-control" required />
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                <label><?php echo $lang['Gender'];?></label>
                <select name="gender[]" class="form-control">
                    <option value=""><?php echo $lang['Select_a_gender'];?></option>
                    <option value="Male"><?php echo $lang['Male'];?></option>
                    <option value="Female"><?php echo $lang['Female'];?></option>
                </select>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
<h4><?php echo $lang['Contact_Details'];?></h4>
<div class="row mb-3">
<div class="col-4">
<div class="form-group">
                <label><?php echo $lang['Name'];?></label>
                <input type="text" name="name" placeholder="<?php echo $lang['Enter_Name'];?>" class="form-control" required />
            </div>
			</div>
			
			<div class="col-4">
<div class="form-group">
                <label><?php echo $lang['Email_Id'];?></label>
                <input type="email" name="email" placeholder="<?php echo $lang['Enter_email'];?>" class="form-control" required />
            </div>
			</div>
			
			<div class="col-2">
<div class="form-group">
                <label><?php echo $lang['Country_Code'];?> (+)</label>
                <input type="text" name="ccode" placeholder="<?php echo $lang['Enter_Country_Code'];?>" class="form-control" required />
            </div>
			</div>
			
			<div class="col-2">
<div class="form-group">
                <label><?php echo $lang['Contact_Details'];?></label>
                <input type="text" name="mobile" placeholder="<?php echo $lang['Enter_Contact'];?>" class="form-control" required />
            </div>
			</div>
</div>

<h4><?php echo $lang['Price_Details'];?></h4>
<div class="row mb-3">
<div class="col-8">
<div class="form-group">
                <label class="text-info fw-bold"><?php echo $lang['Price_Total_Seat'];?> <?php echo count($seatlist);?>)</label>
            </div>
			</div>
			<div class="col-4 text-end">
<div class="form-group">
                <label class="text-info fw-bold"><?php echo $totalprice.$set['currency'];?></label>
            </div>
			</div>
			<div class="col-8">
<div class="form-group">
                <label class="text-danger fw-bold"><?php echo $lang['Tax'];?>(<?php echo $tax;?>%)</label>
            </div>
			</div>
			<div class="col-4 text-end">
<div class="form-group">
                <label class="text-danger fw-bold"><?php echo $tprice.$set['currency'];?></label>
            </div>
			</div>
			<hr style="border: 1px solid;">
			<div class="col-8">
<div class="form-group">
                <label class="text-success fw-bold"><?php echo $lang['Total_Price'];?></label>
            </div>
			</div>
			<div class="col-4 text-end">
<div class="form-group">
                <label class="text-success fw-bold"><?php echo $total_amt.$set['currency'];?></label>
            </div>
			</div>
			</div>
			
			<button type="submit" id="nextsteppes"   class="btn btn-primary float-end"><?php echo $lang['Book_Ticket'];?></button>
			</form>
	<?php 
}
			?>
					  </div>
					  </div>
				 
                </div>
              
                
              </div>
            
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
       
      </div>
    </div>
    <!-- latest jquery-->
   <?php require 'inc/Footer.php'; ?>
    <!-- login js-->
	
	<script>
document.getElementById("nextsteppes").addEventListener("click", function() {
    var pickRadioButtons = document.getElementsByName("pick_points");
    var dropRadioButtons = document.getElementsByName("drop_points");
    var pickSelected = false;
    var dropSelected = false;

    // Check if any pick radio button is selected
    for (var i = 0; i < pickRadioButtons.length; i++) {
        if (pickRadioButtons[i].checked) {
            pickSelected = true;
            break;
        }
    }

    // Check if any drop radio button is selected
    for (var i = 0; i < dropRadioButtons.length; i++) {
        if (dropRadioButtons[i].checked) {
            dropSelected = true;
            break;
        }
    }

    // If both pick and drop points are selected, proceed to the next step
    if (pickSelected && dropSelected) {
        // Get the selected radio button values
        var pickPointId = document.querySelector('input[name="pick_points"]:checked').value;
        var dropPointId = document.querySelector('input[name="drop_points"]:checked').value;

        // Redirect to the desired URL with the selected values
        window.location.href = "seatlayout.php?selbus_id=<?php echo $_GET["selbus_id"];?>&seatlist=<?php echo $_GET["seatlist"];?>&selecteddate=<?php echo $_GET["selecteddate"];?>&fromCity=<?php echo $_GET["fromCity"];?>&toCity=<?php echo $_GET["toCity"];?>&main_drop_pick_id=<?php echo $_GET["main_drop_pick_id"];?>&pessenger_step=1&pickup_point_id=" + pickPointId + "&drop_point_id=" + dropPointId;
    } else {
        // Display an error message in a div
        var errorDiv = document.getElementById("error-message");
        errorDiv.innerHTML = "<?php echo $lang['Please_select_both_pick_and_drop_points'];?>.";
        errorDiv.style.color = "red";
    }
});
</script>

	<script>





$(document).ready(function () {
    var selectedSeats = [];
    var $bookTicketButton = $('#bookTicketButton'); // Replace with the actual ID or selector of your button

    // Hide the button by default
    $bookTicketButton.css('display', 'none');

    $('.imgclick').on('click', function () {
        var $checkbox = $(this).siblings('.book-checkbox');
        var isBooked = parseInt($(this).data('book'));
        var seatNumber = $checkbox.data('seat-number');
		var id = $(this).data('id');
		var date = $(this).data('date');
		var seat = $(this).data('seat');
         
        if (isBooked === 0) {
            // Toggle checkbox visibility
            $checkbox.toggle();

            // Change image source based on checkbox state
			<?php
if($is_sleeper == 1)
{	
			?>
            var imageSource = $checkbox.is(':visible') ? 'images/sofa.png' : 'images/sofavisible.png';
<?php } else { ?> 
var imageSource = $checkbox.is(':visible') ? 'images/seat.png' : 'images/chairvisible.png';
<?php } ?>
            $(this).attr('src', imageSource);

            // Update selected seats array
            if ($checkbox.is(':visible')) {
                selectedSeats.push(seatNumber);
            } else {
                // Remove seat from array if unselected
                selectedSeats = selectedSeats.filter(function (seat) {
                    return seat !== seatNumber;
                });
            }

            // Display selected seats as a comma-separated string (you can use this string as needed)
            var selectedSeatsString = selectedSeats.join(',');
            

            // Show/hide "Book Ticket" button based on the selected seats
            $bookTicketButton.css('display', selectedSeats.length > 0 ? 'inline-block' : 'none');
        }
		else 
		{
			
			$.ajax({
                type: "POST",
                url: "getpessenger.php",
                data: {
                    book_date: date,
                    bus_id: id,
                    seat_no: seat
                },
                success: function (res) {
                    $(".loaddata").html(res);
                }
            });
		}
    });

    // Add click event handler for the "Book Ticket" button
    $bookTicketButton.on('click', function () {
    // Access selected seat numbers from the selectedSeats array
    var seat = selectedSeats.join(',');
    var date = "<?php echo $_GET['book_date'];?>";

    // Redirect to the desired URL with parameters
    window.location.href = 'seatlayout.php?selbus_id=<?php echo $_GET["bus_id"];?>&seatlist=' + seat + '&selecteddate=' + date + '&drop_step=1&main_drop_pick_id=<?php echo $_GET["main_drop_pick_id"];?>&fromCity=<?php echo $_GET["fromCity"];?>&toCity=<?php echo $_GET["toCity"];?>';

    // Perform additional actions, such as submitting the form or making an AJAX request
});
});

</script>

  </body>


</html>