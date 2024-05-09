<?php
require 'inc/Config.php';
if(isset($_POST['start_date']) && isset($_POST['end_date']))
{
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	if($_SESSION['stype'] == 'sowner')
						   {
	$city = $bus->query("SELECT * FROM `tbl_book` where book_status='Completed' and book_date between '".$start_date."' and '".$end_date."' and operator_id=".$sdata["id"]." order by id desc");
						   }
						   else 
						   {
							 $city = $bus->query("SELECT * FROM `tbl_book` where book_status='Completed' and book_date between '".$start_date."' and '".$end_date."' order by id desc");  
						   }
	
										$i=0;
										while($row = $city->fetch_assoc())
										{
											$busdata = $bus->query("SELECT title from tbl_bus where id=".$row['bus_id']."")->fetch_assoc();
											
											$i = $i + 1;
											?>
											<tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
												<td>
                                                    <?php echo $row['id']; ?>
                                                </td>
                                          
												<td>
                                                    <?php echo $busdata['title']; ?>
                                                </td>
												
												
												<td>
                                                    <b><?php echo $row['subtotal'].$set['currency']; ?></b>
                                                </td>
												<td>
                                                    <b><span class="text text-success"><?php echo $row['tax_amt'].$set['currency'].'('.$row['tax'].'%)'; ?></span></b>
                                                </td>
												<td>
                                                   <b> <span class="text text-primary"><?php echo $row['wall_amt'].$set['currency']; ?></span></b>
                                                </td>
												
												<td>
                                                  <b>  <span class="text text-primary"><?php echo $row['cou_amt'].$set['currency']; ?></span></b>
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
                                                    <b><span class="text text-success"><?php echo $row['total'].$set['currency']; ?></span></b>
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