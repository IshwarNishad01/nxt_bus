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
                  <h3><?php echo $lang['Boarding_Sub_Route_Point_Time_Management'];?></h3>
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
                 <?php 
				 if(isset($_GET['id']))
				 {
					 $data = $bus->query("select * from tbl_sub_route_time where board_id=".$_GET['id']."")->fetch_assoc();
					 $citylist = $bus->query("select bo.bus_id,bo.bpoint,bu.title,bu.bno,bo.id as boaring_id,c.title as city_name,c.id as city_id,bo.btime from tbl_board_drop_points as bo,tbl_bus as bu,tbl_city as c where bu.id=bo.bus_id and c.id=bo.bpoint and bo.id=".$_GET['id']."")->fetch_assoc();
					 ?>
					 <form method="POST"  enctype="multipart/form-data">
								
								<div class="row">
								<h5 class="mb-3"><?php echo $citylist["title"].'('.$citylist['bno'].') ---> '.$citylist['city_name'].'( Pick up Time : '.date("g:i A", strtotime($citylist['btime'])).')';?></h5>
								
								<div class="path_contain mb-3">
								<input type="hidden" name="hidden_boarding_id" value="<?php echo $_GET['id'];?>"/>
								 <input type="hidden" name="type" value="edit_subroute"/>
								<?php 
								$data = $bus->query("select * from tbl_sub_route_time where board_id=".$_GET['id']."");
								$po = 0;
								while($rows = $data->fetch_assoc())
								{
									$po = $po + 1;
								?>
								<div class="row">
								<div class="col-md-3">
								<div class="form-group mb-3">
                                   <input type="hidden" name="id[]" value="<?php echo $rows['id'];?>"/>
                                        <label  id="basic-addon1"><?php echo $lang['Boarding_Points'];?></label>
                                    
                                 <select name="exist_rpoint[]"  class="form-control routepoint select2-point-select" required>
								  <option value=""><?php echo $lang['Select_A_Boarding_Points'];?></option>
<?php
$point = $bus->query("select * from tbl_points where city_id=".$citylist["city_id"]."");
while($row = $point->fetch_assoc())
{
	?>
	<option value="<?php echo $row["id"];?>" <?php if($rows['point_id'] == $row['id']){echo 'selected';}?>><?php echo $row["title"];?></option> 
	<?php 
	
}
?>
								  </select>
                                	
								</div>
								</div>
								
								<div class="col-md-3">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Sub_Route_Time'];?></label>
                                     <?php 
									$timeFromDatabase = $rows["ptime"];

// Format it to 'H:i:S' format (e.g., '03:00:00')
$formattedTime = date("H:i:S", strtotime($timeFromDatabase));
									?>
                                  <input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Sub_Route_Time'];?>"  name="exist_btime[]" value="<?php echo $formattedTime;?>" required>
                                
								</div>
								</div>
                                    <div class="col-md-3">
                                   <div class="form-group mb-3">
                                   
                                        <label  for="inputGroupSelect01"><?php echo $lang['Select_Status'];?></label>
                                    
                                    <select class="form-control" name="exist_status[]" id="inputGroupSelect01" required>
                                        <option value=""><?php echo $lang['Select_Status'];?></option>
                                        <option value="1" <?php if($rows['status'] == 1){echo 'selected';}?>><?php echo $lang['Publish'];?></option>
                                        <option value="0" <?php if($rows['status'] == 0){echo 'selected';}?>><?php echo $lang['UnPublish'];?></option>
                                       
                                    </select>
                                </div>
								</div>
								<div class="col-md-3">
								<div class="form-group mt-8">
								<label  id="basic-addon1"></label>
								<?php
if($po == 1)
{	
								?>
								<button type="button" class="btn btn-primary add-route"><?php echo $lang['Add_New_Route'];?></button>
<?php } else { ?>
<button type="button" class="btn del btn-danger remove-point" data-id="<?php echo $rows['id'];?>" data-type="sub_pick_route_delete"><?php echo $lang['Remove_Routes'];?></button>
<?php } ?>
								</div>
								</div>
								</div>
								<?php } ?>
								</div>
								</div>
                                    <button type="submit" class="btn btn-primary"><?php echo $lang['Update_Sub_Route_With_Time_Pick_up_Point'];?></button>
                                </form>
					 <?php 
				 }
				 else 
				 {
				 ?>
                  <form method="POST"  enctype="multipart/form-data">
								
								<div class="row">
								<div class="col-md-12">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Boarding_Points'];?></label>
                                    
                                  <select name="board_id" class="form-control boardselect select2-board-select">
								  <option value=""><?php echo $lang['Select_A_Boarding_Points'];?></option>
								  <?php 
								  $citylist = $bus->query("select bo.bus_id,bo.bpoint,bu.title,bu.bno,bo.id as boaring_id,c.title as city_name,bo.btime from tbl_board_drop_points as bo,tbl_bus as bu,tbl_city as c where bu.id=bo.bus_id and c.id=bo.bpoint");
								  while($row = $citylist->fetch_assoc())
								  {
								  ?>
								 <option value="<?php echo $row["boaring_id"];?>" data-city-id="<?php echo $row["bpoint"];?>"><?php echo $row["title"].'('.$row['bno'].') ---> '.$row['city_name'].'( Pick up Time : '.date("g:i A", strtotime($row['btime'])).')';?></option> 
								  <?php } ?>
								  </select>
                            <input type="hidden" name="type" value="add_subroute"/>
								</div>
								</div>
								<div class="path_contain">
								<div class="row">
								<div class="col-md-3">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Enter_Sub_Route_Point'];?></label>
                                    
                                 <select name="rpoint[]"  class="form-control routepoint select2-point-select" required>
								  
								  </select>
                                	
								</div>
								</div>
								
								<div class="col-md-3">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Sub_Route_Time'];?></label>
                                    
                                  <input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Sub_Route_Time'];?>"  name="btime[]" required>
                                
								</div>
								</div>
                                    <div class="col-md-3">
                                   <div class="form-group mb-3">
                                   
                                        <label  for="inputGroupSelect01"><?php echo $lang['Select_Status'];?></label>
                                    
                                    <select class="form-control" name="status[]" id="inputGroupSelect01" required>
                                        <option value=""><?php echo $lang['Select_Status'];?></option>
                                        <option value="1"><?php echo $lang['Publish'];?></option>
                                        <option value="0"><?php echo $lang['UnPublish'];?></option>
                                       
                                    </select>
                                </div>
								</div>
								<div class="col-md-3">
								<div class="form-group mt-8">
								<label  id="basic-addon1"></label>
								
								<button type="button" class="btn btn-primary add-route"><?php echo $lang['Add_New_Route'];?></button>
								</div>
								</div>
								</div>
								</div>
								</div>
                                    <button type="submit" class="btn btn-primary"><?php echo $lang['Add_Sub_Route_With_Time_Pick_up_Point'];?></button>
                                </form>
				 <?php } ?>
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
   <?php 
   if(isset($_GET['id']))
   {
	   ?>
	      <script>
   $(document).ready(function() {
    // Initialize select2 on the existing select elements
    

    // Add new route row
    $(document).on("click", ".add-route", function() {
        var newRowHtml = '<div class="row">' +
            '<div class="col-md-3">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Boarding_Points'];?></label>' +
            '<select name="new_rpoint[]" class="form-control routepoint select2-point-select" required>' +
            '<option value=""><?php echo $lang['Select_A_Boarding_Points'];?></option>' +
            '<?php 
			$point = $bus->query("select * from tbl_points where city_id=".$citylist["city_id"]."");
while($row = $point->fetch_assoc())
{
	echo '<option value="'.$row["id"].'">'.$row["title"].'</option>';
	
}
            ?>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Sub_Route_Time'];?></label>' +
            '<input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Sub_Route_Time'];?>" name="new_btime[]" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<div class="form-group mb-3">' +
            '<label for="inputGroupSelect01"><?php echo $lang['Select_Status'];?></label>' +
            '<select class="form-control" name="new_status[]" id="inputGroupSelect01" required>' +
            '<option value=""><?php echo $lang['Select_Status'];?></option>' +
            '<option value="1"><?php echo $lang['Publish'];?></option>' +
            '<option value="0"><?php echo $lang['UnPublish'];?></option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<div class="form-group mt-8">' +
            '<label id="basic-addon1"></label>' +
            '<button type="button" class="btn btn-danger remove-route"><?php echo $lang['Remove_Routes'];?></button>' +
            '</div>' +
            '</div>' +
            '</div>';

        $('.path_contain').append(newRowHtml);

        // Initialize select2 on the newly added select element
        $('.path_contain .row:last-child .select2-point-select').select2();
		
		$(" .time").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
            placeholder: "<?php echo $lang['Select_Time'];?>",
        });
		$('.select2-point-select').select2({
        placeholder: '<?php echo $lang['Choose_Pickup_Point'];?>'
    });
	
	
		
    });

    // Remove a route row
    $(document).on("click", ".remove-route", function() {
        $(this).closest('.row').remove();
    });
});
</script>
	   <?php 
   }
   else 
   {
	   ?>
   <script>
   $(document).ready(function() {
    // Initialize select2 on the existing select elements
    

    // Add new route row
    $(document).on("click", ".add-route", function() {
        var newRowHtml = '<div class="row">' +
            '<div class="col-md-3">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Boarding_Points'];?></label>' +
            '<select name="rpoint[]" class="form-control routepoint select2-point-select" required>' +
            '<!-- Options for the select element -->' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Sub_Route_Time'];?></label>' +
            '<input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Sub_Route_Time'];?>" name="btime[]" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<div class="form-group mb-3">' +
            '<label for="inputGroupSelect01"><?php echo $lang['Select_Status'];?></label>' +
            '<select class="form-control" name="status[]" id="inputGroupSelect01" required>' +
            '<option value=""><?php echo $lang['Select_Status'];?></option>' +
            '<option value="1"><?php echo $lang['Publish'];?></option>' +
            '<option value="0"><?php echo $lang['UnPublish'];?></option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<div class="form-group mt-8">' +
            '<label id="basic-addon1"></label>' +
            '<button type="button" class="btn btn-danger remove-route"><?php echo $lang['Remove_Routes'];?></button>' +
            '</div>' +
            '</div>' +
            '</div>';

        $('.path_contain').append(newRowHtml);

        // Initialize select2 on the newly added select element
        $('.path_contain .row:last-child .select2-point-select').select2();
		
		$(" .time").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
            placeholder: "<?php echo $lang['Select_Time'];?>",
        });
		$('.select2-point-select').select2({
        placeholder: '<?php echo $lang['Choose_Pickup_Point'];?>'
    });
	
	 var selectedOption = $('.boardselect option:selected');
        var id = selectedOption.attr('data-city-id');

        if (id) {
            // Only make the AJAX request if a valid option is selected
            $.ajax({
                type: 'post',
                url: 'getroute.php',
                data: {
                    mainid: id
                },
                success: function(response) {
                    // Fill the related routepoint dropdown with the response
                    $('.path_contain .row:last-child .routepoint').html(response);
                }
            });
        } else {
            // Clear the related routepoint dropdown if no option is selected
            $('.path_contain .row:last-child .routepoint').html('');
        }
		
    });

    // Remove a route row
    $(document).on("click", ".remove-route", function() {
        $(this).closest('.row').remove();
    });
});
</script>
   <?php } ?>
    <!-- login js-->
  </body>


</html>