<?php 

require 'inc/Config.php';

$ticket_id = $_POST['ticket_id'];
$c = $bus->query("select * from tbl_book where id=".$ticket_id."")->fetch_assoc();
$udata = $bus->query("select * from tbl_user where id=".$c['uid']."")->fetch_assoc();
$pdata = $bus->query("select * from tbl_payment_list where id=".$c['payment_method_id']."")->fetch_assoc();
$bdata = $bus->query("select * from tbl_bus where id=".$c['bus_id']."")->fetch_assoc();
$bac = $bdata['bac'];
$is_sleeper = $bdata['is_sleeper'];

if($is_sleeper == 1 && $bac == 1)
{
	$bus_type = 'A/c Sleeper'; 
}
else if($is_sleeper == 1 && $bac == 0)
{
	$bus_type = 'Non A/c Sleeper'; 
}
else if($is_sleeper == 0 && $bac == 1)
{
	$bus_type = 'A/c Seater'; 
}
else 
{
	$bus_type = 'Non A/c Seater';
}
$pick_datetime = new DateTime($c['bus_board_date']);
$drop_datetime = new DateTime($c['bus_drop_date']);
$pick_date = $pick_datetime->format('Y-m-d');
$dropdate = $drop_datetime->format('Y-m-d');

?>

<div style="margin-left: auto;">

<button class="fa fa-picture-o btn btn-primary text-right cmd" style="float:right;"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></button>

</div>

<div id="divprint">
 <div class="row">
			 <div class="col-9 mb-3">
                <img src="<?php echo $bdata['bus_img'];?>" class="rounded-circle shadow-4-strong" width="60px" height="60px" style="float: left; margin-right: 10px;"/>
                <div style="float: left;">
                    <h5 class="b_title" style="margin-bottom: 0;"><?php echo $bdata['title'];?></h5>
                    <p style="margin-bottom: 0;"><?php echo $bus_type;?> </p>
                   
                </div>
				</div>
				<div class="col-3 mb-3">
                <div style="float:right;">
                    <h5 style="margin-bottom: 0;"><b><?php echo $c['ticket_price'].$set['currency'];?></b></h5>
                </div>
				</div>
				<div class="col-4 text-start mb-3">
				<p class="fw-bolder"><?php echo $c['boarding_city'];?><br>
				<span class="text text-primary"><?php echo date("h:i A", strtotime($c['bus_picktime']));?></span><br>
				<?php echo $pick_date;?></p>
				</div>
				<div class="col-4 mb-3 text-center">
				<img src="images/bicon.png">
				<p class="fw-bolder"><?php echo $row['Difference_pick_drop'];?></p>
				</div>
				<div class="col-4 text-end mb-3">
				<p class="fw-bolder"><?php echo $c['drop_city'];?><br>
				<span class="text text-primary"><?php echo date("h:i A", strtotime($c['bus_droptime']));?></span><br>
				<?php echo $dropdate;?></p>
				</div>
				
				<div class="col-4">
	<h5><?php echo $c['sub_pick_place'];?> <br> <?php echo $c['boarding_city'];?></h5>
	<p><?php echo date("h:i A", strtotime($c['bus_picktime']));?></p>
	</div>
	<div class="col-4 text-center">
	<img src="images/rightarr.png" height="80px"/>
	</div>
	<div class="col-4 text-end">
	<h5><?php echo $c['sub_drop_place'];?> <br> <?php echo $c['drop_city'];?></h5>
	<p><?php echo date("h:i A", strtotime($c['bus_droptime']));?></p>
	</div>
	<div class="col-12 mb-3">
	<h5><b><?php echo $lang['Bus_Details_And_Transaction_Details'];?></b></h5>
	</div>
	
	<div class="col-6 fw-bold text text-info">
<?php echo $lang['Ticket_Id'];?>
	</div>
	
	<div class="col-6 fw-bold text-end mb-3 text text-info">
	<?php echo '#'.$ticket_id;?>
	</div>
	
	<div class="col-6 fw-bold text text-primary">
	<?php echo $lang['Booking_Date'];?>
	</div>
	
	<div class="col-6 fw-bold text-end mb-3 text text-primary">
	<?php echo $c['book_date'];?>
	</div>
	
	<div class="col-6 fw-bold text-warning">
	<?php echo $lang['Payment_Method'];?>
	</div>
	
	<div class="col-6 fw-bold text-end mb-3 text text-warning">
	<?php echo $pdata['title'];?>
	</div>
	
	<div class="col-6 fw-bold text text-danger">
	<?php echo $lang['Transaction_Id'];?>
	</div>
	
	<div class="col-6 fw-bold text-end mb-3 text text-danger">
	<?php echo $c['transaction_id'];?>
	</div>
	
	<div class="col-12 fw-bold mb-3">
	<h5><b><?php echo $lang['PassengerS'];?></b></h5>
	
	</div>
	
	<div class="col-4 mb-3 fw-bold">
<?php echo $lang['Name'];?>
	</div>
	<div class="col-4 mb-3 fw-bold">

	</div>
	
	<div class="col-2 text-end mb-3 fw-bold">
	<?php echo $lang['Age'];?>
	</div>
	<div class="col-2 text-end mb-3 fw-bold">
	<?php echo $lang['Seat'];?>
	</div>
	
	<?php 
	$pess = $bus->query("select * from tbl_book_pessenger where book_id=".$ticket_id."");
	while($row = $pess->fetch_assoc())
	{
		?>
		<div class="col-4 mb-3 fw-bold">
<?php echo $row['name'].'( '.$row['gender'].' )';?>
	</div>
	<div class="col-4 mb-3 fw-bold">

	</div>
	
	<div class="col-2 text-end mb-3 fw-bold">
	<?php echo $row['age'];?>
	</div>
	<div class="col-2 text-end mb-3 fw-bold">
	<?php echo $row['seat_no'];?>
	</div>
		<?php
	}
	?>
	
	<div class="col-12 mb-3 fw-bold">
	<h5><b><?php echo $lang['Contact_Details'];?></b></h5>
	
	</div>
	
	<div class="col-6 fw-bold text text-primary">
<?php echo $lang['Full_Name'];?>
	</div>
	
	<div class="col-6 text-end mb-3 fw-bold text text-primary">
	<?php echo $c['name'];?>
	</div>
	
	<div class="col-6 fw-bold text text-danger">
	<?php echo $lang['Email_Address'];?>
	</div>
	
	<div class="col-6 text-end mb-3 fw-bold text text-danger">
	<?php echo $c['email'];?>
	</div>
	
	<div class="col-6 fw-bold text text-warning">
	<?php echo $lang['Phone_Number'];?>
	</div>
	
	<div class="col-6 text-end mb-3 fw-bold text text-warning">
	<?php echo $c['ccode'].$c['mobile'];?>
	</div>
	
	<div class="col-12 mb-3 fw-bold">
	<h5><b><?php echo $lang['Price_Details'];?></b></h5>
	
	</div>
	
	<div class="col-6 fw-bold text text-primary">
<?php echo $lang['Subtotal'];?>
	</div>
	
	<div class="col-6 text-end mb-3 fw-bold text text-primary">
	<?php echo $c['subtotal'].$set['currency'];?>
	</div>
	
	<div class="col-6 fw-bold text text-danger">
	<?php echo $lang['Tax'];?>(<?php echo $c['tax'];?>)
	</div>
	
	<div class="col-6 text-end mb-3 fw-bold text text-danger">
	<?php echo $c['tax_amt'].$set['currency'];?>
	</div>
	
	<div class="col-6 fw-bold text text-info">
	<?php echo $lang['Discount'];?>
	</div>
	
	<div class="col-6 text-end mb-3 fw-bold text text-info">
	<?php echo $c['cou_amt'].$set['currency'];?>
	</div>
	
	<div class="col-6 fw-bold text text-warning">
	<?php echo $lang['Wallet'];?>
	</div>
	
	<div class="col-6 text-end mb-3 fw-bold text text-warning">
	<?php echo $c['wall_amt'].$set['currency'];?>
	</div>
	<div class="col-12">
	<hr style="border:1px solid;">
	</div>
	<div class="col-6 fw-bold text text-success">
	<?php echo $lang['Total_Fare_Price'];?>
	</div>
	
	<div class="col-6 text-end mb-3 fw-bold text text-success">
	<?php echo $c['total'].$set['currency'];?>
	</div>
	
	
				</div>
				
				
	
	
  
              
</div>