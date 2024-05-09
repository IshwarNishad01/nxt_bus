<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
require dirname( dirname(__FILE__) ).'/inc/Crud.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

if($data['book_id'] == '' || $data['book_id'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $seat_no_cancel =  strip_tags(mysqli_real_escape_string($bus,$data['seat_no_cancel']));
	$seat_no_conform =  strip_tags(mysqli_real_escape_string($bus,$data['seat_no_conform']));
	$book_id =  strip_tags(mysqli_real_escape_string($bus,$data['book_id']));
	$book_date = $data['book_date'];
	$date = date("Y-m-d");
	$count = $bus->query("select * from tbl_book_pessenger where book_id='".$book_id."' and check_in!=0")->num_rows;
	$realbook = $bus->query("select * from tbl_book_pessenger where book_id='".$book_id."'")->num_rows;
	$check_status = $bus->query("select * from tbl_book where id=".$book_id."")->fetch_assoc();
	if($book_date != $date)
	{
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"The ticket is not scannable as the current date does not correspond to the date indicated in the book.");
	}
	else if($check_status['book_status'] == 'Cancelled')
	{
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"The ticket cannot be scanned because it has already been canceled.");
	}
	else if($count == $realbook)
	{
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"All Seat Verified Already!!");
	}
	else 
	{
    if($seat_no_conform != '')
	{
		$cj = explode(',',$seat_no_conform);
		foreach($cj as $seat)
		{
	    $table = "tbl_book_pessenger";

            $field = "check_in=1";

            $where = "where seat_no='" . $seat . "' and book_id='".$book_id."' and book_date='".$book_date."'";

            $h = new Crud($bus);
           
            $check = $h->busupdateData_single($field, $table, $where);	
		}
			
	}
    if($seat_no_cancel != '')
	{
		
		$cancle_reason = $data['cancle_reason'];
		$cj = explode(',',$seat_no_cancel);
		foreach($cj as $seat)
		{
		$table="tbl_book_pessenger";
  $field = array('check_in'=>2,"cancle_reason"=>$cancle_reason);
  $where = "where seat_no='" . $seat . "' and book_id='".$book_id."' and book_date='".$book_date."'";
$h = new Crud($bus);
	  $check = $h->busupdateData_Api($field,$table,$where);
	   
		}	
	}
	
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Seat Status Set Successfully!!");
	}
}
echo  json_encode($returnArr);
?>