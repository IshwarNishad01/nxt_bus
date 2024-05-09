<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
require dirname( dirname(__FILE__) ).'/inc/Crud.php';
header('Content-type: text/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '' or $data['name'] == '' or $data['bus_id'] == '' or $data['email'] == '' or $data['ccode'] == '' or $data['mobile'] == '' or $data['pickup_id'] == '' or $data['drop_id'] == '' or $data['total'] == '' or $data['cou_amt'] == '' or $data['wall_amt'] == '' or $data['book_date'] == '' or $data['total_seat'] == '' or $data['payment_method_id'] == '' )
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
$uid = $data['uid'];
$vp = $bus->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
	 if($vp['wallet'] >= $data['wall_amt'])
	 {
$name = mysqli_real_escape_string($bus,$data['name']);
$bus_id = $data['bus_id'];
$operator_id = $data['operator_id'];
$getcommission = $bus->query("select * from  tbl_bus_operator where id=".$operator_id."")->fetch_assoc();
$email = $data['email'];
$ccode = $data['ccode'];
$mobile = $data['mobile'];
$tax_amt = $data['tax_amt'];
$tax = $set['tax'];
$pickup_id = $data['pickup_id'];
$drop_id = $data['drop_id'];
$ticket_price = $data['ticket_price'];
$total = $data['total'];
$cou_amt = $data['cou_amt'];
$boarding_city = $data['boarding_city'];
$drop_city = $data['drop_city'];
$wall_amt = $data['wall_amt'];
$bus_picktime = $data['bus_picktime'];
$bus_droptime = $data['bus_droptime'];
$Difference_pick_drop = $data['Difference_pick_drop'];
$book_date = $data['book_date'];
$total_seat = $data['total_seat'];
$payment_method_id = $data['payment_method_id'];
$transaction_id = $data['transaction_id'];
$seat_list = $data['seat_list'];
$sub_pick_time = $data['sub_pick_time'];
$sub_pick_place = $data['sub_pick_place'];
$sub_pick_address = $data['sub_pick_address'];
$sub_pick_mobile = $data['sub_pick_mobile'];
$sub_drop_time = $data['sub_drop_time'];
$sub_drop_place = $data['sub_drop_place'];
$sub_drop_address = $data['sub_drop_address'];
$subtotal = $data['subtotal'];
$user_type = $data['user_type'];
$commission = $data['commission'];
$comm_per = $data['comm_per'];
$admin_commission = $getcommission['admin_commission'];


$pick_datetime = new DateTime($book_date . ' ' . $bus_picktime);
$drop_datetime = new DateTime($book_date . ' ' . $bus_droptime);

// Check if the drop time is on the next date
if ($drop_datetime < $pick_datetime) {
    // Drop time is on the next date
	$pick_date = $pick_datetime->format('Y-m-d H:i:s');
    $next_date = $drop_datetime->modify('+1 day');
    $dropdate = $next_date->format('Y-m-d H:i:s');
} else {
    // Drop time is on the same date
    $dropdate = $drop_datetime->format('Y-m-d H:i:s');
	$pick_date = $pick_datetime->format('Y-m-d H:i:s');
}

$check = $bus->query("select * from tbl_book_pessenger where seat_no IN('".$seat_list."') and book_date='".$book_date."'")->num_rows;
if($check != 0)
{
$vp = $bus->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
	  $mt = intval($vp['wallet'])+$total;
	 
  $table="tbl_user";
  $field = array('wallet'=>"$mt");
  $where = "where id=".$uid."";
$h = new Crud($bus);
	  $check = $h->busupdateData_Api($field,$table,$where);
	  $tdate = date("Y-m-d");
	  $table="wallet_report";
  $field_values=array("uid","message","status","amt","tdate");
  $data_values=array("$uid",'Refund Paid Amount Which Is Not Booked','Credit',"$total","$tdate");
   
      $h = new Crud($bus);
	  $checks = $h->businsertdata_Api($field_values,$data_values,$table);
	  $tbwallet = $bus->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Choosen Seat Booked Please Select Another One!!","wallet"=>$tbwallet['wallet']);	

$udata = $bus->query("select name from tbl_user where id=" . $uid . "")->fetch_assoc();
         $name = $udata['name'];

         $content = [
             "en" => $name . ', Choosen Seat Booked Please Select Another One!!',
         ];
         $heading = [
             "en" => "Someone Booked!!",
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
else 
{
$table="tbl_book";
  $field_values=array("uid","operator_id","sub_pick_time","tax","sub_pick_place","sub_pick_address","subtotal","sub_pick_mobile","sub_drop_time","sub_drop_place","sub_drop_address","tax_amt","bus_picktime","bus_droptime","Difference_pick_drop","bus_id","ticket_price","boarding_city","drop_city","name","email","ccode","mobile","pickup_id","drop_id","total","cou_amt","wall_amt","book_date","total_seat","payment_method_id","transaction_id","bus_board_date","bus_drop_date","comm_per","commission","user_type","ope_commission");
  $data_values=array("$uid","$operator_id","$sub_pick_time","$tax","$sub_pick_place","$sub_pick_address","$subtotal","$sub_pick_mobile","$sub_drop_time","$sub_drop_place","$sub_drop_address","$tax_amt","$bus_picktime","$bus_droptime","$Difference_pick_drop","$bus_id","$ticket_price","$boarding_city","$drop_city","$name","$email","$ccode","$mobile","$pickup_id","$drop_id","$total","$cou_amt","$wall_amt","$book_date","$total_seat","$payment_method_id","$transaction_id","$pick_date","$dropdate","$comm_per","$commission","$user_type","$admin_commission");
  $h = new Crud($bus);
	  $book_id = $h->businsertdata_Api_Id($field_values,$data_values,$table);
	  
	  
	  $ProductData = $data['PessengerData'];
for($i=0;$i<count($ProductData);$i++)
{

$name = mysqli_real_escape_string($bus,$ProductData[$i]['name']);
$age = $ProductData[$i]['age'];
$seat_no = $ProductData[$i]['seat_no'];
$gender = $ProductData[$i]['gender'];

$table="tbl_book_pessenger";
  $field_values=array("book_id","bus_id","name","gender","seat_no","age","book_date");
  $data_values=array("$book_id","$bus_id","$name","$gender","$seat_no","$age","$book_date");
  
      $h = new Crud($bus);
	   $h->businsertdata_Api($field_values,$data_values,$table);
}
if($wall_amt != 0)
{
 $vp = $bus->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
	  $mt = intval($vp['wallet'])-intval($wall_amt);
  $table="tbl_user";
  $field = array('wallet'=>"$mt");
  $where = "where id=".$uid."";
$h = new Crud($bus);
	  $check = $h->busupdateData_Api($field,$table,$where);
	  $tdate = date("Y-m-d");
	  $table="wallet_report";
  $field_values=array("uid","message","status","amt","tdate");
  $data_values=array("$uid",'Wallet Used in Book Id#'.$book_id,'Debit',"$wall_amt","$tdate");
   
      $h = new Crud($bus);
	  $checks = $h->businsertdata_Api($field_values,$data_values,$table);
}
$tbwallet = $bus->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Book Ticket Successfully!!!","wallet"=>$tbwallet['wallet']);	

 $udata = $bus->query("select name from tbl_user where id=" . $uid . "")->fetch_assoc();
         $name = $udata['name'];

         $content = [
             "en" => $name . ', Your Book Trip #' . $book_id . ' Has Been Received.',
         ];
         $heading = [
             "en" => "Trip Received!!",
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
		 $tbwallet = $bus->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$returnArr = array("ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Wallet Balance Not There As Per Ticket Total Price Refresh One Time Screen!!!","wallet"=>$tbwallet['wallet']);
	 }
}
echo json_encode($returnArr);