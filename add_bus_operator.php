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
                  <h3><?php echo $lang['Bus_Operator_Management'];?></h3>
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
					$data = $bus->query("select * from tbl_bus_operator where id=".$_GET["id"]."")->fetch_assoc();
					
	
					?>
							<form method="post" enctype="multipart/form-data">
    <div class="card-body">
        <h5 class="h5_set"><i class="fa fa-bus"></i> <?php echo $lang['Bus_Operator_Information'];?></h5>
        <div class="row">
            <div class="form-group col-4">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Name'];?></label>
                <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Bus_Name'];?>" name="title" value="<?php echo $data["bus_name"];?>" required />
				<input type="hidden" name="type" value="edit_bus_operator" />
				<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
            </div>

            

            <div class="form-group col-4">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Operator_Image'];?></label>
                <div class="custom-file">
                    <input type="file" name="op_img" class="custom-file-input form-control" required />
                    <label class="custom-file-label"><?php echo $lang['Choose_Bus_Operator_Image'];?></label>
					<br>
				<img src="<?php echo $data["op_img"];?>" width="100px"/>
                </div>
            </div>

            <div class="form-group col-4">
                <label> <span class="text-danger">*</span> <?php echo $lang['Bus_Operator_Status'];?></label>
                <select name="status" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                     <option value="1" <?php  if($data["status"] ==1){echo 'selected';}?>><?php echo $lang['Publish'];?></option>
                    <option value="0"<?php  if($data["status"] ==0){echo 'selected';}?> ><?php echo $lang['UnPublish'];?></option>
                </select>
            </div>

            <div class="form-group col-4">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Operator_Rating'];?></label>
                <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Bus_Operator_Rating'];?>" name="rate" value="<?php echo $data["rate"];?>" required />
            </div>

            
			
			<div class="form-group col-4">
                <label><span class="text-danger">*</span><?php echo $lang['Agent_Commission'];?></label>
                <input type="number" step="0.01" class="form-control" placeholder="<?php echo $lang['Enter_Agent_Commission'];?>" min="1" max="100" value="<?php echo $data["agent_commission"];?>" name="agent_commission" required />
            </div>
			
			<div class="form-group col-4">
                <label><span class="text-danger">*</span><?php echo $lang['Admin_Commission'];?></label>
                <input type="number" step="0.01" class="form-control" placeholder="<?php echo $lang['Enter_Admin_Commission'];?>" min="1" max="100" value="<?php echo $data["admin_commission"];?>" name="admin_commission" required />
            </div>

            

            

            

            
			<h5 class="h5_set"><i class="fa fa-sign-in"></i> <?php echo $lang['Bus_Operator_Login_Information'];?></h5>
			

 <div class="form-group col-6">
                <label><span class="text-danger">*</span><?php echo $lang['Operator_Email'];?></label>
                <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Operator_Email'];?>" name="email" value="<?php echo $data["email"];?>" required />
            </div>
			
			 <div class="form-group col-6">
                <label><span class="text-danger">*</span><?php echo $lang['Operator_Password'];?></label>
                <input type="password" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Operator_Password'];?>" name="password" value="<?php echo $data["password"];?>" required />
            </div>
			
			
			<h5 class="h5_set"><i class="fa fa-map-pin"></i> <?php echo $lang['Bus_Operator_Address_Information'];?></h5> 
			<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
										<div class="form-group mb-3">
										<input id="searchInput" class="input-controls" type="text" placeholder="Enter a location">
<div class="map" id="map"></div>
</div>
</div>

 <div class="form-group col-6">
                <label><span class="text-danger">*</span> <?php echo $lang['Office_Address'];?></label>
                <textarea name="address" rows="10" class="form-control" id="location"  style="resize:none;"><?php echo $data["address"];?></textarea>
            </div>
			
			<div class="form-group col-6">
                <label><span class="text-danger">*</span> <?php echo $lang['Office_Latitude'];?></label>
               <input type="text" class="form-control mb-3"  id="lat"  value="<?php echo $data["lats"];?>" name="lats" required  readonly />
			   
			    <label ><span class="text-danger">*</span> <?php echo $lang['Office_Longtitude'];?></label>
               <input type="text" class="form-control mb-3"  id="lng" value="<?php echo $data["longs"];?>" name="longs" required  readonly />
			   
			  
			   
            </div>
			
			<div class="form-group col-12">
										<h5 class="h5_set"><i class="fa fa-credit-card"></i> <?php echo $lang['Operator_Payout_Information'];?></h5>
										</div>
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['Bank_Name'];?></label>
                                            <input type="text" class="form-control " placeholder="<?php echo $lang['Enter_Bank_Name'];?>"  name="bank_name" value="<?php echo $data["bank_name"];?>" required="">
                                        </div>
										
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['Bank_Code_IFSC'];?></label>
                                            <input type="text" class="form-control " placeholder="<?php echo $lang['Enter_Bank_Code_IFSC'];?>"  name="ifsc_code" value="<?php echo $data["ifsc_code"];?>" required="">
                                        </div>
										
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['Recipient_Name'];?></label>
                                            <input type="text" class="form-control " placeholder="<?php echo $lang['Enter_Recipient_Name'];?>"  name="receipt_name" value="<?php echo $data["receipt_name"];?>" required="">
                                        </div>
										
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['Account_Number'];?></label>
                                            <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Account_Number'];?>"  name="acc_no" value="<?php echo $data["acc_no"];?>" required="">
                                        </div>
										
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['Paypal_ID'];?></label>
                                            <input type="text" class="form-control " placeholder="<?php echo $lang['Enter_Paypal_ID'];?>"  name="pay_id" value="<?php echo $data["pay_id"];?>" required="">
                                        </div>
										
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['UPI_ID'];?></label>
                                            <input type="text" class="form-control " placeholder="<?php echo $lang['Enter_UPI_ID'];?>"  name="upi_id" value="<?php echo $data["upi_id"];?>" required="">
                                        </div>
			
           

            <div class="col-12">
                <button type="submit" class="btn btn-primary mb-2"><?php echo $lang['Edit_Bus_Operator'];?></button>
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
        <h5 class="h5_set"><i class="fa fa-bus"></i> <?php echo $lang['Bus_Operator_Information'];?></h5>
        <div class="row">
            <div class="form-group col-4">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Name'];?></label>
                <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Bus_Name'];?>" name="title" required />
				<input type="hidden" name="type" value="add_bus_operator" />
            </div>

            

            <div class="form-group col-4">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Operator_Image'];?></label>
                <div class="custom-file">
                    <input type="file" name="op_img" class="custom-file-input form-control" required />
                    <label class="custom-file-label"><?php echo $lang['Choose_Bus_Operator_Image'];?></label>
                </div>
            </div>

            <div class="form-group col-4">
                <label> <span class="text-danger">*</span> <?php echo $lang['Bus_Operator_Status'];?></label>
                <select name="status" class="form-control" required>
                    <option value=""><?php echo $lang['Select_Status'];?></option>
                    <option value="1"><?php echo $lang['Publish'];?></option>
                    <option value="0"><?php echo $lang['UnPublish'];?></option>
                </select>
            </div>

            <div class="form-group col-4">
                <label><span class="text-danger">*</span> <?php echo $lang['Bus_Operator_Rating'];?></label>
                <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Bus_Operator_Rating'];?>" name="rate" required />
            </div>

            
			
			<div class="form-group col-4">
                <label><span class="text-danger">*</span><?php echo $lang['Agent_Commission'];?></label>
                <input type="number" step="0.01" class="form-control" placeholder="<?php echo $lang['Enter_Agent_Commission'];?>" min="1" max="100" name="agent_commission" required />
            </div>
			
			<div class="form-group col-4">
                <label><span class="text-danger">*</span><?php echo $lang['Admin_Commission'];?></label>
                <input type="number" step="0.01" class="form-control" placeholder="<?php echo $lang['Enter_Admin_Commission'];?>" min="1" max="100" name="admin_commission" required />
            </div>

            

            

            

            
			<h5 class="h5_set"><i class="fa fa-sign-in"></i> <?php echo $lang['Bus_Operator_Login_Information'];?></h5>
			

 <div class="form-group col-6">
                <label><span class="text-danger">*</span><?php echo $lang['Operator_Email'];?></label>
                <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Operator_Email'];?>" name="email" required />
            </div>
			
			 <div class="form-group col-6">
                <label><span class="text-danger">*</span><?php echo $lang['Operator_Password'];?></label>
                <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Operator_Password'];?>" name="password" required />
            </div>
			
			
			<h5 class="h5_set"><i class="fa fa-map-pin"></i> <?php echo $lang['Bus_Operator_Address_Information'];?></h5> 
			<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
										<div class="form-group mb-3">
										<input id="searchInput" class="input-controls" type="text" placeholder="Enter a location">
<div class="map" id="map"></div>
</div>
</div>

              <div class="form-group col-6">
                <label><span class="text-danger">*</span> <?php echo $lang['Office_Address'];?></label>
                <textarea name="address" rows="10" class="form-control" id="location"  style="resize:none;"></textarea>
            </div>
			
			<div class="form-group col-6">
                <label><span class="text-danger">*</span> <?php echo $lang['Office_Latitude'];?></label>
               <input type="text" class="form-control mb-3"  id="lat"  name="lats" required  readonly />
			   
			    <label ><span class="text-danger">*</span> <?php echo $lang['Office_Longtitude'];?></label>
               <input type="text" class="form-control mb-3"  id="lng"  name="longs" required  readonly />
			   
			  
			   
            </div>
			
			<div class="form-group col-12">
										<h5 class="h5_set"><i class="fa fa-credit-card"></i> <?php echo $lang['Operator_Payout_Information'];?></h5>
										</div>
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['Bank_Name'];?></label>
                                            <input type="text" class="form-control " placeholder="<?php echo $lang['Enter_Bank_Name'];?>"  name="bank_name" required="">
                                        </div>
										
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['Bank_Code_IFSC'];?></label>
                                            <input type="text" class="form-control " placeholder="<?php echo $lang['Enter_Bank_Code_IFSC'];?>"  name="ifsc_code" required="">
                                        </div>
										
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['Recipient_Name'];?></label>
                                            <input type="text" class="form-control " placeholder="<?php echo $lang['Enter_Recipient_Name'];?>"  name="receipt_name" required="">
                                        </div>
										
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['Account_Number'];?></label>
                                            <input type="text" class="form-control numberonly" placeholder="<?php echo $lang['Enter_Account_Number'];?>"  name="acc_no" required="">
                                        </div>
										
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['Paypal_ID'];?></label>
                                            <input type="text" class="form-control " placeholder="<?php echo $lang['Enter_Paypal_ID'];?>"  name="pay_id" required="">
                                        </div>
										
										<div class="form-group col-6">
                                            <label><span class="text-danger">*</span><?php echo $lang['UPI_ID'];?></label>
                                            <input type="text" class="form-control " placeholder="<?php echo $lang['Enter_UPI_ID'];?>"  name="upi_id" required="">
                                        </div>
			
           

            <div class="col-12">
                <button type="submit" class="btn btn-primary mb-2"><?php echo $lang['Add_Bus_Operator'];?></button>
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
	<script>
function initializeMap() {
    <?php 
    if(isset($_GET['id'])) {
        ?>
        var latlng = new google.maps.LatLng(<?php echo $data['lats'];?>,<?php echo $data['longs'];?>);
        <?php 
    } else {
    ?>
    var latlng = new google.maps.LatLng(21.245327, 81.641792);
    <?php } ?>
    var map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 13
    });
    var marker = new google.maps.Marker({
        map: map,
        position: latlng,
        draggable: true,
        anchorPoint: new google.maps.Point(0, -29)
    });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var geocoder = new google.maps.Geocoder();
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();   
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);          
        bindDataToForm(place.formatted_address, place.geometry.location.lat(), place.geometry.location.lng());
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);
    });
    google.maps.event.addListener(marker, 'dragend', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) { 
                    bindDataToForm(results[0].formatted_address, marker.getPosition().lat(), marker.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                }
            }
        });
    });
}

function bindDataToForm(address, lat, lng) {
    $('#location').val(address);
    $('#lat').val(lat);
    $('#lng').val(lng);
}

function loadGoogleMapsScript() {
    var script = document.createElement('script');
    script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCRF9Q1ttrleh04hqRlP_CqsFCPU815jJk&libraries=places&callback=initializeMap";
    document.body.appendChild(script);
}

window.addEventListener('load', loadGoogleMapsScript, { passive: true });
</script>

<style type="text/css">
#map 
{
	width: 100%; height: 300px;
}

    .input-controls {
      margin-top: 10px;
      border: 1px solid transparent;
      border-radius: 2px 0 0 2px;
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      height: 32px;
      outline: none;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    #searchInput {
      background-color: #fff;
      font-family: Roboto;
      font-size: 15px;
      font-weight: 300;
      margin-left: 12px;
      padding: 0 11px 0 13px;
      text-overflow: ellipsis;
      width: 50%;
    }
    #searchInput:focus {
      border-color: #4d90fe;
    }
</style>
  </body>


</html>