<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';

header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '')
{
    
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
$uid =  strip_tags(mysqli_real_escape_string($bus,$data['uid']));
$checkimei = mysqli_num_rows(mysqli_query($bus,"select * from tbl_user where  `id`=".$uid.""));
$getearning = $bus->query("select sum(`commission`) as total_cal_commission from tbl_book where uid=".$uid." and user_type='AGENT' and book_status='Completed'")->fetch_assoc();
$calearning = empty($getearning['total_cal_commission']) ? "0" : number_format($getearning['total_cal_commission'],2);

$payout =   $bus->query("select sum(amt) as full_payout from payout_setting where agent_id=".$uid."")->fetch_assoc();
			$finalpayout = empty($payout['full_payout']) ? 0 : $payout['full_payout'];
                 $bs = 0;
				
				
				 if($getearning['total_cal_commission'] == ''){}else {$bs = number_format((float)($calearning)- $finalpayout, 2, '.', ''); }
				 
if($checkimei != 0)
    {
		$wallet = $bus->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
		
       $sel = $bus->query("select message,status,amt from wallet_report where uid=".$uid." order by id desc");
$myarray = array();
$l=0;
$k=0;
$p = array();
while($row = $sel->fetch_assoc())
{
	if($row['status'] == 'Credit')
	{
	$l = $l + $row['amt'];	
	}
	else 
	{
		$k = $k + $row['amt'];
	}
	$p['message'] = $row['message'];
	$p['status'] = $row['status'];
	$p['amt'] = $row['amt'];
	
	$myarray[] = $p;
}
    $returnArr = array("Walletitem"=>$myarray,"wallet"=>$wallet['wallet'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Wallet Report Get Successfully!","Agent_Earning"=>$bs);
	}
    else
    {
      $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Request To Update Own Device!!!!");  
    }
    
}

echo json_encode($returnArr);