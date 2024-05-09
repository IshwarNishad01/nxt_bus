<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

if($data['bus_id'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
  $bus_id = $data['bus_id'];
    $bov = array();
	$kol = array();
	$rev = $bus->query("select * from tbl_book where bus_id=".$bus_id." and book_status='Completed' and is_rate=1 order by id desc");
	while($k = $rev->fetch_assoc())
	{
		$udata = $bus->query("select * from tbl_user where id=".$k['uid']."")->fetch_assoc();
		
		$bov['user_title'] = $udata['name'];
		$bov['user_rate'] = $k['total_rate'];
		$bov['review_date'] = $k['review_date'];
		$bov['user_desc'] = $k['rate_text'];
		$kol[] = $bov;
		
	}
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Review Data Get Successfully!","reviewdata"=>$kol);
}
echo json_encode($returnArr);