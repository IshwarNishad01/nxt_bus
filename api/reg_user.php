<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
require dirname( dirname(__FILE__) ).'/inc/Crud.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
function generate_random()
{
	require dirname( dirname(__FILE__) ).'/inc/Config.php';
	$six_digit_random_number = mt_rand(100000, 999999);
	$c_refer = $bus->query("select * from tbl_user where code=".$six_digit_random_number."")->num_rows;
	if($c_refer != 0)
	{
		generate_random();
	}
	else 
	{
		return $six_digit_random_number;
	}
}


if($data['name'] == '' or $data['email'] == '' or $data['mobile'] == ''   or $data['password'] == '' or $data['ccode'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
    $fname = strip_tags(mysqli_real_escape_string($bus,$data['name']));
    $email = strip_tags(mysqli_real_escape_string($bus,$data['email']));
    $mobile = strip_tags(mysqli_real_escape_string($bus,$data['mobile']));
	$ccode = strip_tags(mysqli_real_escape_string($bus,$data['ccode']));
	$user_type = strip_tags(mysqli_real_escape_string($bus,$data['user_type']));
    $password = strip_tags(mysqli_real_escape_string($bus,$data['password']));
    $refercode = strip_tags(mysqli_real_escape_string($bus,$data['rcode']));
    $checkmob = $bus->query("select * from tbl_user where mobile=".$mobile."");
    $checkemail = $bus->query("select * from tbl_user where email='".$email."'");
   
    if($checkmob->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Mobile Number Already Used!");
    }
     else if($checkemail->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Email Address Already Used!");
    }
    else
    {
        if($refercode != '')
	   {
		 $c_refer = $bus->query("select * from tbl_user where code=".$refercode."")->num_rows;
		 if($c_refer != 0)
		 {
			 
        
        $prentcode = generate_random();
		$wallet = $bus->query("select * from tbl_setting")->fetch_assoc();
		$fin = $wallet['scredit'];
        $timestamp = date("Y-m-d H:i:s");
        if($user_type == 'USER')
		{
		$table="tbl_user";
  $field_values=array("name","email","mobile","rdate","password","ccode","refercode","wallet","code","user_type","is_verify");
  $data_values=array("$fname","$email","$mobile","$timestamp","$password","$ccode","$refercode","$fin","$prentcode",'USER',1);
		}
		else 
		{
		$table="tbl_user";
  $field_values=array("name","email","mobile","rdate","password","ccode","refercode","wallet","code","user_type","is_verify");
  $data_values=array("$fname","$email","$mobile","$timestamp","$password","$ccode","$refercode","$fin","$prentcode",'AGENT',0);	
		}
  
      $h = new Crud($bus);
	  $check = $h->businsertdata_Api_Id($field_values,$data_values,$table);
	  $timestamps    = date("Y-m-d");
 $table="wallet_report";
  $field_values=array("uid","message","status","amt","tdate");
  $data_values=array("$check",'Sign up Credit Added!!','Credit',"$fin","$timestamps");
   
      $h = new Crud($bus);
	  $checks = $h->businsertdata_Api($field_values,$data_values,$table);
	  
 $c = $bus->query("select * from tbl_user where id=".$check."")->fetch_assoc();
    
        $returnArr = array("UserLogin"=>$c,"currency"=>$set['currency'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Sign Up Done Successfully!");
    }
	else 
		 {
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Refer Code Not Found Please Try Again!!");
	   }
	   }
	    else 
	   {
		   $timestamp = date("Y-m-d H:i:s");
		   $prentcode = generate_random();
		   if($user_type == 'USER')
		{
		   $table="tbl_user";
  $field_values=array("name","mobile","rdate","password","ccode","code","email","user_type","is_verify");
  $data_values=array("$fname","$mobile","$timestamp","$password","$ccode","$prentcode","$email",'USER',1);
		}
		else 
		{
			 $table="tbl_user";
  $field_values=array("name","mobile","rdate","password","ccode","code","email","user_type","is_verify");
  $data_values=array("$fname","$mobile","$timestamp","$password","$ccode","$prentcode","$email",'AGENT',0);
		}
   $h = new Crud($bus);
	  $check = $h->businsertdata_Api_Id($field_values,$data_values,$table);
  $c = $bus->query("select * from tbl_user where id=".$check."")->fetch_assoc();
  $returnArr = array("UserLogin"=>$c,"currency"=>$set['currency'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Sign Up Done Successfully!");
  
	   }
	}
    
    
}

echo json_encode($returnArr);