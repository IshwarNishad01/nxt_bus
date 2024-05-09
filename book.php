<?php 
require 'inc/Header.php';
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
                  <h3><?php echo $lang['Total_Booked_Report_Management'];?></h3>
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
				<div class="d-flex">
    <div class="col-md-3">
        <div class="form-group mb-3">
            
            <input type="date" class="form-control"  id="min_date"  required="">
			
			
			<div id="error_message" class="text-danger"></div>
        </div>
		
    </div>
	&nbsp;&nbsp;&nbsp;
	<div class="col-md-3">
        <div class="form-group mb-3">
            
            <input type="date" class="form-control"  id="max_date"  required="">
			
			
			<div id="errors_message" class="text-danger"></div>
        </div>
		
    </div>
	
	&nbsp;&nbsp;&nbsp;
	<div class="col-md-3">
        <div class="form-group mb-3">
            
            <select class="form-control" id="user_type">
			<option value=""><?php echo $lang['select_user_type'];?></option>
			<option value="USER"><?php echo $lang['USER'];?></option>
			<option value="AGENT"><?php echo $lang['AGENT'];?></option>
			</select>
			
			
			<div id="errors_type" class="text-danger"></div>
        </div>
		
    </div>
	&nbsp;&nbsp;&nbsp;
    <div class="form-group mb-3">
        <label></label>
        <button type="button" id="search_data" class="btn btn-primary"><?php echo $lang['Search'];?></button>
    </div>
	</div>
				<div class="table-responsive">
                <table class="display" id="basic-1">
                        <thead>
                          <tr>
                            <th><?php echo $lang['Sr_No'];?>.</th>
							
											
											<th><?php echo $lang['Bus_Name'];?></th>
											<th><?php echo $lang['Bus_Pickuptime'];?></th>
											<th><?php echo $lang['Bus_droptime'];?></th>
												<th><?php echo $lang['Total_Seat'];?></th>
												<th><?php echo $lang['Ticket_Price']; ?></th>
												<th><?php echo $lang['Seat_No'];?></th>
												<th><?php echo $lang['Passenger_Name'];?></th>
												<th><?php echo $lang['Passenger_Mobile'];?></th>
												<th><?php echo $lang['Book_status'];?></th>
												<th><?php echo $lang['Subtotal'];?></th>
												<th><?php echo $lang['Wallet_balance'];?></th>
												<th><?php echo $lang['Coupon_balance'];?></th>
												<th><?php echo $lang['Tax_amount'];?></th>
												<th><?php echo $lang['Total'];?></th>
												<th><?php echo $lang['Agent_Earning'];?></th>
												<th><?php echo $lang['Admin_Earning'];?></th>
												<th><?php echo $lang['Operator_Earning'];?></th>
												<th><?php echo $lang['Book_by'];?></th>
												
                          </tr>
                        </thead>
                        <tbody class="tblcontent">
                           <?php 
						   if($_SESSION['stype'] == 'sowner')
						   {
										$city = $bus->query("SELECT * FROM `tbl_book` where operator_id=".$sdata["id"]." order by id desc");
						   }
						   else 
						   {
							   $city = $bus->query("SELECT * FROM `tbl_book`  order by id desc");
						   }
										$i=0;
										while($row = $city->fetch_assoc())
										{
											$busdata = $bus->query("SELECT * from tbl_bus where id=".$row['bus_id']."")->fetch_assoc();
											$totalseat = $bus->query("SELECT COUNT(*) AS total_count, GROUP_CONCAT(seat_no) AS total_seats FROM tbl_book_pessenger WHERE book_id=" . $row['id'])->fetch_assoc();
											$i = $i + 1;
											?>
											<tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                
												
												
                                              
												
												<td>
                                                    <?php echo $busdata['title']; ?>
                                                </td>
												
												<td>
                                                    <?php $dateTime = new DateTime($row['bus_board_date']); 
													echo $dateTime->format('jS M Y, g:i A');
													?>
                                                </td>
												
												<td>
                                                    <?php 
                                                      $dateTime = new DateTime($row['bus_drop_date']);
echo $dateTime->format('jS M Y, g:i A');
													?>
                                                </td>
                                                
                                               <td>
                                                    <?php echo $row['total_seat']; ?>
                                                </td>
												
												<td>
                                                   <b><span class="text text-primary"> <?php echo $row['ticket_price'].$set['currency']; ?> </span></b>
                                                </td>
												
												
												<td><b><span class="text text-danger"><?php echo $totalseat['total_seats'];?></span></b></td>
												
												<td>
                                                    <?php echo $row['name']; ?>
                                                </td>
												<td>
                                                    <?php echo $row['ccode'].$row['mobile']; ?>
                                                </td>
												
												<td>
                                                    <span class="badge badge-<?php if($row['book_status']=='Cancelled'){echo 'danger';}elseif($row['book_status']=='Pending'){echo 'primary';}else{echo 'success';}?>"><?php echo $row['book_status']; ?></span>
                                                </td>
												
												<td>
                                                    <b><span class="text text-info"><?php echo $row['subtotal'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-info"><?php echo $row['wall_amt'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-info"><?php echo $row['cou_amt'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-info"><?php echo $row['tax_amt'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-success"><?php echo $row['total'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-danger"><?php echo $row['commission'].$set['currency'].'('.$row['comm_per'].'%)';?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-danger"><?php echo (($row['subtotal']-$row['cou_amt']) * $row['ope_commission']/100).$set['currency'].'('.$row['ope_commission'].'%)';?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-danger"><?php echo ($row['subtotal']-($row['cou_amt']+$row['commission'])) - (($row['subtotal']-$row['cou_amt']) * $row['ope_commission']/100).$set['currency'];?></span></b>
                                                </td>
												
												<td>
    <?php if ($row['user_type'] === 'USER') { ?>
        <span class="badge badge-primary"><?php echo $lang['USER'];?></span>
    <?php } else if ($row['user_type'] === 'AGENT') { ?>
        <span class="badge badge-danger"><?php echo $lang['AGENT'];?></span>
    <?php }else  { ?>
        <span class="badge badge-danger"><?php echo $lang['OPERATOR'];?></span>
    <?php } ?>
</td>
												
												
												
												
												
                                                
												
                                                
										  
                                                </tr>
											<?php 
										}
										?>
                          
                        </tbody>
                      </table>
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
  </body>

<script>

$(document).ready(function () {
    $("#search_data").click(function () {
        var selectedDate = $("#min_date").val();
        var selectedDates = $("#max_date").val();
		var selectedUserType = $("#user_type").val();

        var errorElement = $("#error_message");
        var errorElements = $("#errors_message");
		var errors_type = $("#errors_type");

        if (selectedDate === "" && selectedDates === "" && selectedUserType === "") {
            errorElement.text("<?php echo $lang['Please_select_a_date'];?>.");
            errorElements.text("<?php echo $lang['Please_select_a_date'];?>.");
			errors_type.text("<?php echo $lang['Please_select_a_user_type'];?>.");
        } else if (selectedDate !== "" && selectedDates === "" && selectedUserType === "") {
            errorElements.text("<?php echo $lang['Please_select_a_date'];?>.");
			errors_type.text("<?php echo $lang['Please_select_a_user_type'];?>.");
            errorElement.text("");
        } else if (selectedDate === "" && selectedDates !== "" && selectedUserType === "") {
            errorElement.text("<?php echo $lang['Please_select_a_date'];?>.");
			errors_type.text("<?php echo $lang['Please_select_a_user_type'];?>.");
            errorElements.text("");
        }else if (selectedDate === "" && selectedDates === "" && selectedUserType !== "") {
            errorElements.text("<?php echo $lang['Please_select_a_date'];?>.");
			errorElement.text("<?php echo $lang['Please_select_a_date'];?>.");
            errors_type.text("");
        }else if (selectedDate === "" && selectedDates !== "" && selectedUserType !== "") {
            errorElements.text("");
			errorElement.text("<?php echo $lang['Please_select_a_date'];?>.");
            errors_type.text("");
        }else if (selectedDate !== "" && selectedDates === "" && selectedUserType !== "") {
            errorElement.text("");
			errorElements.text("<?php echo $lang['Please_select_a_date'];?>.");
            errors_type.text("");
        }else if (selectedDate !== "" && selectedDates !== "" && selectedUserType === "") {
            errorElement.text("");
			errors_type.text("<?php echo $lang['Please_select_a_user_type'];?>.");
            errorElements.text("");
        } else if (new Date(selectedDate) > new Date(selectedDates)) {
            errorElement.text("<?php echo $lang['Start_date_cannot_be_greater_than_end_date'];?>.");
            errorElements.text("<?php echo $lang['Start_date_cannot_be_greater_than_end_date'];?>.");
        } else {
            errorElement.text(""); // Clear the error message.
            errorElements.text("");
			errors_type.text("");

            // Continue with your search logic here as the date is selected.
            // You can use the 'selectedDate' variable for further processing.
            $.ajax({
                type: "POST",
                url: "getbook.php",
                data: {
                    start_date: selectedDate,
                    end_date: selectedDates,
					user_type:selectedUserType
                },
                success: function (res) {
                    $(".tblcontent").html(res);
                }
            });
        }
    });
});

</script>
</html>