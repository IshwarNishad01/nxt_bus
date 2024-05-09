<?php 
require 'inc/Config.php';
$point = $bus->query("select * from tbl_points where city_id=".$_POST["mainid"]."");
?>
<option value=""><?php echo $lang['Select_A_Point'];?></option>
<?php
while($row = $point->fetch_assoc())
{
	?>
	<option value="<?php echo $row["id"];?>"><?php echo $row["title"];?></option> 
	<?php 
	
}
?>