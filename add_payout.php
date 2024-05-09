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
                  <h3><?php echo $lang['Payout_Management'];?></h3>
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
				<div class="row">
						<div class="col-md-4">
			<div class="media-body text-center" style="background:#5c61f2;padding:10px;color:#fff;border-radius:5px;">
                <h6 style="color:#fff;"><?php $sales  = $bus->query("select sum((subtotal -(cou_amt+commission)) - ((subtotal -cou_amt) * ope_commission/100)) as full_total from tbl_book where   operator_id=".$sdata['id']."")->fetch_assoc();
				                               
											 $with = (empty($sales['full_total'])) ? 0 : $sales['full_total']; 
											 

             $payout =   $bus->query("select sum(amt) as full_payout from bus_payout_setting where operator_id=".$sdata['id']."")->fetch_assoc();
			 $finalpayout = (empty($payout['full_payout'])) ? 0 : $payout['full_payout'];
                 $bs = 0;
				
				 if($with == 0){ $wallet = $bs ; echo $bs.' '.$set['currency'];}else { $wallet = number_format((float)($with) - $finalpayout, 2, '.', '') ; echo  number_format((float)($with) - $finalpayout, 2, '.', '').' '.$set['currency']; } ?></h6>
                <span><?php echo $lang['Wallet_Balance'];?></span>
              </div>
			  </div>
			  <div class="col-md-4">
			  </div>
			  <div class="col-md-4">
			<div class="media-body text-center" style="background:#5c61f2;padding:10px;color:#fff;border-radius:5px;">
                <h6 class="mb-1" style="color:#fff;"><?php echo $set['operator_limit'].' '.$set['currency'];?></h6>
                <span><?php echo $lang['Wallet_Min_Balance_For_Withdraw'];?></span>
              </div>
			  </div>
			  </div>
				<br>		 
		<form method="post" enctype="multipart/form-data">
				
                                       <div class="form-group mb-3">
                                            <label><?php echo $lang['Amount'];?></label>
                                            <input type="number" min="1" step="0.01"  class="form-control" placeholder="<?php echo $lang['Enter_Amount'];?>" name="amt" required="">
											<input type="hidden" name="type" value="add_payout"/>
										
                                        </div>
										 
                                        
										<div class="form-group mb-3">
                                            <label><?php echo $lang['Select_Payout_Type'];?></label>
                                            <select name="r_type" id="r_type" class="form-control" required>
											<option value="" ><?php echo $lang['Select_Option'];?></option>
											<option value="UPI" ><?php echo $lang['UPI'];?></option>
											<option value="BANK Transfer"  ><?php echo $lang['BANK_Transfer'];?></option>
											<option value="Paypal"  ><?php echo $lang['Paypal'];?></option>
											</select>
                                        </div>
										
										<div class="form-group mb-3 div1">
                                            <label><?php echo $lang['UPI_ID'];?></label>
                                            <input type="text" class="form-control" id="upi_id" name="upi_id" placeholder="<?php echo $lang['Enter_UPI_ID'];?>">
											
										
                                        </div>
										
										
										
										<div class="form-group mb-3 div2">
                                            <label><?php echo $lang['Paypal_ID'];?></label>
                                            <input type="text"   class="form-control" id="paypal_id" name="paypal_id" placeholder="<?php echo $lang['Enter_Paypal_ID'];?>">
											
										
                                        </div>
										
										<div class="form-group mb-3 div3">
                                            <label><?php echo $lang['Account_Number'];?></label>
                                            <input type="text"   class="form-control" id="acc_number" name="acc_number" placeholder="<?php echo $lang['Enter_Account_Number'];?>">
											
										
                                        </div>
										
										<div class="form-group mb-3 div4">
                                            <label><?php echo $lang['Bank_Name'];?></label>
                                            <input type="text"   class="form-control" id="bank_name" name="bank_name" placeholder="<?php echo $lang['Enter_Bank_Name'];?>">
											
										
                                        </div>
										
										<div class="form-group mb-3 div5">
                                            <label><?php echo $lang['Recipient_Name'];?></label>
                                            <input type="text"   class="form-control" id="acc_name" name="acc_name" placeholder="<?php echo $lang['Enter_Recipient_Name'];?>">
											
										
                                        </div>
										
										<div class="form-group mb-3 div6">
                                            <label><?php echo $lang['Bank_Code_IFSC'];?></label>
                                            <input type="text"   class="form-control" id="ifsc_code" name="ifsc_code" placeholder="<?php echo $lang['Enter_Bank_Code_IFSC'];?>">
											
										
                                        </div>
										
										
										
										
	
										
										<div class="form-group mb-3">
                                                <button type="submit" class="btn btn-primary mb-2"><?php echo $lang['Request_Payout'];?></button>
                                            </div>
											</div>
                                    </form> 
								
				</div>
                </div>
            
            </div>
			<div class="col-sm-12">
             <div class="card">
                <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                        <thead>
                                                <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                               
                                    <th><?php echo $lang['Amount'];?></th>
                                   
									
									<th><?php echo $lang['Transfer_Details'];?></th>
                                    <th><?php echo $lang['Transfer_Type'];?></th>
									
									<th><?php echo $lang['Transfer_Photo'];?></th>
									
									 <th><?php echo $lang['Status'];?></th>

                                                </tr>
                                            </thead>
                                        <tbody>
                                            <?php 
											 $stmt = $bus->query("SELECT * FROM `bus_payout_setting` where operator_id=".$sdata["id"]."");
$i = 0;
while($row = $stmt->fetch_assoc())
{
	$i = $i + 1;
											?>
                                                <tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                               
                                    <td><?php echo $row['amt'].' '.$set['currency'];?></td>
									
									<?php 
									if($row['r_type'] == 'UPI')
									{
									  ?>
									  <td><?php echo $row['upi_id'];?></td>
									  <?php 
									}
									else if($row['r_type'] == 'BANK Transfer')
									{
									 ?>
									<td><?php echo 'Bank Name: '.$row['bank_name'].'<br>'.'A/C No: '.$row['acc_number'].'<br>'.'A/C Name: '.$row['receipt_name'].'<br>'.'IFSC CODE: '.$row['ifsc'].'<br>';?></td>
									 <?php 
									}
									else 
									{
									   ?>
									   <td><?php echo $row['paypal_id'];?></td>
									   <?php 
									}
									?>
									
									<td><?php echo $row['r_type'];?></td>
									 
									 <?php
									 if($row['proof'] == '')
									 {
										 ?>
										 <td></td>
										 <?php
									 }else {
									     ?>
									 
									  <td><img src="<?php echo $row['proof']; ?>" width="70" height="80"/></td>
									  <?php } ?>
									 <td><span class="badge badge-success"><?php echo ucfirst($row['status']);?></span></td>
                                     
                                                </tr>
<?php } ?>                                           
                                        </tbody>
                      </table>
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
	$("#upi_id").hide();
	$("#paypal_id").hide();
	$("#acc_number").hide();
	$("#bank_name").hide();
	$("#acc_name").hide();
	$("#ifsc_code").hide();
	$(".div1").hide();
	$(".div2").hide();
	$(".div3").hide();
	$(".div4").hide();
	$(".div5").hide();
	$(".div6").hide();
	
	$(document).on('change','#r_type',function(e) {
	var val = $(this).val();
	if(val == '')
	{
	$("#upi_id").hide();
	$("#paypal_id").hide();
	$("#acc_number").hide();
	$("#bank_name").hide();
	$("#acc_name").hide();
	$("#ifsc_code").hide();
	$(".div1").hide();
	$(".div2").hide();
	$(".div3").hide();
	$(".div4").hide();
	$(".div5").hide();
	$(".div6").hide();
	}
	else if(val == 'UPI')
	{
	$("#upi_id").show();
	$("#paypal_id").hide();
	$("#acc_number").hide();
	$("#bank_name").hide();
	$("#acc_name").hide();
	$("#ifsc_code").hide();
	$(".div1").show();
	$(".div2").hide();
	$(".div3").hide();
	$(".div4").hide();
	$(".div5").hide();
	$(".div6").hide();
	
	$('#upi_id').attr('required', 'required');
	$("#paypal_id").removeAttr("required");
	$("#acc_number").removeAttr("required");
	$("#bank_name").removeAttr("required");
	$("#acc_name").removeAttr("required");
	$("#ifsc_code").removeAttr("required");
	}
	else if(val == 'Paypal')
	{
	$("#upi_id").hide();
	$("#paypal_id").show();
	$("#acc_number").hide();
	$("#bank_name").hide();
	$("#acc_name").hide();
	$("#ifsc_code").hide();
	$(".div1").hide();
	$(".div2").show();
	$(".div3").hide();
	$(".div4").hide();
	$(".div5").hide();
	$(".div6").hide();
	
	$('#paypal_id').attr('required', 'required');
	$("#upi_id").removeAttr("required");
	$("#acc_number").removeAttr("required");
	$("#bank_name").removeAttr("required");
	$("#acc_name").removeAttr("required");
	$("#ifsc_code").removeAttr("required");
	}
	else 
	{
	$("#upi_id").hide();
	$("#paypal_id").hide();
	$("#acc_number").show();
	$("#bank_name").show();
	$("#acc_name").show();
	$("#ifsc_code").show();
	$(".div1").hide();
	$(".div2").hide();
	$(".div3").show();
	$(".div4").show();
	$(".div5").show();
	$(".div6").show();	
	$('#acc_number').attr('required', 'required');
	$('#bank_name').attr('required', 'required');
	$('#acc_name').attr('required', 'required');
	$('#ifsc_code').attr('required', 'required');
	$("#upi_id").removeAttr("required");
	$("#paypal_id").removeAttr("required");
	}
	});
	</script>
  </body>


</html>