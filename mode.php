<?php 
require 'inc/Config.php';
if($_SESSION['stype'] == 'sowner')
		{
echo $sdata['dark_mode'];
		}
		else 
		{
			echo $set['show_dark'];
		}

?>