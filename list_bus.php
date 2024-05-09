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
					<h3><?php echo $lang['Ticket_List_Management'];?></h3>
					<?php 
				}
				else 
				{
				?>
                  <h3><?php echo $lang['Bus_List_Management'];?></h3>
				<?php } ?>
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
				
				<div class="table-responsive">
				<?php
if (isset($_GET["bus_id"])) {
    $data = $bus->query("select * from tbl_bus where id=" . $_GET["bus_id"] . "")->fetch_assoc();
    $decker = $data['decker'];
    
    $is_sleeper = $data['is_sleeper'];
    $driver_direction = $data['driver_direction'];
    $seatLayoutData = explode('$;', $data['seat_layout']);
	$bus_id = $_GET['bus_id'];
	$book_date = date("Y-m-d");
    ?>
	<div class="d-flex">
    <div class="col-md-3">
        <div class="form-group mb-3">
            
            <input type="date" class="form-control"  id="book_date" value="<?php echo $book_date; ?>" required="">
			<input type="hidden" class="form-control"  id="bus_id" value="<?php echo $_GET["bus_id"];?>" required="">
			<div id="error_message" class="text-danger"></div>
        </div>
    </div>
    <div class="form-group mb-3">
        <label></label>
        <button type="button" id="search_data" class="btn btn-primary"><?php echo $lang['Search'];?></button>
    </div>
	</div>
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
	</div>
    </div>

    <?php
}
				else 
				{
				?>
                <table class="display" id="basic-1">
                        <thead>
                          <tr>
                            <th><?php echo $lang['Sr_No'];?>.</th>
							
											<th><?php echo $lang['Bus_Name'];?></th>
											<th><?php echo $lang['Bus_Image'];?></th>
												<th><?php echo $lang['Bus_Status'];?></th>
												<th><?php echo $lang['Bus_Sleeper'];?> ?</th>
												<th><?php echo $lang['Bus_Decker_Layout'];?></th>
												<th><?php echo $lang['Action'];?></th>
                          </tr>
                        </thead>
                        <tbody>
                           <?php 
										$city = $bus->query("select id,title,bus_img,bstatus,is_sleeper,decker from tbl_bus where operator_id=".$sdata['id']."");
										$i=0;
										while($row = $city->fetch_assoc())
										{
											$i = $i + 1;
											?>
											<tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['title']; ?>
                                                </td>
												
												
                                                <td class="align-middle">
                                                   <img src="<?php echo $row['bus_img']; ?>" width="70" height="80"/>
                                                </td>
                                                
                                               
												<?php if($row['bstatus'] == 1) { ?>
												
                                                <td><span class="badge badge-success"><?php echo $lang['Publish'];?></span></td>
												<?php } else { ?>
												
												<td>
												<span class="badge badge-danger"><?php echo $lang['UnPublish'];?></span></td>
												<?php } ?>
												
												<?php if($row['is_sleeper'] == 1) { ?>
												
                                                <td><span class="badge badge-success"><?php echo $lang['Yes'];?></span></td>
												<?php } else { ?>
												
												<td>
												<span class="badge badge-danger"><?php echo $lang['No'];?></span></td>
												<?php } ?>
												
												
												
												<?php if($row['decker'] == 1) { ?>
												
                                                <td><span class="badge badge-success"><?php echo $lang['Single_Decker'];?></span></td>
												<?php } else { ?>
												
												<td>
												<span class="badge badge-danger"><?php echo $lang['Double_Decker'];?></span></td>
												<?php } ?>
												
												
                                                <td style="white-space: nowrap; width: 15%;"><div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
                                           <div class="btn-group btn-group-sm" style="float: none;">
										   <a href="add_bus.php?id=<?php echo $row['id'];?>" class="btn btn-info" style="float: none; margin: 5px;"><i class="fa fa-bus"></i></a>
										   
										   <a href="list_bus.php?bus_id=<?php echo $row['id'];?>" class="btn btn-warning" style="float: none; margin: 5px;"><i class="fa fa-ticket"></i></a>
										   
										   </div>
                                           
                                       </div></td>
                                                </tr>
											<?php 
										}
										?>
                          
                        </tbody>
                      </table>
				<?php } ?>
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
$(document).ready(function () {
    $("#search_data").click(function () {
        var selectedDate = $("#book_date").val();
		var bus_id = $("#bus_id").val();
        var errorElement = $("#error_message");

        if (selectedDate === "") {
            errorElement.text("<?php echo $lang['Please_select_a_date'];?>.");
            // You can style the error message as needed using CSS.
        } else {
			
            errorElement.text(""); // Clear the error message.
            // Continue with your search logic here as the date is selected.
            // You can use the 'selectedDate' variable for further processing.
			$.ajax({
    type: "POST",
    url: "getbookdata.php",
    data: {
        book_date: selectedDate,
        bus_id: bus_id
    },
    success: function (res) {
        $(".date-Search").html(res);
    }
});
        }
    });
});




$(document).ready(function () {
    // Attach the click event handler to a parent element that exists in the DOM
    // (you can replace "document" with a more specific parent selector if available)
    $(document).on('click', '.imgclick', function () {
        var book = $(this).data('book');
        var date = $(this).data('date');
        var seat = $(this).data('seat');
        var id = $(this).data('id');
        
        if (book == 1) {
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
});

</script>
  </body>


</html>