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
                  <h3><?php echo $lang['Driver_Management'];?></h3>
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
					 $data = $bus->query("select * from tbl_driver where id=".$_GET['id']."")->fetch_assoc();
					 ?>
					 <form method="POST"  enctype="multipart/form-data">
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Driver_Name'];?></label>
                                    
                                  <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Driver_Name'];?>"  value="<?php echo $data['driver_name'];?>" name="driver_name">
                            
								</div>
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Driver_Email'];?></label>
                                    
                                  <input type="email" class="form-control" placeholder="<?php echo $lang['Enter_Driver_Email'];?>" value="<?php echo $data['email'];?>"  name="email">
                                <input type="hidden" name="type" value="edit_driver"/>	
								<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
								</div>
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Driver_Password'];?></label>
                                    
                                  <input type="password" class="form-control" placeholder="<?php echo $lang['Enter_Driver_Password'];?>" value="<?php echo $data['password'];?>"  name="password">
                            
								</div>
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Mobile_Number'];?>(+)</label>
                                    
                                  <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Mobile_Number'];?>" value="<?php echo $data['mobile'];?>"  name="mobile">
                            
								</div>
								
                                    
                                   <div class="form-group mb-3">
                                   
                                        <label  for="inputGroupSelect01"><?php echo $lang['Select_Status'];?></label>
                                    
                                    <select class="form-control" name="status" id="inputGroupSelect01" required>
                                        <option value=""><?php echo $lang['Select_Status'];?></option>
                                        <option value="1" <?php if($data['status'] == 1){echo 'selected';}?>><?php echo $lang['Active'];?></option>
                                        <option value="0" <?php if($data['status'] == 0){echo 'selected';}?>><?php echo $lang['Deactive'];?></option>
                                       
                                    </select>
                                </div>
                                    <button type="submit" class="btn btn-primary"><?php echo $lang['Edit_Driver'];?></button>
                                </form>
					 <?php 
				 }
				 else 
				 {
				 ?>
                  <form method="POST"  enctype="multipart/form-data">
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Driver_Name'];?></label>
                                    
                                  <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Driver_Name'];?>"  name="driver_name">
                            
								</div>
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Driver_Email'];?></label>
                                    
                                  <input type="email" class="form-control" placeholder="<?php echo $lang['Enter_Driver_Email'];?>"  name="email">
                                <input type="hidden" name="type" value="add_driver"/>	
								</div>
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Driver_Password'];?></label>
                                    
                                  <input type="password" class="form-control" placeholder="<?php echo $lang['Enter_Driver_Password'];?>"  name="password">
                            
								</div>
								
								<div class="form-group mb-3">
                                   
                                        <label  id="basic-addon1"><?php echo $lang['Mobile_Number'];?>(+)</label>
                                    
                                  <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Mobile_Number'];?>"  name="mobile">
                            
								</div>
								
                                    
                                   <div class="form-group mb-3">
                                   
                                        <label  for="inputGroupSelect01"><?php echo $lang['Select_Status'];?></label>
                                    
                                    <select class="form-control" name="status" id="inputGroupSelect01" required>
                                        <option value=""><?php echo $lang['Select_Status'];?></option>
                                        <option value="1"><?php echo $lang['Active'];?></option>
                                        <option value="0"><?php echo $lang['Deactive'];?></option>
                                       
                                    </select>
                                </div>
                                    <button type="submit" class="btn btn-primary"><?php echo $lang['Add_Driver'];?></button>
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


</html>