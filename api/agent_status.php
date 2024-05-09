<?php 
require dirname( dirname(__FILE__) ).'/inc/Config.php';
header('Content-type: text/json');
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Agent Status Get Successfully!","agent_status"=>$set['agent_status']);
echo json_encode($returnArr);