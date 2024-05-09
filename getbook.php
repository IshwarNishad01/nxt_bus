<?php
require 'inc/Config.php';
if(isset($_POST['start_date']) && isset($_POST['end_date']))
{
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$user_type = $_POST['user_type'];
	
	if($_SESSION['stype'] == 'sowner')
						   {
							   $city = $bus->query("SELECT * FROM `tbl_book` where book_date between '".$start_date."' and '".$end_date."' and user_type='".$user_type."' and operator_id=".$sdata["id"]." order by id desc");
						   }
						   else 
						   {
										$city = $bus->query("SELECT * FROM `tbl_book` where book_date between '".$start_date."' and '".$end_date."' and user_type='".$user_type."' order by id desc");
						   }
										$i=0;
										while($row = $city->fetch_assoc())
										{
											$busdata = $bus->query("SELECT * from tbl_bus where id=".$row['bus_id']."")->fetch_assoc();
											$totalseat = $bus->query("SELECT COUNT(*) AS total_count, GROUP_CONCAT(seat_no) AS total_seats FROM tbl_book_pessenger WHERE book_id=" . $row['id'])->fetch_assoc();
											$i = $i + 1;
											?>
											<tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
                                                
												
												
                                              
												
												<td>
                                                    <?php echo $busdata['title']; ?>
                                                </td>
												
												<td>
                                                    <?php $dateTime = new DateTime($row['bus_board_date']); 
													echo $dateTime->format('jS M Y, g:i A');
													?>
                                                </td>
												
												<td>
                                                    <?php 
                                                      $dateTime = new DateTime($row['bus_drop_date']);
echo $dateTime->format('jS M Y, g:i A');
													?>
                                                </td>
                                                
                                               <td>
                                                    <?php echo $row['total_seat']; ?>
                                                </td>
												
												<td>
                                                   <b><span class="text text-primary"> <?php echo $row['ticket_price'].$set['currency']; ?> </span></b>
                                                </td>
												
												
												<td><b><span class="text text-danger"><?php echo $totalseat['total_seats'];?></span></b></td>
												
												<td>
                                                    <?php echo $row['name']; ?>
                                                </td>
												<td>
                                                    <?php echo $row['ccode'].$row['mobile']; ?>
                                                </td>
												
												<td>
                                                    <span class="badge badge-<?php if($row['book_status']=='Cancelled'){echo 'danger';}elseif($row['book_status']=='Pending'){echo 'primary';}else{echo 'success';}?>"><?php echo $row['book_status']; ?></span>
                                                </td>
												
												<td>
                                                    <b><span class="text text-info"><?php echo $row['subtotal'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-info"><?php echo $row['wall_amt'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-info"><?php echo $row['cou_amt'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-info"><?php echo $row['tax_amt'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-success"><?php echo $row['total'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-danger"><?php echo $row['commission'].$set['currency'].'('.$row['comm_per'].'%)';?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-danger"><?php echo (($row['subtotal']-$row['cou_amt']) * $row['ope_commission']/100).$set['currency'].'('.$row['ope_commission'].'%)';?></span></b>
                                                </td>
												
												<td>
                                                    <b><span class="text text-danger"><?php echo ($row['subtotal']-($row['cou_amt']+$row['commission'])) - (($row['subtotal']-$row['cou_amt']) * $row['ope_commission']/100).$set['currency'];?></span></b>
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
												
												
												
												
												
                                                
												
                                                
										  
                                                </tr>
											<?php 
										}
										
}
?>