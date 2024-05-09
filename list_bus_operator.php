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
				
                  <h3><?php echo $lang['Bus_Operator_List_Management'];?></h3>
				
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
						if(isset($_GET['cid']))
						{
							?>
							<div class="card-header">
                                <h4 class="card-title"><?php echo $lang['Manage_BookSelf_Commission'];?></h4>
                            </div>
                            <div class="card-body">
							<form method="post" enctype="multipart/form-data">
                                       
									   <?php $sales  = $bus->query("SELECT sum((subtotal -cou_amt) * ope_commission/100) as total_earning FROM `tbl_book` where book_status='Completed' and operator_id=".$_GET["cid"]." and user_type='Operator'")->fetch_assoc();
             $payout =   $bus->query("select sum(amt) as total_earning from  tbl_cash where operator_id=".$_GET["cid"]."")->fetch_assoc();
                 
				
				$pb = 0;
				 if($sales['total_earning'] == ''){$pb =  '0';}else {$pb  = number_format((float)($sales['total_earning']) - $payout['total_earning'], 2, '.', ''); } ?>
				 
									   <div class="form-group">
                                            <label><span class="text-danger">*</span> <?php echo $lang['Remain_Commission'];?></label>
                                            <input type="text" class="form-control" value="<?php echo $pb;?>"  name="remain" required="" readonly>
                                        </div>
										
										 <div class="form-group">
                                            <label><span class="text-danger">*</span> <?php echo $lang['Received_Commission'];?></label>
                                            <input type="number" step="0.01" class="form-control" placeholder="<?php echo $lang['Enter_Received_Commission'];?>"  name="rcash" required="">
											<input type="hidden" name="type" value="add_cash"/>
											<input type="hidden" name="store_id" value="<?php echo $_GET['cid'];?>"/>
                                         </div>
										
										 <div class="form-group">
                                            <label><span class="text-danger">*</span> <?php echo $lang['Remark'];?></label>
                                            <input type="text" class="form-control" placeholder="<?php echo $lang['Enter_Remark'];?>"  name="message" required="" >
                                        </div>
										
                                     
										
										
										<div class="col-12">
                                                <button type="submit"  class="btn btn-primary mb-2"><?php echo $lang['Add_Commission_Collection'];?></button>
                                            </div>
                                    </form>
									</div>
							<?php
						}
						else if(isset($_GET['hid']))
						{
							?>
							 <div class="card-header">
                                <h4 class="card-title"><?php echo $lang['Operator_Book_Self_Collection_Log'];?></h4>
                            </div>
                            <div class="card-body">
							
                                <div class="table-responsive">
                                    <table class="display mytable" id="basic-1">
                                        <thead>
                                            <tr>
                                                <th><?php echo $lang['Sr_No'];?>.</th>
												<th><?php echo $lang['Operator_Name'];?></th>
                                                
												 
												 <th><?php echo $lang['Received_Commission'];?></th>
												<th><?php echo $lang['Remark'];?></th>
                                                <th><?php echo $lang['Received_Date'];?></th>
                                                

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
											 
											 $stmt = $bus->query("SELECT * FROM `tbl_cash` where operator_id =".$_GET['hid']."");
$i = 0;
while($row = $stmt->fetch_assoc())
{
	$stmts = $bus->query("SELECT * FROM `tbl_bus_operator` where id =".$row['operator_id']."")->fetch_assoc();
	$i = $i + 1;
											?>
                                                <tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="align-middle">
                                                   <?php echo $stmts['bus_name']; ?>
                                                </td>
												
                                                <td class="align-middle">
                                                 <span class="badge badge-primary"> <?php echo $row['amt'].' '.$set['currency']; ?> </span>
                                                </td>
                                                
                                               
				<td class="align-middle">
                                                  <?php echo $row['Remark']; ?>
                                                </td>
												
												 <td class="align-middle">
                                                  <?php echo date("d M Y, h:i a", strtotime($row['receive_date'])); ?>
                                                </td>
												
                                                </tr>
<?php } ?> 
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
							<?php 
						}
						else {
						?>
				<div class="card-body">
				
				<div class="table-responsive">
				
                <table class="display" id="basic-1">
                        <thead>
                          <tr>
                            <th><?php echo $lang['Sr_No'];?>.</th>
							
											<th><?php echo $lang['Bus_Operator_Image'];?></th>
											<th><?php echo $lang['Bus_Name'];?></th>
												<th><?php echo $lang['Bus_Operator_Status'];?></th>
												<th><?php echo $lang['Total_Earn_Commission_BookSelf_Seat'];?></th>
												<th><?php echo $lang['Total_Received_Commission_BookSelf_Seat'];?></th>
												<th><?php echo $lang['Total_Remain_Commission_BookSelf_Seat'];?></th>
												<th><?php echo $lang['Action'];?></th>
                          </tr>
                        </thead>
                        <tbody>
                           <?php 
										$city = $bus->query("select id,bus_name,op_img,status from tbl_bus_operator");
										$i=0;
										while($row = $city->fetch_assoc())
										{
											$i = $i + 1;
											?>
											<tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['bus_name']; ?>
                                                </td>
												
												
                                                <td class="align-middle">
                                                   <img src="<?php echo $row['op_img']; ?>" width="70" height="80"/>
                                                </td>
                                                
                                               
												<?php if($row['status'] == 1) { ?>
												
                                                <td><span class="badge badge-success"><?php echo $lang['Publish'];?></span></td>
												<?php } else { ?>
												
												<td>
												<span class="badge badge-danger"><?php echo $lang['UnPublish'];?></span></td>
												<?php } ?>
												
												<td>
												<?php $sales  = $bus->query("SELECT sum((subtotal -cou_amt) * ope_commission/100) as total_earning FROM `tbl_book` where book_status='Completed' and operator_id=".$row["id"]." and user_type='Operator'")->fetch_assoc();
	
	
	$bs=0;
	if(empty($sales['total_earning'])){}else {$bs = number_format((float)($sales['total_earning']), 2, '.', ''); }
	echo '<span class="badge badge-primary">'.$bs.$set['currency'].'</span>';
	?>
												</td>
												
												<td>
												<?php
$bss=0;
												$sales = $bus->query("select sum(amt) as total_earning from  tbl_cash where operator_id=".$row["id"]."")->fetch_assoc();
												if(empty($sales['total_earning'])){}else {$bss = number_format((float)($sales['total_earning']), 2, '.', ''); }
	echo '<span class="badge badge-primary">'.$bss.$set['currency'].'</span>';
	?>
												</td>
												
												<td><?php $remain =$bs-$bss; echo '<span class="badge badge-primary">'.number_format((float)($remain), 2, '.', '').$set['currency'].'</span>';?></td>
												
												
                                                <td style="white-space: nowrap; width: 15%;"><div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
                                           <div class="btn-group btn-group-sm" style="float: none;">
										   <a href="add_bus_operator.php?id=<?php echo $row['id'];?>" class="btn btn-info" style="    float: none;
    
    width: 50px;
    border-radius: 50% !important;
    height: 50px;
    padding: 14px;"><i class="fa fa-bus"></i></a>
										   <a href="?cid=<?php echo $row['id']; ?>" title="Manage Cash" ><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="48" height="48" rx="24" fill="#FFBC99"/>
<path d="M30 16H18C16 16 15 17 15 19V27C15 29 16 30 18 30H25.74C25.91 30 26.05 29.86 26.05 29.69C26.05 29.65 26.04 29.61 26.03 29.57C26.01 29.38 26 29.19 26 29C26 26.24 28.24 24 31 24C31.56 24 32.1 24.09 32.6 24.26C32.8 24.32 33 24.19 33 23.98V19C33 17 32 16 30 16ZM18 23.999C17.448 23.999 17 23.551 17 22.999C17 22.447 17.448 21.999 18 21.999C18.552 21.999 19 22.447 19 22.999C19 23.552 18.552 23.999 18 23.999ZM24 26C22.343 26 21 24.657 21 23C21 21.343 22.343 20 24 20C25.657 20 27 21.343 27 23C27 24.657 25.657 26 24 26ZM33.53 30.53L31.53 32.53C31.384 32.676 31.192 32.75 31 32.75C30.808 32.75 30.616 32.677 30.47 32.53L28.47 30.53C28.177 30.237 28.177 29.762 28.47 29.469C28.763 29.176 29.238 29.176 29.531 29.469L30.251 30.189V27C30.251 26.586 30.587 26.25 31.001 26.25C31.415 26.25 31.751 26.586 31.751 27V30.189L32.471 29.469C32.764 29.176 33.239 29.176 33.532 29.469C33.823 29.762 33.823 30.238 33.53 30.53Z" fill="#25314C"/>
</svg></a>


<a href="?hid=<?php echo $row['id']; ?>" title="Log Cash"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="48" height="48" rx="24" fill="#B1E5FC"/>
<path d="M30 16H18C16 16 15 17 15 19V27C15 29 16 30 18 30H25.74C25.91 30 26.05 29.86 26.05 29.69C26.05 29.65 26.04 29.61 26.03 29.57C26.01 29.38 26 29.19 26 29C26 26.24 28.24 24 31 24C31.56 24 32.1 24.09 32.6 24.26C32.8 24.32 33 24.19 33 23.98V19C33 17 32 16 30 16ZM18 23.999C17.448 23.999 17 23.551 17 22.999C17 22.447 17.448 21.999 18 21.999C18.552 21.999 19 22.447 19 22.999C19 23.552 18.552 23.999 18 23.999ZM24 26C22.343 26 21 24.657 21 23C21 21.343 22.343 20 24 20C25.657 20 27 21.343 27 23C27 24.657 25.657 26 24 26ZM33.53 29.53C33.384 29.676 33.192 29.75 33 29.75C32.808 29.75 32.616 29.677 32.47 29.53L31.75 28.81V32C31.75 32.414 31.414 32.75 31 32.75C30.586 32.75 30.25 32.414 30.25 32V28.811L29.53 29.531C29.237 29.824 28.762 29.824 28.469 29.531C28.176 29.238 28.176 28.763 28.469 28.47L30.469 26.47C30.762 26.177 31.237 26.177 31.53 26.47L33.53 28.47C33.823 28.762 33.823 29.238 33.53 29.53Z" fill="#25314C"/>
</svg></a>
										   </div>
                                           
                                       </div>
									   
									   </td>
                                                </tr>
											<?php 
										}
										?>
                          
                        </tbody>
                      </table>
				
					  </div>
					  </div>
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
   
  </body>


</html>