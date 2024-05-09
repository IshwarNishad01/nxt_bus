<?php
require 'inc/Config.php';
if(isset($_POST['bus_id']) && isset($_POST['book_date']))
{
$bus_id = $_POST['bus_id'];
$book_date = $_POST['book_date'];
$seat_no = $_POST['seat_no'];
$get = $bus->query("select * from tbl_book_pessenger where bus_id=".$bus_id." and book_date='".$book_date."' and seat_no='".$seat_no."'")->fetch_assoc();
$getcontact = $bus->query("select * from tbl_book where id=".$get['book_id']."")->fetch_assoc();
$totalseat = $bus->query("SELECT COUNT(*) AS total_count, GROUP_CONCAT(seat_no) AS total_seats FROM tbl_book_pessenger WHERE book_id=" . $get['book_id'])->fetch_assoc();
?>
<div class="passenger">
         <h4><?php echo $lang['Passenger_Details'];?></h4>
        <p><?php echo $lang['Name'];?>: <?php echo $get['name'];?></p>
        <p><?php echo $lang['Seat_No'];?>: <?php echo $get['seat_no'];?></p>
        <p><?php echo $lang['Gender'];?>: <?php echo $get['gender'];?></p>
        <p><?php echo $lang['Age'];?>: <?php echo $get['age'];?></p>
		<br>
		<h4><?php echo $lang['Contact_Details'];?></h4>
		<p><?php echo $lang['Contact_name'];?> : <?php echo $getcontact['name'];?></p>
		<p><?php echo $lang['Contact_number'];?> : <?php echo $getcontact['ccode'].$getcontact['mobile'];?></p>
		<br>
		<h4><?php echo $lang['Total_Seat_Details'];?></h4>
		<p><?php echo $lang['Total_Book_Seat'];?> : <?php echo $totalseat['total_count'];?></p>
		<p><?php echo $lang['Seat_No'];?>: <?php echo $totalseat['total_seats'];?></p>
		
    </div>
<?php 
}
?>