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
                  <h3><?php echo $lang['Drop_Pick_Up_Point_Management'];?></h3>
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
					 $data = $bus->query("select * from tbl_points where id=".$_GET['id']."")->fetch_assoc();
					 ?>
					 <form method="POST"  enctype="multipart/form-data">
								
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Select_City'];?></label>
                                    
                                  <select name="city_id" class="form-control select2-multi-select">
								  <option value=""><?php echo $lang['Select_A_City'];?></option>
								  <?php 
								  $citylist = $bus->query("select * from tbl_city");
								  while($row = $citylist->fetch_assoc())
								  {
								  ?>
								 <option value="<?php echo $row["id"];?>" <?php if($data["city_id"] == $row["id"]){echo 'selected';}?>><?php echo $row["title"];?></option> 
								  <?php } ?>
								  </select>
                            
								</div>
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Enter_Point'];?></label>
                                    
                                  <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Point'];?>" value="<?php echo $data['title'];?>" name="title">
                                <input type="hidden" name="type" value="edit_points"/>
										<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
								</div>
								
                                    
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Mobile_Number'];?></label>
                                    
                                  <input type="text" data-role="tagsinput" class="form-control"   value="<?php echo $data['mobile'];?>" name="mobile" required>
                               
								</div>
								
								<div class="form-group mb-3">
										<input id="searchInput" class="input-controls" type="text" placeholder="Enter a location">
<div class="map" id="map"></div>
</div>

<div class="form-group col-12">
                <label><span class="text-danger">*</span> <?php echo $lang['Office_Address'];?></label>
                <textarea name="address" rows="10" class="form-control" id="location"  style="resize:none;"><?php echo $data['address'];?></textarea>
            </div>
			
			<div class="form-group col-12">
                <label><span class="text-danger">*</span> <?php echo $lang['Office_Latitude'];?></label>
               <input type="text" class="form-control mb-3"  value="<?php echo $data['lats'];?>" id="lat"  name="lats" required  />
			   
			    <label ><span class="text-danger">*</span> <?php echo $lang['Office_Longtitude'];?></label>
               <input type="text" class="form-control mb-3" value="<?php echo $data['longs'];?>" id="lng"  name="longs" required  />
			   
			  
			   
            </div>
								
                                   <div class="form-group mb-3">
                                    
                                        <label  for="inputGroupSelect01"><?php echo $lang['Select_Status'];?></label>
                                    
                                    <select  class="form-control" name="status" id="inputGroupSelect01" required>
                                        <option value=""><?php echo $lang['Select_Status'];?></option>
                                        <option value="1" <?php if($data['status'] == 1){echo 'selected';}?>><?php echo $lang['Publish'];?></option>
                                        <option value="0" <?php if($data['status'] == 0){echo 'selected';}?>><?php echo $lang['UnPublish'];?></option>
                                       
                                    </select>
                                </div>
                                    <button type="submit" class="btn btn-primary"><?php echo $lang['Edit_Drop_Pick_Up_Point'];?></button>
                                </form>
					 <?php 
				 }
				 else 
				 {
				 ?>
                  <form method="POST"  enctype="multipart/form-data">
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Select_City'];?></label>
                                    
                                  <select name="city_id" class="form-control select2-multi-select">
								  <option value=""><?php echo $lang['Select_A_City'];?></option>
								  <?php 
								  $citylist = $bus->query("select * from tbl_city");
								  while($row = $citylist->fetch_assoc())
								  {
								  ?>
								 <option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option> 
								  <?php } ?>
								  </select>
                            
								</div>
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Enter_Point'];?></label>
                                    
                                  <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Point'];?>"  name="title" required>
                                <input type="hidden" name="type" value="add_points"/>	
								</div>
								
								
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Mobile_Number'];?></label>
                                    
                                  <input type="text" data-role="tagsinput" class="form-control"   name="mobile" required>
                               
								</div>
								
								
                                    <div class="form-group mb-3">
										<input id="searchInput" class="input-controls" type="text" placeholder="Enter a location">
<div class="map" id="map"></div>
</div>

<div class="form-group col-12">
                <label><span class="text-danger">*</span> <?php echo $lang['Office_Address'];?></label>
                <textarea name="address" rows="10" class="form-control" id="location"  style="resize:none;"></textarea>
            </div>
			
			<div class="form-group col-12">
                <label><span class="text-danger">*</span> <?php echo $lang['Office_Latitude'];?></label>
               <input type="text" class="form-control mb-3"  id="lat"  name="lats" required  />
			   
			    <label ><span class="text-danger">*</span> <?php echo $lang['Office_Longtitude'];?></label>
               <input type="text" class="form-control mb-3"  id="lng"  name="longs" required  />
			   
			  
			   
            </div>

                                   <div class="form-group mb-3">
                                   
                                        <label  for="inputGroupSelect01"><?php echo $lang['Select_Status'];?></label>
                                    
                                    <select class="form-control" name="status" id="inputGroupSelect01" required>
                                        <option value=""><?php echo $lang['Select_Status'];?></option>
                                        <option value="1"><?php echo $lang['Publish'];?></option>
                                        <option value="0"><?php echo $lang['UnPublish'];?></option>
                                       
                                    </select>
                                </div>
                                    <button type="submit" class="btn btn-primary"><?php echo $lang['Add_Drop_Pick_Up_Point'];?></button>
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
	
	<script>
function initializeMap() {
    <?php 
    if(isset($_GET['id'])) {
        ?>
        var latlng = new google.maps.LatLng(<?php echo $data['lats'];?>,<?php echo $data['longs'];?>);
        <?php 
    } else {     ?>
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