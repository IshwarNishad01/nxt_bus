<?php
require 'inc/Config.php';
if(isset($_POST['book_date']))
{
$timestamp = $_POST['book_date'];
                          if($_SESSION['stype'] == 'sowner')
						   {
							   $totalbook = $bus->query("select count(*) as total_book from tbl_book where book_date='".$timestamp."' and operator_id=".$sdata["id"]."")->fetch_assoc();
						   $totalcom = $bus->query("select count(*) as total_complete from tbl_book where book_date='".$timestamp."' and book_status='Completed' and operator_id=".$sdata["id"]."")->fetch_assoc();
						   $totalcan = $bus->query("select count(*) as total_complete from tbl_book where book_date='".$timestamp."' and book_status='Cancelled' and operator_id=".$sdata["id"]."")->fetch_assoc();
						   $sales  = $bus->query("SELECT sum((subtotal -(cou_amt+commission)) - ((subtotal -cou_amt) * ope_commission/100)) as total_earning FROM `tbl_book` where book_status='Completed' and book_date='".$timestamp."'")->fetch_assoc();
	
	
	$bs=0;
	if(empty($sales['total_earning'])){}else {$bs = number_format((float)($sales['total_earning']), 2, '.', ''); }
	
	
						   }
						   else 
						   {
						   $totalbook = $bus->query("select count(*) as total_book from tbl_book where book_date='".$timestamp."'")->fetch_assoc();
						   $totalcom = $bus->query("select count(*) as total_complete from tbl_book where book_date='".$timestamp."' and book_status='Completed'")->fetch_assoc();
						   $totalcan = $bus->query("select count(*) as total_complete from tbl_book where book_date='".$timestamp."' and book_status='Cancelled'")->fetch_assoc();
						   $sales  = $bus->query("SELECT sum(subtotal+tax_amt-cou_amt) as total_earning FROM `tbl_book` where book_status='Completed' and book_date='".$timestamp."'")->fetch_assoc();
	
	
	$bs=0;
	if(empty($sales['total_earning'])){}else {$bs = number_format((float)($sales['total_earning']), 2, '.', ''); }
	
	
						   }
	
	
?>
<tr>
											
											<td>
                                                   <b> <?php echo $lang['Total_Booked_Tickets'];?></b>
                                                </td>
												
                                                <td>
                                                    <b><span class="text text-warning"><?php echo $totalbook['total_book']; ?></span></b>
                                                </td>
                                                </tr>
												
												<tr>
												<td>
                                                   <b> <?php echo $lang['Total_Completed_Tickets'];?></b>
                                                </td>
												
                                                <td>
                                                   <b> <span class="text text-success"><?php echo $totalcom['total_complete']; ?></span></b>
                                                </td>
												
                                                </tr>
												
												<tr>
												<td>
                                                   <b> <?php echo $lang['Total_Cancelled_Tickets'];?></b>
                                                </td>
												
                                                <td>
                                                   <b> <span class="text text-danger"><?php echo $totalcan['total_complete']; ?></span></b>
                                                </td>
												
                                                </tr>
												
												<tr>
												<td>
                                                   <b> <?php echo $lang['Total_Sales'];?></b>
                                                </td>
												
                                                <td>
                                                   <b> <span class="text text-primary"><?php echo $bs.$set['currency']; ?></span></b>
                                                </td>
												
                                                </tr>
												
												
<?php 
}
?>