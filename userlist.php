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
                  <h3><?php echo $lang['User_List_Management'];?></h3>
                </div>
               
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
         <div class="container-fluid general-widget">
            <div class="row">
             
             <div class="col-sm-12">
                <div class="card">
				<div class="card-body">
				<div class="table-responsive">
                <table class="display" id="basic-1">
                        <thead>
                           <tr>
                                                <th><?php echo $lang['Sr_No'];?>.</th>
                                                <th><?php echo $lang['Name'];?></th>
                                                <th><?php echo $lang['Email_Id'];?></th>
                                                <th><?php echo $lang['Mobile_Number'];?></th>
                                                <th><?php echo $lang['Join_Date'];?></th>
                                                <th><?php echo $lang['Status'];?></th>
												<th><?php echo $lang['User_Type']; ?></th>
												<th><?php echo $lang['Action'];?></th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
											 $stmt = $bus->query("SELECT * FROM `tbl_user` order by id desc limit 5 ");
$i = 0;
while($row = $stmt->fetch_assoc())
{
	
	
	$i = $i + 1;
											?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td>****</td>
												<td>****</td>
												<td>****</td>
												<td><?php echo $row['rdate'];?></td>
												<?php if($row['status'] == 1) { ?>
												
                                                <td><span  data-id="<?php echo $row['id'];?>" data-status="0" data-type="update_status" coll-type="userstatus" class="drop badge badge-danger"><?php echo $lang['Make_Deactive'];?></span></td>
												<?php } else { ?>
												
												<td>
												<span data-id="<?php echo $row['id'];?>" data-status="1" data-type="update_status" coll-type="userstatus" class="badge drop  badge-success"><?php echo $lang['Make_Active'];?></span></td>
												<?php } ?>
												
												<td>
    <?php if ($row['user_type'] === 'USER') { ?>
        <span class="badge badge-primary"><?php echo $lang['USER'];?></span>
    <?php } else { ?>
        <span class="badge badge-danger"><?php echo $lang['AGENT'];?></span>
    <?php } ?>
</td>

<td>
    <?php if ($row['user_type'] === 'USER') { ?>
        <span class="badge badge-primary"><?php echo $lang['No_need'];?></span>
    <?php } else {  if ($row['is_verify'] == 0) {?>
        <span class="drop badge badge-primary" data-id="<?php echo $row['id'];?>" data-status="1" data-type="update_status" coll-type="verifystatus"><?php echo $lang['Approve'];?></span>
		<span class="drop badge badge-danger" data-id="<?php echo $row['id'];?>" data-status="2" data-type="update_status" coll-type="verifystatus"><?php echo $lang['Reject'];?></span>
    <?php } elseif($row['is_verify'] == 1){
		?>
		<span class="badge badge-success"><?php echo $lang['verified'];?></span>
		<?php
	}else {
		?>
		<span class="badge badge-danger"><?php echo $lang['Rejected'];?></span>
		<?php
	} } ?>
</td>
												</tr>
												
												
<?php } ?>
                                            
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


</html>