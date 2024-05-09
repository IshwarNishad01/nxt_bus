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
                  <h3><?php echo $lang['Ticket_List_Management'];?></h3>
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
							<th><?php echo $lang['Ticket_No'];?>.</th>
							<th><?php echo $lang['Bus_Number'];?>.</th>
							<th><?php echo $lang['Bus_Name'];?></th>
							<th><?php echo $lang['Customer_Name'];?></th>
							<th><?php echo $lang['Customer_Email'];?></th>
							<th><?php echo $lang['Customer_Mobile'];?></th>
							<th><?php echo $lang['From_City'];?></th>
							<th><?php echo $lang['To_City'];?></th>
							<th><?php echo $lang['Total_Seat'];?></th>
							<th><?php echo $lang['Seat_No'];?></th>
							<th><?php echo $lang['Book_by'];?></th>
							<th><?php echo $lang['Action'];?></th>
                          </tr>
                        </thead>
                        <tbody>
                           <?php 
										$city=  $bus->query("SELECT 
    b.id, 
    b.name, 
    b.bus_id,
    b.email, 
    b.ccode, 
    b.mobile, 
    b.boarding_city, 
    b.drop_city, 
    b.total_seat, 
	b.user_type,
    (SELECT GROUP_CONCAT(seat_no) 
     FROM tbl_book_pessenger 
     WHERE FIND_IN_SET(tbl_book_pessenger.book_id, b.id)
    ) AS bus_seat_list,
    t.title,
    t.bno
FROM tbl_book AS b
JOIN tbl_bus AS t ON b.bus_id = t.id
WHERE b.operator_id = ".$sdata["id"]." order by b.id desc");
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
                                                    <?php echo '#'.$row['id']; ?>
                                                </td>
												
												
												
												<td>
                                                   <span class="badge badge-success">  <?php echo $row['bno']; ?> </span>
                                                </td>
												
												<td>
                                                    <?php echo $row['title']; ?>
                                                </td>
												<td>
                                                    <?php echo $row['name']; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['email']; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['ccode'].$row['mobile']; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['boarding_city']; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['drop_city']; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['total_seat']; ?>
                                                </td>
												
												<td>
                                                    <?php echo $row['bus_seat_list']; ?>
                                                </td>
												
												<td>
												<?php if ($row['user_type'] === 'USER') { ?>
        <span class="badge badge-primary"><?php echo $lang['USER'];?></span>
    <?php } else if ($row['user_type'] === 'AGENT') { ?>
        <span class="badge badge-danger"><?php echo $lang['AGENT'];?></span>
    <?php }else  { ?>
        <span class="badge badge-danger"><?php echo $lang['OPERATOR'];?></span>
    <?php } ?>
	</td>
	
												<td>
                                                    <button class="preview_d btn btn-primary" data-id="<?php echo $row['id'];?>" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-eye"></i></button>
                                                </td>
												
                                               
                                                
                                               
												
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
	
	<div div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    
    <div class="modal-content">
      <div class="modal-header">
        <h4><?php echo $lang['Ticket_Preivew'];?></h4>
        <button type="button" class="close" data-bs-dismiss="modal" style="position: absolute;
    right: 0;
    top: 0;
    width: 50px;
    height: 50px;
    border-radius: 29px;
    padding: 10px;
    background: #D9534F;
    color: #fff;
    opacity: 1;">&times;</button>
      </div>
      <div class="modal-body p_data">
      
      </div>
     
    </div>

  </div>
</div>
    <!-- latest jquery-->
   <?php require 'inc/Footer.php'; ?>
    <!-- login js-->
	<script>
	$(document).ready(function()
{
	$("#basic-1").on("click", ".preview_d", function()
	{
		var id = $(this).attr('data-id');
		$.ajax({
			type:'post',
			url:'ticket_data.php',
			data:
			{
				ticket_id:id
			},
			success:function(data)
			{
				
				$('#myModal').modal('show');
				$(".p_data").html(data);
			}
		});
	});
	
	
});
</script>
<style>
button.fa.fa-picture-o.btn.btn-primary.text-right.cmd {
    position: absolute;
    top: -66px;
    right: 85px;
}
</style>
  </body>


</html>