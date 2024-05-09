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
                  <h3><?php echo $lang['Daily_Reports'];?></h3>
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
            <?php 
			$timestamp = date("Y-m-d");
			?>
            <input type="date" class="form-control"  id="check_date" value="<?php echo $timestamp; ?>" required="">
			
			<div id="error_message" class="text-danger"></div>
        </div>
    </div>
    <div class="form-group mb-3">
        <label></label>
        <button type="button" id="search_data" class="btn btn-primary"><?php echo $lang['Search'];?></button>
    </div>
	</div>
				<div class="table-responsive">
                <table class="display table table-striped table-bordered " >
                        <thead>
                          <tr>
                            <th><?php echo $lang['Particulars'];?></th>
							
											<th><?php echo $lang['Value'];?></th>
												
                          </tr>
                        </thead>
                        <tbody class="tblcontent">
                           <?php 
						   if($_SESSION['stype'] == 'sowner')
						   {
							   $totalbook = $bus->query("select count(*) as total_book from tbl_book where book_date='".$timestamp."' and operator_id=".$sdata["id"]."")->fetch_assoc();
						   $totalcom = $bus->query("select count(*) as total_complete from tbl_book where book_date='".$timestamp."' and book_status='Completed' and operator_id=".$sdata["id"]."")->fetch_assoc();
						   $totalcan = $bus->query("select count(*) as total_complete from tbl_book where book_date='".$timestamp."' and book_status='Cancelled' and operator_id=".$sdata["id"]."")->fetch_assoc();
						   $sales  = $bus->query("SELECT sum((subtotal -(cou_amt+commission)) - ((subtotal -cou_amt) * ope_commission/100)) as total_earning FROM `tbl_book` where book_status='Completed' and book_date='".$timestamp."'")->fetch_assoc();
	
	
	$bs=0;
	if(empty($sales['total_earning'])){}else {$bs = number_format((float)($sales['total_earning']), 2, '.', ''); }
	
	
						   }
						   else 
						   {
						   $totalbook = $bus->query("select count(*) as total_book from tbl_book where book_date='".$timestamp."'")->fetch_assoc();
						   $totalcom = $bus->query("select count(*) as total_complete from tbl_book where book_date='".$timestamp."' and book_status='Completed'")->fetch_assoc();
						   $totalcan = $bus->query("select count(*) as total_complete from tbl_book where book_date='".$timestamp."' and book_status='Cancelled'")->fetch_assoc();
						   $sales  = $bus->query("SELECT sum(subtotal+tax_amt-cou_amt) as total_earning FROM `tbl_book` where book_status='Completed' and book_date='".$timestamp."'")->fetch_assoc();
	
	
	$bs=0;
	if(empty($sales['total_earning'])){}else {$bs = number_format((float)($sales['total_earning']), 2, '.', ''); }
	
	
						   }
									?>	
											<tr>
											
											<td>
                                                   <b> <?php echo $lang['Total_Booked_Tickets'];?></b>
                                                </td>
												
                                                <td>
                                                    <b><span class="text text-warning"><?php echo $totalbook['total_book']; ?></span></b>
                                                </td>
                                                </tr>
												
												<tr>
												<td>
                                                   <b> <?php echo $lang['Total_Completed_Tickets'];?></b>
                                                </td>
												
                                                <td>
                                                   <b> <span class="text text-success"><?php echo $totalcom['total_complete']; ?></span></b>
                                                </td>
												
                                                </tr>
												
												<tr>
												<td>
                                                   <b> <?php echo $lang['Total_Cancelled_Tickets'];?></b>
                                                </td>
												
                                                <td>
                                                   <b> <span class="text text-danger"><?php echo $totalcan['total_complete']; ?></span></b>
                                                </td>
												
                                                </tr>
												
												<tr>
												<td>
                                                   <b> <?php echo $lang['Total_Sales'];?></b>
                                                </td>
												
                                                <td>
                                                   <b> <span class="text text-primary"><?php echo $bs.$set['currency']; ?></span></b>
                                                </td>
												
                                                </tr>
												
												
											
                          
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
		
        var selectedDate = $("#check_date").val();
		
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
    url: "getdaily.php",
    data: {
        book_date: selectedDate
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