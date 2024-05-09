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
                  <h3><?php echo $lang['Bus_Management'];?></h3>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-default">
            <div class="row">
           <div class="col-sm-12">
                <div class="card">
                <?php 
				if(isset($_GET['id']))
				{
					$data = $bus->query("select * from tbl_bus where id=".$_GET["id"]."")->fetch_assoc();
					$decker = $data['decker'];
	
					?>
							<form method="post" enctype="multipart/form-data">
    <div class="card-body">
        <h5 class="h5_set"><i class="fa fa-bus"></i> <?php echo $lang['Bus_Information'];?></h5>
        <div class="row">
            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Name'];?></label>
                <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Bus_Name'];?>" value="<?php echo $data["title"];?>" name="title" required />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Number'];?></label>
                <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Bus_Number'];?>" name="bno" value="<?php echo $data["bno"];?>" required />
                <input type="hidden" name="type" value="edit_bus" />
				<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Image'];?></label>
                <div class="custom-file">
                    <input type="file" name="bus_img" class="custom-file-input form-control"  />
                    <label class="custom-file-label"><?php echo $lang['Choose_Bus_Image'];?></label>
                </div>
				<br>
				<img src="<?php echo $data["bus_img"];?>" width="100px"/>
            </div>

            <div class="form-group col-3">
                <label> <span class="text-danger">*</span> <?php echo $lang['Bus_Status'];?></label>
                <select name="bstatus" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1" <?php  if($data["bstatus"] ==1){echo 'selected';}?>><?php echo $lang['Publish'];?></option>
                    <option value="0"<?php  if($data["bstatus"] ==0){echo 'selected';}?> ><?php echo $lang['UnPublish'];?></option>
                </select>
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Rating'];?></label>
                <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Bus_Rating'];?>" name="rate" value="<?php echo $data["rate"];?>" required />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Ticket_Price'];?></label>
                <input type="number" step="0.01" class="form-control" placeholder="<?php echo $lang['Enter_Ticket_Price'];?>" value="<?php echo $data["tick_price"];?>" name="tick_price" required />
            </div>

            

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Total_Decker'];?> ?</label>
                <select name="decker" id="decker" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1" <?php  if($data["decker"] ==1){echo 'selected';}?>><?php echo $lang['Single_Decker'];?></option>
                    <option value="0" <?php  if($data["decker"] ==0){echo 'selected';}?>><?php echo $lang['Double_Decker'];?></option>
                </select>
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Driver_Direction'];?> ?</label>
                <select name="driver_direction" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1" <?php  if($data["driver_direction"] ==1){echo 'selected';}?>><?php echo $lang['Left_Side'];?></option>
                    <option value="0" <?php  if($data["driver_direction"] ==0){echo 'selected';}?>><?php echo $lang['Right_Side'];?></option>
                </select>
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span><?php echo $lang['Total_Seat'];?></label>
                <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Total_Seat'];?>" name="totl_seat" value="<?php echo $data["totl_seat"];?>" required />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span><?php echo $lang['Total_Seat_Limit'];?></label>
                <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Seat_Limit'];?>" name="seat_limit" value="<?php echo $data["seat_limit"];?>" required />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Ac'];?> ?</label>
                <select name="bac" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1" <?php  if($data["bac"] ==1){echo 'selected';}?>><?php echo $lang['Yes'];?></option>
                    <option value="0" <?php  if($data["bac"] ==0){echo 'selected';}?>><?php echo $lang['No'];?></option>
                </select>
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span><?php echo $lang['Bus_Sleeper'];?> ?</label>
                <select name="is_sleeper" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1" <?php  if($data["is_sleeper"] ==1){echo 'selected';}?>><?php echo $lang['Yes'];?></option>
                    <option value="0" <?php  if($data["is_sleeper"] ==0){echo 'selected';}?>><?php echo $lang['No'];?></option>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><?php echo $lang['Bus_Facility'];?> ?</label>
                <select name="facilitylist[]" class="form-control select2-multi-facility" Multiple>
                    
                    <?php 
					$flist = $bus->query("select * from tbl_facility");
					$people = explode(',',$data['bus_facility']);
					while($row = $flist->fetch_assoc())
					{
						?>
						<option value="<?php echo $row["id"];?>" <?php if(in_array($row['id'], $people)){echo 'selected';}?>><?php echo $row["title"];?></option>
						<?php
					}
					?>
                </select>
            </div>
			
			<div class="form-group col-3">
    <label><?php echo $lang['Bus_OffDay'];?> ?</label>
    <select name="offday[]" class="form-control select2-multi-days" multiple>
        <?php
$daysOfWeek = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
$people = explode(',', $data['offday']);
foreach ($daysOfWeek as $day) {
    echo '<option value="' . $day . '"';
    if (in_array($day, $people)) {
        echo ' selected';
    }
    echo '>' . $day . '</option>';
}
?>
    </select>
</div>

<div class="form-group col-6">
                <label><span class="text-danger">*</span><?php echo $lang['Select_Driver'];?></label>
                <select class="form-control" name="driver_id">
				<option value=""><?php echo $lang['Select_A_Driver'];?></option>
				<?php 
				$dri = $bus->query("select * from tbl_driver where operator_id=".$sdata["id"]."");
				while($row = $dri->fetch_assoc())
				{
					?>
					<option value="<?php echo $row['id'];?>" <?php if($row['id'] == $data['driver_id']){echo 'selected';}?>><?php echo $row['driver_name'];?></option>
					<?php 
				}
				?>
				</select>
            </div>
			
            <div class="lower_show">
                <div class="form-group col-12">
                    <h5 class="h5_set"><i class="fas fa-chair"></i><?php echo $lang['Lower_Berth_Plan_And_Seat_Number_Assign'];?>.</h5>
                </div>
                
              <div class="row">
            <div class="col-3">
               
                    <div class="form-group">
                        <label for="rows"><?php echo $lang['Total_Seat_Rows'];?>:</label>
                        <input type="number" class="form-control" id="rows" name="rows"  value="<?php echo $data["lower_row"];?>" >
                    </div>
                    <div class="form-group">
                        <label for="columns"><?php echo $lang['Total_Seat_Columns'];?>:</label>
                        <input type="number" class="form-control" id="columns" name="columns"  value="<?php echo $data["lower_column"];?>" >
                    </div>
                   <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" type="button" onclick="generateSeatPlan()"><?php echo $lang['Generate_Plan'];?></button>
        <button class="btn btn-info" id="add-row-button" type="button"  onclick="addRow()"><?php echo $lang['Add_More_Row'];?></button>
    </div>
                
            </div>
            <div class="col-9">
			    <div class="table-container">
                <div id="seat-plan">
			<?php
// Define the number of rows and columns
$rows = $data["lower_row"];
$columns = $data["lower_column"];

// Define the "upper" string
$upperString = $data["seat_layout"];

// Split the "upper" string into rows using "$;"
$upperRows = explode('$;', $upperString);

echo '<table id="lowertable">';
$upperRowIndex = 0; // Track the index of the "UPPER" row

for ($i = 0; $i < $rows; $i++) {
    echo '<tr>';
    
    // Skip rows that contain "UPPER"
    while ($upperRowIndex < count($upperRows)) {
        if (strpos($upperRows[$upperRowIndex], "UPPER") === false) {
            break;
        }
        $upperRowIndex++;
    }
    
    if ($upperRowIndex < count($upperRows)) {
        $values = explode(',', $upperRows[$upperRowIndex]);

        for ($j = 0; $j < $columns; $j++) {
            // Use the value at index $j (if it exists) to set the input's value attribute
            $value = isset($values[$j]) ? $values[$j] : '';
            echo '<td><input type="text" name="lower_' . $i . '_' . $j . '" style="width:80px;" value="' . $value . '"></td>';
        }
        
        $upperRowIndex++;
    }
    
    if ($i >= 2) {
        echo '<td><button class="remove-button" onclick="removeRow(this)">Remove</button></td>';
    } else {
        echo '<td></td>';
    }
    
    echo '</tr>';
}

echo '</table>';
?>
				</div>
                
				</div>
				
            </div>
        </div>
		
            </div>
            <div class="upper_show">
                <div class="form-group col-12">
                    <h5 class="h5_set"><i class="fas fa-chair"></i><?php echo $lang['Upper_Berth_Plan_And_Seat_Number_Assign'];?>.</h5>
                </div>
				
				<div class="row">
            <div class="col-3">
               
                    <div class="form-group">
                        <label for="rows"><?php echo $lang['Total_Seat_Rows'];?>:</label>
                        <input type="number" class="form-control" id="rowss" name="rowss" min="4" value="<?php echo $data["upper_row"];?>" >
                    </div>
                    <div class="form-group">
                        <label for="columns"><?php echo $lang['Total_Seat_Columns'];?>:</label>
                        <input type="number" class="form-control" id="columnss" name="columnss" min="4" value="<?php echo $data["upper_column"];?>" >
                    </div>
                   <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" type="button" onclick="generateUpperPlan()"><?php echo $lang['Generate_Plan'];?></button>
        <button class="btn btn-info" id="add-rows-button" type="button"  onclick="addUpperRow()"><?php echo $lang['Add_More_Row'];?></button>
    </div>
                
            </div>
            <div class="col-9">
			    <div class="table-container">
                <div id="seats-plan">
				<?php
// Define the number of rows and columns
$rows = $data["upper_row"];
$columns = $data["upper_column"];

// Define the "upper" string
$upperString = $data["seat_layout"];

// Split the "upper" string into rows using "$;"
$upperRows = explode('$;', $upperString);

echo '<table id="uppertable">';
$upperRowIndex = 0; // Track the index of the "UPPER" row

for ($i = 0; $i < $rows; $i++) {
    echo '<tr>';
    
    // Skip rows that contain "LOWER"
    while ($upperRowIndex < count($upperRows)) {
        if (strpos($upperRows[$upperRowIndex], "LOWER") === false) {
            break;
        }
        $upperRowIndex++;
    }
    
    if ($upperRowIndex < count($upperRows)) {
        $values = explode(',', $upperRows[$upperRowIndex]);

        for ($j = 0; $j < $columns; $j++) {
            // Use the value at index $j (if it exists) to set the input's value attribute
            $value = isset($values[$j]) ? $values[$j] : '';
            echo '<td><input type="text" name="upper_' . $i . '_' . $j . '" style="width:80px;" value="' . $value . '"></td>';
        }
        
        $upperRowIndex++;
    }
    
    if ($i >= 2) {
        echo '<td><button class="remove-button" onclick="removeRows(this)">Remove</button></td>';
    } else {
        echo '<td></td>';
    }
    
    echo '</tr>';
}

echo '</table>';
?>
				</div>
                
				</div>
				
            </div>
        </div>
               
            </div>

            <div class="col-12">
                <button type="submit"  class="btn btn-primary mb-2"><?php echo $lang['Edit_Bus'];?></button>
            </div>
        </div>
    </div>
</form>
					<?php 
				}
				else 
				{
				?>
                
				<form method="post" enctype="multipart/form-data">
    <div class="card-body">
        <h5 class="h5_set"><i class="fa fa-bus"></i> <?php echo $lang['Bus_Information'];?></h5>
        <div class="row">
            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Name'];?></label>
                <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Bus_Name'];?>" name="title" required />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Number'];?></label>
                <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Bus_Number'];?>" name="bno" required />
                <input type="hidden" name="type" value="add_bus" />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Image'];?></label>
                <div class="custom-file">
                    <input type="file" name="bus_img" class="custom-file-input form-control" required />
                    <label class="custom-file-label"><?php echo $lang['Choose_Bus_Image'];?></label>
                </div>
            </div>

            <div class="form-group col-3">
                <label> <span class="text-danger">*</span> <?php echo $lang['Bus_Status'];?></label>
                <select name="bstatus" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1"><?php echo $lang['Publish'];?></option>
                    <option value="0"><?php echo $lang['UnPublish'];?></option>
                </select>
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Rating'];?></label>
                <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Bus_Rating'];?>" name="rate" required />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Ticket_Price'];?></label>
                <input type="number" step="0.01" class="form-control" placeholder="<?php echo $lang['Enter_Ticket_Price'];?>" name="tick_price" required />
            </div>
			
			

            

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Total_Decker'];?> ?</label>
                <select name="decker" id="decker" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1"><?php echo $lang['Single_Decker'];?></option>
                    <option value="0"><?php echo $lang['Double_Decker'];?></option>
                </select>
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Driver_Direction'];?> ?</label>
                <select name="driver_direction" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1"><?php echo $lang['Left_Side'];?></option>
                    <option value="0"><?php echo $lang['Right_Side'];?></option>
                </select>
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span><?php echo $lang['Total_Seat'];?></label>
                <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Total_Seat'];?>" name="totl_seat" required />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span><?php echo $lang['Total_Seat_Limit'];?></label>
                <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Seat_Limit'];?>" name="seat_limit" required />
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Ac'];?> ?</label>
                <select name="bac" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1"><?php echo $lang['Yes'];?></option>
                    <option value="0"><?php echo $lang['No'];?></option>
                </select>
            </div>

            <div class="form-group col-3">
                <label><span class="text-danger">*</span><?php echo $lang['Bus_Sleeper'];?> ?</label>
                <select name="is_sleeper" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1"><?php echo $lang['Yes'];?></option>
                    <option value="0"><?php echo $lang['No'];?></option>
                </select>
            </div>
			
			<div class="form-group col-3">
                <label><?php echo $lang['Bus_Facility'];?> ?</label>
                <select name="facilitylist[]" class="form-control select2-multi-facility" Multiple>
                    
                    <?php 
					$flist = $bus->query("select * from tbl_facility");
					while($row = $flist->fetch_assoc())
					{
						?>
						<option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option>
						<?php
					}
					?>
                </select>
            </div>
			
			<div class="form-group col-3">
    <label><?php echo $lang['Bus_OffDay'];?> ?</label>
    <select name="offday[]" class="form-control select2-multi-days" multiple>
        <?php
        $daysOfWeek = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

        foreach ($daysOfWeek as $day) {
            echo '<option value="' . $day . '">' . $day . '</option>';
        }
        ?>
    </select>
</div>

 <div class="form-group col-6">
                <label><span class="text-danger">*</span><?php echo $lang['Select_Driver'];?> <?=$sdata["id"] ?></label>
                <select class="form-control" name="driver_id">
				<option value=""><?php echo $lang['Select_A_Driver'];?></option>
				<?php 
				$dri = $bus->query("select * from tbl_driver where operator_id=".$sdata["id"]."");
				while($row = $dri->fetch_assoc())
				{
					?>
					<option value="<?php echo $row['id'];?>"><?php echo $row['driver_name'];?></option>
					<?php 
				}
				?>
				</select>
            </div>
			
			
			
            <div class="lower_show">
                <div class="form-group col-12">
                    <h5 class="h5_set"><i class="fas fa-chair"></i><?php echo $lang['Lower_Berth_Plan_And_Seat_Number_Assign'];?>.</h5>
                </div>
                
              <div class="row">
            <div class="col-3">
               
                    <div class="form-group">
                        <label for="rows"><?php echo $lang['Total_Seat_Rows'];?>:</label>
                        <input type="number" class="form-control" id="rows" name="rows" min="4" value="4" oninput="hideAddRowButton()">
                    </div>
                    <div class="form-group">
                        <label for="columns"><?php echo $lang['Total_Seat_Columns'];?>:</label>
                        <input type="number" class="form-control" id="columns" name="columns" min="4" value="4" oninput="hideAddRowButton()">
                    </div>
                   <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" type="button" onclick="generateSeatPlan()"><?php echo $lang['Generate_Plan'];?></button>
        <button class="btn btn-info" id="add-row-button" type="button" style="display: none;" onclick="addRow()"><?php echo $lang['Add_More_Row'];?></button>
    </div>
                
            </div>
            <div class="col-9">
			    <div class="table-container">
                <div id="seat-plan"></div>
                
				</div>
				
            </div>
        </div>
		
            </div>
            <div class="upper_show">
                <div class="form-group col-12">
                    <h5 class="h5_set"><i class="fas fa-chair"></i><?php echo $lang['Upper_Berth_Plan_And_Seat_Number_Assign'];?>.</h5>
                </div>
				
				<div class="row">
            <div class="col-3">
               
                    <div class="form-group">
                        <label for="rows"><?php echo $lang['Total_Seat_Rows'];?>:</label>
                        <input type="number" class="form-control" id="rowss" name="rowss" min="4" value="4" oninput="hideAddRowButtons()">
                    </div>
                    <div class="form-group">
                        <label for="columns"><?php echo $lang['Total_Seat_Columns'];?>:</label>
                        <input type="number" class="form-control" id="columnss" name="columnss" min="4" value="4" oninput="hideAddRowButtons()">
                    </div>
                   <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" type="button" onclick="generateUpperPlan()"><?php echo $lang['Generate_Plan'];?></button>
        <button class="btn btn-info" id="add-rows-button" type="button" style="display: none;" onclick="addUpperRow()"><?php echo $lang['Add_More_Row'];?></button>
    </div>
                
            </div>
            <div class="col-9">
			    <div class="table-container">
                <div id="seats-plan"></div>
                
				</div>
				
            </div>
        </div>
               
            </div>

            <div class="col-12">
                <button type="submit" name="add_bus" class="btn btn-primary mb-2"><?php echo $lang['Add_Bus'];?></button>
            </div>
        </div>
    </div>
</form>

				<?php } ?>
				 
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
	<?php 
if(isset($_GET["id"]))
{
	?>
	<?php 
	if($decker == 1)
	{
		?>
		<script>
	 $(".lower_show").show();
    $(".upper_show").hide();
	</script>
	<?php } else { ?>
	<script>
	 $(".lower_show").show();
    $(".upper_show").show();
	</script>
	<?php } ?>
	<?php 
}
else 
{
	?>
	 <script>
	 $(".lower_show").hide();
    $(".upper_show").hide();
	</script>
<?php } ?>
	<script>
	
    </script>
  </body>


</html>