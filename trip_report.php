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
                  <h3><?php echo $lang['Trip_List_Management'];?></h3>
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
				<div class="table-responsive">
                <table class="display" id="basic-1">
                        <thead>
                          <tr>
                                                <th><?php echo $lang['Sr_No'];?>.</th>
                                               <th><?php echo $lang['Bus_Name'];?></th>
												<th><?php echo $lang['Driver_Name'];?></th>
                                                <th><?php echo $lang['Trip_report'];?></th>
                                                <th><?php echo $lang['report_date'];?></th>
												 
                                                

                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php 
											 $stmt = $bus->query("SELECT * FROM tbl_report");
$i = 0;
while($row = $stmt->fetch_assoc())
{
	$i = $i + 1;
	$busname = $bus->query("SELECT title from tbl_bus where id=".$row['bus_id']."")->fetch_assoc();
	$drivername = $bus->query("SELECT driver_name from tbl_driver where id=".$row['driver_id']."")->fetch_assoc();
											?>
                                                <tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                <td> <?php echo $busname['title']; ?></td>
												<td> <?php echo $drivername['driver_name']; ?></td>
                                                <td> <?php echo $row['comment']; ?></td>
                                                <td> <?php echo $row['report_date']; ?></td>
                                                </tr>
											<?php 
										}
										?>
                                           
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