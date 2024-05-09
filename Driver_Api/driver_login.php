<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
if($data['email'] == ''  or $data['password'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $email = strip_tags(mysqli_real_escape_string($bus,$data['email']));
    $password = strip_tags(mysqli_real_escape_string($bus,$data['password']));
	
    
    $chek = $bus->query("select * from tbl_driver where email='".$email."' and status = 1 and password='".$password."'");
    $status = $bus->query("select * from tbl_driver where status = 1");
    if(true)
    {
        if($chek->num_rows != 0)
        {
            $c = $bus->query("select * from tbl_driver where  email='".$email."'  and status = 1 and password='".$password."'");
            $c = $c->fetch_assoc();
        	
            $returnArr = array("UserLogin"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Login successfully!");
        }
        else
        {
            $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"select * from tbl_driver where  email='".$email."'  and status = 1 and password='".$password."'");
        }
    }
    else  
    {
    	 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Your profile has been blocked by the administrator, preventing you from using our app as a regular user.");
    }
}

echo json_encode($returnArr);