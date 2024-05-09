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
                  <h3><?php echo $lang['Book_Ticket_Management'];?></h3>
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
                                        <div class="row">
										
										
										<div id="validationMessage" style="color: red;"></div>
                                        <div class="form-group col-3">
                                            <label><?php echo $lang['From_City'];?></label>
                                            <select name="f_city" id="f_city" class="form-control select2-multi-select">
											<option value=""><?php echo $lang['Select_A_City'];?></option>
											<?php 
											$cit = $bus->query("select * from tbl_city where status=1");
											while($row = $cit->fetch_assoc())
											{
												?>
												<option value="<?php echo $row['id'];?>"><?php echo $row['title'];?></option>
												<?php 
											}
											?>
											</select>
                                        </div>
										
										
										
										  <div class="form-group col-3">
                                            <label><?php echo $lang['To_City'];?></label>
                                            
											<select name="t_city" id="t_city" class="form-control select2-multi-select">
											<option value=""><?php echo $lang['Select_A_City'];?></option>
											<?php 
											$cit = $bus->query("select * from tbl_city where status=1");
											while($row = $cit->fetch_assoc())
											{
												?>
												<option value="<?php echo $row['id'];?>"><?php echo $row['title'];?></option>
												<?php 
											}
											?>
											</select>
											
                                        </div>
										
										<div class="form-group col-3">
                                            <label><?php echo $lang['Journey_Date'];?></label>
                                             <?php 
			$timestamp = date("Y-m-d");
			?>
											<input type="text" class="form-control"  id="datepicker" value="<?php echo $timestamp; ?>" required="">
											
                                        </div>
                                        
										<div class="form-group col-3" style="    margin-top: 30px;">
										<label></label>
                                        <button  type="button" id="Search" class="btn btn-primary"><?php echo $lang['Search_Bus'];?></button>
                                    </div>
                                    </div>
									</div>
                                    
									
                             
				 
                </div>
              
                
              </div>
            
            </div>
			
			 <div class="row card_maintain">
    
	
	
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
   
  <script src="assets/js/datepicker/date-picker/datepicker.js"></script>
<style>
.btn-set
{
	    position: absolute;
    bottom: -48px;
    right: -21px;
}
h4.b_title {
    font-size: 17px;
}
</style>
  <script>
  $(".card_maintain").hide();
  (function ($) {
    $.fn.datepicker.language['en'] = {
        days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        daysShort: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        daysMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        months: ['January','February','March','April','May','June', 'July','August','September','October','November','December'],
        monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        today: 'Today',
        clear: 'Clear',
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii aa',
        firstDay: 0
    };
})(jQuery);
    $(document).ready(function(){
      // Initialize the datepicker
      $("#datepicker").datepicker({
        language: 'en',
        minDate: new Date() // Now can select only dates, which goes after today
    });
    });
  </script>
<script>
    $(document).ready(function(){
        $("#Search").on("click", function(){
            var fromCity = $("#f_city").val();
            var toCity = $("#t_city").val();
            var journeyDate = $("#datepicker").val();
            var validationMessageDiv = $("#validationMessage");
            // Clear previous validation messages
            validationMessageDiv.text("");

            // Validation: Check if both "From City" and "To City" are selected
            if (fromCity === "" || toCity === "") {
                validationMessageDiv.text("<?php echo $lang['Please_select_both_From_City_and_To_City'];?>.");
                return;
            }

            // Validation: Check if "From City" and "To City" are different
            if (fromCity === toCity) {
                validationMessageDiv.text("<?php echo $lang['Please_select_different_cities_for_From_City_and_To_City'];?>.");
                return;
            }

            // Validation: Check if Journey Date is selected and not earlier than the current date
            if (journeyDate === "") {
                validationMessageDiv.text("<?php echo $lang['Please_select_Journey_Date'];?>.");
                return;
            }


            $.ajax({
				type:"POST",
				url:"getbus.php",
				data:
				{
					vendor_id:<?php echo $sdata["id"];?>,
					fromCity:fromCity,
					toCity:toCity,
					journeyDate:journeyDate
				},
				success:function(res)
				{
					$(".card_maintain").show();
					$(".card_maintain").html(res);
				}
			})
        });
    });
</script>

</html>