<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';

header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$pol = array();
$c = array();
$sel = $bus->query("select * from tbl_bus_operator where status=1");
while($row = $sel->fetch_assoc())
{
   
		$pol['id'] = $row['id'];
		$pol['title'] = $row['bus_name'];
		$pol['lats'] = $row['lats'];
		$pol['longs'] = $row['longs'];
		$pol['address'] = $row['address'];
		$pol['op_img'] = $row['op_img'];
		$pol['rate'] = $row['rate'];
		
		$c[] = $pol;
	
	
}
if(empty($c))
{
	$returnArr = array("operatorlist"=>$c,"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Operator Not Founded!");
}
else 
{
$returnArr = array("operatorlist"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Operator List Founded!");
}
echo json_encode($returnArr);
?>