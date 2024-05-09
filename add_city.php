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
                  <h3><?php echo $lang['City_Management'];?></h3>
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
					 $data = $bus->query("select * from tbl_city where id=".$_GET['id']."")->fetch_assoc();
					 ?>
					 <form method="post" enctype="multipart/form-data">
                                    
                                    <div class="card-body">
                                        
										<div class="form-group mb-3">
                                            <label><?php echo $lang['City_Name'];?></label>
                                            <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_City_Name'];?>" value="<?php echo $data['title'];?>" name="title"  required="">
											<input type="hidden" name="type" value="edit_city"/>
											
										<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
                                        </div>
										
                                        
										
										
										
										 <div class="form-group mb-3">
                                            <label><?php echo $lang['City_Status'];?></label>
                                            <select name="status" class="form-control" required>
											<option value=""><?php echo $lang['Select_Status'];?></option>
											<option value="1" <?php if($data['status'] == 1){echo 'selected';}?>><?php echo $lang['Publish'];?></option>
											<option value="0" <?php if($data['status'] == 0){echo 'selected';}?> ><?php echo $lang['UnPublish'];?></option>
											</select>
                                        </div>
                                        
										
                                    </div>
                                    <div class="card-footer text-left">
                                        <button  type="submit" class="btn btn-primary"><?php echo $lang['Edit_City'];?></button>
                                    </div>
                                </form>
					 <?php 
				 }
				 else 
				 {
				 ?>
                  <form method="post" enctype="multipart/form-data">
                                    
                                    <div class="card-body">
                                        
										
										<div class="form-group mb-3">
                                            <label><?php echo $lang['City_Name'];?></label>
                                            <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_City_Name'];?>" name="title"  required="">
											<input type="hidden" name="type" value="add_city"/>
                                        </div>
										
                                        
										
										
										
										 <div class="form-group mb-3">
                                            <label><?php echo $lang['City_Status'];?></label>
                                            <select name="status" class="form-control" required>
											<option value=""><?php echo $lang['Select_Status'];?></option>
											<option value="1"><?php echo $lang['Publish'];?></option>
											<option value="0"><?php echo $lang['UnPublish'];?></option>
											</select>
                                        </div>
                                        
										
                                    </div>
                                    <div class="card-footer text-left">
                                        <button type="submit" class="btn btn-primary"><?php echo $lang['Add_City'];?></button>
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
  </body>


</html>