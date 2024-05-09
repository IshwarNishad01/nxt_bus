<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

if($data['uid'] == '' or $data['id_pickup_drop'] == '' )
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
	$pickup = array();
	$drop = array();
	$p = array();
	$d = array();
	
	$pick = $bus->query("select b.ptime,b.id,b.point_id,p.title,p.address,p.mobile from tbl_sub_route_time as b,tbl_points as p  where b.status=1 and b.board_id=".$data['id_pickup_drop']." and p.id = b.point_id");
	while($row = $pick->fetch_assoc())
	{
		$p['pick_id'] = $row['id'];
		$p['pick_time'] = $row['ptime'];
		$p['pick_place'] = $row['title'];
		$p['pick_address'] = $row['address'];
		$p['pick_mobile'] = $row['mobile'];
		$pickup[] = $p;
	}
	
	$dr = $bus->query("select b.ptime,b.id,b.point_id,p.title,p.address,p.mobile from tbl_drop_sub_route as b,tbl_points as p  where b.status=1 and b.board_id=".$data['id_pickup_drop']." and p.id = b.point_id");
	while($row = $dr->fetch_assoc())
	{   $d['drop_id'] = $row['id'];
		$d['drop_time'] = $row['ptime'];
		$d['drop_place'] = $row['title'];
		$d['drop_address'] = $row['address'];
		$d['drop_mobile'] = $row['mobile'];
		$drop[] = $d;
	}
	
$returnArr = array("PickUpStops"=>$pickup,"DropStops"=>$drop,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Bus Stop Get successfully!");
}
echo json_encode($returnArr);

?>