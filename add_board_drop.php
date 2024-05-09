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
                  <h3><?php echo $lang['Boarding_Dropping_Point_Management'];?></h3>
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
					 $data = $bus->query("select * from tbl_board_drop_points where bus_id=".$_GET['id']."")->fetch_assoc();
					 ?>
					   <form method="POST" id="pointForm" enctype="multipart/form-data">
				                <div class="row">
								<div class="col-md-12">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Select_Bus'];?></label>
                                    
                                  <select name="bus_id" class="form-control select2-bus-select">
								  <option value=""><?php echo $lang['Select_A_Bus'];?></option>
								  <?php 
								  $citylist = $bus->query("select * from tbl_bus");
								  while($row = $citylist->fetch_assoc())
								  {
								  ?>
								 <option value="<?php echo $row["id"];?>" <?php if($data["bus_id"] == $row["id"]){echo 'selected';}?>><?php echo $row["title"];?></option> 
								  <?php } ?>
								  </select>
                            <input type="hidden" name="type" value="edit_bdpoints"/>
								</div>
								</div>
								<input type="hidden" name="hidden_bus_id" value="<?php echo $_GET['id'];?>"/>
								<div class="wow">
								<?php 
								$data = $bus->query("select * from tbl_board_drop_points where bus_id=".$_GET['id']."");
								$po = 0;
								while($rows = $data->fetch_assoc())
								{
									$po = $po + 1;
								?>
								<input type="hidden" name="id[]" value="<?php echo $rows['id'];?>"/>
								
								
								<div class="row">
								<div class="col-md-2">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Boarding_Points'];?></label>
                                    
                                 <select name="exist_bpoint[]" class="form-control select2-multi-select" required>
								  <option value=""><?php echo $lang['Select_A_Boarding_Points'];?></option>
								  <?php 
								  $citylist = $bus->query("select * from tbl_city");
								  while($row = $citylist->fetch_assoc())
								  {
								  ?>
								 <option value="<?php echo $row["id"];?>" <?php if($rows["bpoint"] == $row["id"]){echo 'selected';}?>><?php echo $row["title"];?></option> 
								  <?php } ?>
								  </select>
                                	
								</div>
								</div>
								<div class="col-md-2">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Boarding_Time'];?></label>
                                    <?php 
									$timeFromDatabase = $rows["btime"];

// Format it to 'H:i:S' format (e.g., '03:00:00')
$formattedTime = date("H:i:S", strtotime($timeFromDatabase));
									?>
                                  <input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Boarding_Time'];?>" value="<?php echo $formattedTime;?>" name="exist_btime[]" required>
                                
								</div>
								</div>
								<div class="col-md-2">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Droping_Points'];?></label>
                                    
                                  <select name="exist_dpoint[]" class="form-control select2-multi-select" required>
								  <option value=""><?php echo $lang['Select_A_Droping_Points'];?></option>
								  <?php 
								  $citylist = $bus->query("select * from tbl_city");
								  while($row = $citylist->fetch_assoc())
								  {
								  ?>
								 <option value="<?php echo $row["id"];?>" <?php if($rows["dpoint"] == $row["id"]){echo 'selected';}?>><?php echo $row["title"];?></option> 
								  <?php } ?>
								  </select>
                            
								</div>
								</div>
								<div class="col-md-2">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Droping_Time'];?></label>
                                    <?php 
									$timeFromDatabase = $rows["dtime"];

// Format it to 'H:i:S' format (e.g., '03:00:00')
$formattedTime = date("H:i:S", strtotime($timeFromDatabase));
									?>
                                  <input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Droping_Time'];?>"  value="<?php echo $formattedTime;?>" name="exist_dtime[]" required>
                                
								</div>
								</div>
								
								<div class="col-md-2">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Total_Time_Difference'];?></label>
                                    
                                  <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Difference_Time'];?>"  value="<?php echo $rows['differncetime'];?>" name="exist_differncetime[]" required>
                                
								</div>
								</div>
								
								<div class="col-md-2">
								<div class="form-group">
								<label  id="basic-addon1"></label>
								<br>
								<?php
if($po == 1)
{	
								?>
								<button type="button" id="add_new_point" class="btn btn-primary"><?php echo $lang['Add_New_Points'];?></button>
<?php } else {?>
<button type="button" class="btn del btn-danger remove-point" data-id="<?php echo $rows['id'];?>" data-type="point_delete"><?php echo $lang['Remove_Points'];?></button>
<?php } ?>
								</div>
								</div>
								</div>
								<?php } ?>
								</div>
								</div>
                                    
                                   
                                    <button type="submit" class="btn btn-primary"><?php echo $lang['Update_Boarding_Dropping_Point'];?></button>
                                </form>
					 <?php 
				 }
				 else 
				 {
				 ?>
                  <form method="POST" id="pointForm" enctype="multipart/form-data">
				                <div class="row">
								<div class="col-md-12">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Select_Bus'];?></label>
                                    
                                  <select name="bus_id" class="form-control select2-bus-select">
								  <option value=""><?php echo $lang['Select_A_Bus'];?></option>
								  <?php 
								  $citylist = $bus->query("select * from tbl_bus");
								  while($row = $citylist->fetch_assoc())
								  {
								  ?>
								 <option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option> 
								  <?php } ?>
								  </select>
                            
								</div>
								</div>
								<div class="wow">
								<div class="row">
								<div class="col-md-2">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Boarding_Points'];?></label>
                                    
                                 <select name="bpoint[]" class="form-control select2-multi-select" required>
								  <option value=""><?php echo $lang['Select_A_Boarding_Points'];?></option>
								  <?php 
								  $citylist = $bus->query("select * from tbl_city");
								  while($row = $citylist->fetch_assoc())
								  {
								  ?>
								 <option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option> 
								  <?php } ?>
								  </select>
                                <input type="hidden" name="type" value="add_bdpoints"/>	
								</div>
								</div>
								<div class="col-md-2">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Boarding_Time'];?></label>
                                    
                                  <input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Boarding_Time'];?>"  name="btime[]" required>
                                
								</div>
								</div>
								<div class="col-md-2">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Droping_Points'];?></label>
                                    
                                  <select name="dpoint[]" class="form-control select2-multi-select" required>
								  <option value=""><?php echo $lang['Select_A_Droping_Points'];?></option>
								  <?php 
								  $citylist = $bus->query("select * from tbl_city");
								  while($row = $citylist->fetch_assoc())
								  {
								  ?>
								 <option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option> 
								  <?php } ?>
								  </select>
                            
								</div>
								</div>
								<div class="col-md-2">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Droping_Time'];?></label>
                                    
                                  <input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Droping_Time'];?>"  name="dtime[]" required>
                                
								</div>
								</div>
								
								<div class="col-md-2">
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Total_Time_Difference'];?></label>
                                    
                                  <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Difference_Time'];?>"  name="differncetime[]" required>
                                
								</div>
								</div>
								
								<div class="col-md-2">
								<div class="form-group">
								<label  id="basic-addon1"></label>
								<br>
								<button id="add-lrow-2_1" class="btn btn-primary"><?php echo $lang['Add_New_Points'];?></button>
								</div>
								</div>
								</div>
								</div>
								</div>
                                    
                                   
                                    <button type="submit" class="btn btn-primary"><?php echo $lang['Add_Boarding_Dropping_Point'];?></button>
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
    <!-- login js-->
  </body>
<script>
$(document).ready(function() {
    // Add More Points button click event
    $(document).on('click',"#add-lrow-2_1",function() {
        var newRow = '<div class="row">' +
		    '<div class="col-md-2">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Boarding_Points'];?></label>' +
            '<select name="bpoint[]" class="form-control select2-multi-select" required>' +
            '<option value=""><?php echo $lang['Select_A_Boarding_Points'];?></option>' +
            '<?php 
                $citylist = $bus->query("select * from tbl_city");
                while($row = $citylist->fetch_assoc())
                {
                    echo '<option value="'.$row["id"].'">'.$row["title"].'</option>';
                }
            ?>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Boarding_Time'];?></label>' +
            '<input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Boarding_Time'];?>" name="btime[]" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Droping_Points'];?></label>' +
            '<select name="dpoint[]" class="form-control select2-multi-select" required>' +
            '<option value=""><?php echo $lang['Select_A_Droping_Points'];?></option>' +
            '<?php 
                $citylist = $bus->query("select * from tbl_city");
                while($row = $citylist->fetch_assoc())
                {
                    echo '<option value="'.$row["id"].'">'.$row["title"].'</option>';
                }
            ?>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Droping_Time'];?></label>' +
            '<input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Droping_Time'];?>" name="dtime[]" required>' +
            '</div>' +
            '</div>' +
			'<div class="col-md-2">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Total_Time_Difference'];?></label>' +
            '<input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Difference_Time'];?>" name="differncetime[]" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<div class="form-group">' +
            '<label id="basic-addon1"></label>' +
            '<br>' +
            '<button type="button" class="btn btn-danger remove-point"><?php echo $lang['Remove_Points'];?></button>' +
            '</div>' +
            '</div>' +
            '</div>';

        $(".wow").append(newRow);
		$('.select2-multi-select').select2({
        placeholder: 'Choose City'
    });
		$(".wow .time").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
            placeholder: "Select Time",
        });
		return false;
    });
	
	$(document).on('click',"#add_new_point",function() {
        var newRow = '<div class="row">' +
		    '<div class="col-md-2">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Boarding_Points'];?></label>' +
            '<select name="new_bpoint[]" class="form-control select2-multi-select" required>' +
            '<option value=""><?php echo $lang['Select_A_Boarding_Points'];?></option>' +
            '<?php 
                $citylist = $bus->query("select * from tbl_city");
                while($row = $citylist->fetch_assoc())
                {
                    echo '<option value="'.$row["id"].'">'.$row["title"].'</option>';
                }
            ?>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Boarding_Time'];?></label>' +
            '<input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Boarding_Time'];?>" name="new_btime[]" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Droping_Points'];?></label>' +
            '<select name="new_dpoint[]" class="form-control select2-multi-select" required>' +
            '<option value=""><?php echo $lang['Select_A_Droping_Points'];?></option>' +
            '<?php 
                $citylist = $bus->query("select * from tbl_city");
                while($row = $citylist->fetch_assoc())
                {
                    echo '<option value="'.$row["id"].'">'.$row["title"].'</option>';
                }
            ?>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Droping_Time'];?></label>' +
            '<input type="text" class="form-control time" placeholder="<?php echo $lang['Enter_Droping_Time'];?>" name="new_dtime[]" required>' +
            '</div>' +
            '</div>' +
			'<div class="col-md-2">' +
            '<div class="form-group mb-3">' +
            '<label id="basic-addon1"><?php echo $lang['Total_Time_Difference'];?></label>' +
            '<input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Difference_Time'];?>" name="new_differncetime[]" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<div class="form-group">' +
            '<label id="basic-addon1"></label>' +
            '<br>' +
            '<button type="button" class="btn btn-danger remove-point"><?php echo $lang['Remove_Points'];?></button>' +
            '</div>' +
            '</div>' +
            '</div>';

        $(".wow").append(newRow);
		$('.select2-multi-select').select2({
        placeholder: '<?php echo $lang['Choose_City'];?>'
    });
		$(".wow .time").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
            placeholder: "Select Time",
        });
		return false;
    });


    // Remove button click event
    $(".wow").on("click", ".remove-point", function() {
        $(this).closest(".row").remove();
    });
	
});
</script>

</html>