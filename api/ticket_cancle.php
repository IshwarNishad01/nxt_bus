<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
require dirname( dirname(__FILE__) ).'/inc/Crud.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$ticket_id = $data['ticket_id'];
$uid = $data['uid'];
$total = $data['total'];
$comment_reject = $data['comment_reject'];
if($ticket_id == '' or $uid == '' or $total == '' or $comment_reject == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
	$checkowner = $bus->query("select * from tbl_book where id=".$ticket_id." and uid=".$uid."")->num_rows;
	if($checkowner != 0)
	{
		$checkstatus = $bus->query("select * from tbl_book where id=".$ticket_id." and uid=".$uid." and book_status='Cancelled'")->num_rows;
		if($checkstatus != 0)
		{
			$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Ticket Already Cancelled!!");
		}
		else 
		{
			
		$getbusinfo = $bus->query("SELECT * FROM `tbl_book` where uid=".$uid." and id=".$ticket_id."")->fetch_assoc();
		$currentDatetime = new DateTime();
		
	    $specificDatetime = new DateTime(''.$getbusinfo['bus_board_date'].'');
		$interval = $currentDatetime->diff($specificDatetime);
    $remaining_hours = $interval->h + ($interval->days * 24);
	
	$sel = $bus->query("select * from tbl_policy order by rmat desc");
$arr = array();
while ($row = $sel->fetch_assoc()) {
    $hour = $row['hour'];
    $rmat = $row['rmat'];
    $arr[] = "WHEN $remaining_hours >= $hour THEN $rmat";
}

$query = "SELECT
            $remaining_hours AS remaining_hours,
            CASE
                " . implode(' ', $arr) . "
                ELSE 0
            END AS refund_percentage";

$result = $bus->query($query);
$p = $result->fetch_assoc();
	
		$per = $row['refund_percentage'];
		if ($per == 100) {
             $cal = number_format($total, 2);
                   } else {
             $cal = number_format($total - ($total * $per/100), 2);
        }
		$vp = $bus->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
		
		$table = "tbl_book";
		$field = array('book_status'=>'Cancelled','comment_reject'=>$comment_reject);
  $where = "where uid=".$uid." and id=".$ticket_id."";
$h = new Crud($bus);
	  $check = $h->busupdateData_Api($field,$table,$where);
	  
		$table="tbl_user";
  $field = array('wallet'=>$vp['wallet']+$cal);
  $where = "where id=".$uid."";
$h = new Crud($bus);
	  $check = $h->busupdateData_Api($field,$table,$where);
	  
	   $timestamp = date("Y-m-d H:i:s");
	   $timestamps    = date("Y-m-d");
	   $table="wallet_report";
  $field_values=array("uid","message","status","amt","tdate");
  $data_values=array("$uid",'Cancelled Ticket #'.$ticket_id.' Refund Amount!!','Credit',"$cal","$timestamps");
   
      $h = new Crud($bus);
	  $checks = $h->businsertdata_Api($field_values,$data_values,$table);
	  $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Ticket Cancelled Successfully!");
	  
	  $udata = $bus->query("select name from tbl_user where id=" . $uid . "")->fetch_assoc();
         $name = $udata['name'];

         $content = [
             "en" => $name . ', Your Book Trip #' . $ticket_id . ' Has Been Cancelled.',
         ];
         $heading = [
             "en" => "Trip Cancelled!!",
         ];

         $fields = [
             'app_id' => $set['one_key'],
             'included_segments' => ["Active Users"],
             'filters' => [['field' => 'tag', 'key' => 'user_id', 'relation' => '=', 'value' => $uid]],
             'contents' => $content,
             'headings' => $heading
         ];
         $fields = json_encode($fields);

         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
         curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json; charset=utf-8', 'Authorization: Basic ' . $set['one_hash']]);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_HEADER, false);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

         $response = curl_exec($ch);
         curl_close($ch);
		 
		}
	}
	else 
	{
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"You'r Not Owner Of this Ticket!!");
	}
}
echo json_encode($returnArr);