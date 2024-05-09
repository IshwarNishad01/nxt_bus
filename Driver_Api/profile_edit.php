<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
require dirname( dirname(__FILE__) ).'/inc/Crud.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['name'] == '' or $data['password'] == '' or $data['driver_id'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
    $name = strip_tags(mysqli_real_escape_string($bus,$data['name']));
   
    $mobile = strip_tags(mysqli_real_escape_string($bus,$data['mobile']));
     $password = strip_tags(mysqli_real_escape_string($bus,$data['password']));
	 
$driver_id =  strip_tags(mysqli_real_escape_string($bus,$data['driver_id']));
$checkimei = $bus->query("select * from tbl_driver where  `id`=".$driver_id."")->num_rows;

if($checkimei == 0)
    {
		     $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Driver Not Exist!!!!");  
	}

else 
{	
	   $table="tbl_driver";
  $field = array('driver_name'=>$name,'password'=>$password,'mobile'=>$mobile);
  $where = "where id=".$driver_id."";
$h = new Crud($bus);
	  $check = $h->busupdateData_Api($field,$table,$where);
	  
            $c = $bus->query("select * from tbl_driver where  `id`=".$driver_id."")->fetch_assoc();
        $returnArr = array("UserLogin"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Profile Update successfully!");
        
    
	}
    
}

echo json_encode($returnArr);