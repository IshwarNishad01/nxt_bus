<?php
require "Config.php";
require "Crud.php";

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_POST["type"])) {
    if ($_POST["type"] == "login") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $stype = $_POST["stype"];
        if ($stype == "mowner") {
            $h = new Crud($bus);

            $count = $h->buslogin($username, $password, "admin");
            if ($count != 0) {
                $_SESSION["busname"] = $username;
                $_SESSION["stype"] = $stype;
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Login Successfully!",
                    "message" => "welcome admin!!",
                    "action" => "dashboard.php",
                ];
            } else {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "false",
                    "title" => "Please Use Valid Data!!",
                    "message" => "Invalid Data!!",
                    "action" => "index.php",
                ];
            }
        } else {
            $h = new Crud($bus);

            $count = $h->buslogin($username, $password, "tbl_bus_operator");
            if ($count != 0) {
                $_SESSION["busname"] = $username;
                $_SESSION["stype"] = $stype;
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Login Successfully!",
                    "message" => "welcome Bus Operator!!",
                    "action" => "dashboard.php",
                ];
            } else {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "false",
                    "title" => "Please Use Valid Data!!",
                    "message" => "Invalid Data!!",
                    "action" => "index.php",
                ];
            }
        }
    } else if($_POST['type'] == 'add_payout')
{
	$operator_id = $sdata["id"];
	$amt = $_POST['amt'];
	$r_type = $_POST['r_type'];
	$acc_number = $_POST['acc_number'];
	$bank_name = $_POST['bank_name'];
	$acc_name = $_POST['acc_name'];
	$ifsc_code = $_POST['ifsc_code'];
	$upi_id = $_POST['upi_id'];
	$paypal_id = $_POST['paypal_id'];
	
	$total_earn = $bus->query("select sum((subtotal -(cou_amt+commission)) - ((subtotal -cou_amt) * ope_commission/100)) as total_amt from tbl_book where operator_id=".$sdata["id"]." and book_status ='Completed'")->fetch_assoc();
	$earn =   empty($total_earn['total_amt']) ? 0 : number_format((float)($total_earn['total_amt']), 2, '.', '');
	
	$total_payout = $bus->query("select sum(amt) as total_payout from bus_payout_setting where operator_id=".$sdata["id"]."")->fetch_assoc();
							  $payout =  empty($total_payout['total_payout']) ? 0 : number_format((float)($total_payout['total_payout']), 2, '.', '');
	
	$bs = 0;
				
				
				 if($earn == 0){}else {$bs = number_format((float)($earn)- $payout, 2, '.', ''); }
				 
				 if(floatval($amt) > floatval($set['operator_limit']))
				 {
					$returnArr = array("ResponseCode"=>"401","Result"=>"false","title"=>"You can't Payout Above Your Payout Limit!","message"=>"Payout Problem!!","action"=>"add_payout.php"); 
					
				 }
				 else if(floatval($amt) > floatval($bs))
				 {
					  
					 $returnArr = array("ResponseCode"=>"401","Result"=>"false","title"=>"You can't Payout Above Your Earning!".$bs,"message"=>"Payout Problem!!","action"=>"add_payout.php"); 
				 }
				 else 
				 {
					 $timestamp = date("Y-m-d H:i:s");
					 $table="bus_payout_setting";
  $field_values=array("operator_id","amt","status","r_date","r_type","acc_number","bank_name","acc_name","ifsc_code","upi_id","paypal_id");
  $data_values=array("$operator_id","$amt","pending","$timestamp","$r_type","$acc_number","$bank_name","$acc_name","$ifsc_code","$upi_id","$paypal_id");
  
      $h = new Crud($bus);
	  $check = $h->businsertdata_Api($field_values,$data_values,$table);
	  $returnArr = array("ResponseCode"=>"200","Result"=>"true","title"=>"Payout Request Submit Successfully!!","message"=>"Payout Submitted!!","action"=>"add_payout.php");
				 }
											   
}elseif ($_POST["type"] == "op_com_payout") {
        $payout_id = $_POST["payout_id"];
        $target_dir = dirname(dirname(__FILE__)) . "/images/payout/";
        $url = "images/payout/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
            $table = "bus_payout_setting";
            $field = ["proof" => $url, "status" => "completed"];
            $where = "where id=" . $payout_id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData($field, $table, $where);

            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Payout Update Successfully!!",
                    "message" => "Payout section!",
                    "action" => "op_payout.php",
                ];
            } 
        
    }elseif ($_POST["type"] == "add_code") {
        $okey = $_POST["status"];
        $title = $bus->real_escape_string($_POST["title"]);

        $table = "tbl_code";
        $field_values = ["ccode", "status"];
        $data_values = ["$title", "$okey"];

        $h = new Crud($bus);
        $check = $h->businsertdata($field_values, $data_values, $table);
        if ($check == 1) {
            $returnArr = [
                "ResponseCode" => "200",
                "Result" => "true",
                "title" => "Country Code Add Successfully!!",
                "message" => "Country Code section!",
                "action" => "list_code.php",
            ];
        } 
    } elseif ($_POST['type'] == "edit_bus") {
        $title = $bus->real_escape_string($_POST['title']);
        $bno = $bus->real_escape_string($_POST['bno']);
        $tick_price = $bus->real_escape_string($_POST['tick_price']);
        $driver_direction = $bus->real_escape_string($_POST['driver_direction']);
        $decker = $_POST['decker'];
		$operator_id = $sdata['id'];
		$driver_name = $_POST['driver_name'];
		$driver_mobile = $_POST['driver_mobile'];
        $bstatus = $_POST['bstatus'];
        $rate = $_POST['rate'];
        $totl_seat = $_POST['totl_seat'];
        $seat_limit = $_POST['seat_limit'];
        $bac = $_POST['bac'];
        $is_sleeper = $_POST['is_sleeper'];
        $facilitylist = empty($_POST['facilitylist']) ? "" : implode(',', $_POST['facilitylist']);
		$offday = empty($_POST['offday']) ? "" : implode(',', $_POST['offday']);
		
        $id = $_POST["id"];
        if ($_FILES["bus_img"]["name"] != '') {
            $target_dir = dirname(dirname(__FILE__)) . "/images/bus/";
            $url = "images/bus/";
            $temp = explode(".", $_FILES["bus_img"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            $target_file = $target_dir . basename($newfilename);
            $url = $url . basename($newfilename);
           
                if ($decker == 1) {
                    $rows = $_POST['rows'];
                    $columns = $_POST['columns'];

                    // Initialize a variable to store the seat data
                    $seatData = "";
                    $berth_type = 'LOWER';
                    // Loop through the submitted data and process it
                    for ($i = 0; $i < $rows; $i++) {
                        for ($j = 0; $j < $columns; $j++) {
                            $seatData .= $_POST['lower_' . $i . '_' . $j] . ',';
                        }
                        $seatData .= $berth_type . '$;';
                    }

                    // Remove trailing "$;" if it exists
                    if (substr($seatData, -2) === '$;') {
                        $seatData = substr($seatData, 0, -2);
                    }

                    $elements = explode("$;", $seatData); // Split the string into elements

                    $digitCount = 0; // Initialize the count for digits

                    foreach ($elements as $element) {
                        // Split each element into subparts
                        $parts = explode(",", $element);
                        foreach ($parts as $part) {
                            // Check if the part is numeric and doesn't contain letters, or if it's greater than 9
                            if (!empty($part) && $part != "LOWER" && $part != "UPPER") {
                                $digitCount++;
                            }
                        }
                    }
                    if ($digitCount == $totl_seat) {
                        move_uploaded_file($_FILES["bus_img"]["tmp_name"], $target_file);
                        $table = "tbl_bus";
                        $field = [
                            'bus_img' => $url,
                            'title' => $title,
                            'bno' => $bno,
                            'bstatus' => $bstatus,
                            'tick_price' => $tick_price,
                            'driver_direction' => $driver_direction,
                            'decker' => $decker,
                            'lower_row' => $rows,
                            'lower_column' => $columns,
                            'upper_row' => "4",
                            'upper_column' => "4",
                            'rate' => $rate,
                            'totl_seat' => $totl_seat,
                            'seat_limit' => $seat_limit,
                            'bac' => $bac,
                            'is_sleeper' => $is_sleeper,
                            'seat_layout' => $seatData,
                            'bus_facility' => $facilitylist,
							'offday'=>$offday,
							'driver_mobile'=>$driver_mobile,
							'driver_name'=>$driver_name,
							'operator_id'=>$operator_id
                        ];
                        $where = "where id=" . $id . "";
                        $h = new Crud($bus);
                        $check = $h->busupdateData($field, $table, $where);
                        $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Bus Update Successfully", "message" => "Bus section!", "action" => "list_bus.php"];
                    } else {
                        $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Total Seat With Added Seat Total Not Matched Check Proper!!", "message" => "Bus section!", "action" => "add_bus.php?id=" . $id . ""];
                    }
                } else {
                    $rows = $_POST['rows'];
                    $columns = $_POST['columns'];

                    $rowss = $_POST['rowss'];
                    $columnss = $_POST['columnss'];

                    // Initialize a variable to store the seat data
                    $seatData = "";
                    $seatDatas = "";
                    $berth_type = 'LOWER';
                    $berth_types = 'UPPER';
                    // Loop through the submitted data and process it
                    for ($i = 0; $i < $rows; $i++) {
                        for ($j = 0; $j < $columns; $j++) {
                            $seatData .= $_POST['lower_' . $i . '_' . $j] . ',';
                        }
                        $seatData .= $berth_type . '$;';
                    }

                    for ($p = 0; $p < $rowss; $p++) {
                        for ($r = 0; $r < $columnss; $r++) {
                            $seatDatas .= $_POST['upper_' . $p . '_' . $r] . ',';
                        }
                        $seatDatas .= $berth_types . '$;';
                    }

                    // Remove trailing "$;" if it exists
                    if (substr($seatData, -2) === '$;') {
                        $seatData = substr($seatData, 0, -2);
                    }
                    if (substr($seatDatas, -2) === '$;') {
                        $seatDatas = substr($seatDatas, 0, -2);
                    }
                    $mergedSeatData = $seatData . '$;' . $seatDatas;

                    $elements = explode("$;", $mergedSeatData); // Split the string into elements

                    $digitCount = 0; // Initialize the count for digits

                    foreach ($elements as $element) {
                        // Split each element into subparts
                        $parts = explode(",", $element);
                        foreach ($parts as $part) {
                            // Check if the part is numeric and doesn't contain letters, or if it's greater than 9
                            if (!empty($part) && $part != "LOWER" && $part != "UPPER") {
                                $digitCount++;
                            }
                        }
                    }

                    if ($digitCount == $totl_seat) {
                        move_uploaded_file($_FILES["bus_img"]["tmp_name"], $target_file);
                        $table = "tbl_bus";
                        $field = [
                            'bus_img' => $url,
                            'title' => $title,
                            'bno' => $bno,
                            'bstatus' => $bstatus,
                            'tick_price' => $tick_price,
                            'driver_direction' => $driver_direction,
                            'decker' => $decker,
                            'lower_row' => $rows,
                            'lower_column' => $columns,
                            'upper_row' => $rowss,
                            'upper_column' => $columnss,
                            'rate' => $rate,
                            'totl_seat' => $totl_seat,
                            'seat_limit' => $seat_limit,
                            'bac' => $bac,
                            'is_sleeper' => $is_sleeper,
                            'seat_layout' => $mergedSeatData,
                            'bus_facility' => $facilitylist,
							'offday'=>$offday,
							'driver_mobile'=>$driver_mobile,
							'driver_name'=>$driver_name,
							'operator_id'=>$operator_id
                        ];
                        $where = "where id=" . $id . "";
                        $h = new Crud($bus);
                        $check = $h->busupdateData($field, $table, $where);
                        $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Bus Update Successfully", "message" => "Bus section!", "action" => "list_bus.php"];
                    } else {
                        $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Total Seat With Added Seat Total Not Matched Check Proper!!", "message" => "Bus section!", "action" => "add_bus.php?id=" . $id . ""];
                    }
                }
            
        } else {
            if ($decker == 1) {
                $rows = $_POST['rows'];
                $columns = $_POST['columns'];

                // Initialize a variable to store the seat data
                $seatData = "";
                $berth_type = 'LOWER';
                // Loop through the submitted data and process it
                for ($i = 0; $i < $rows; $i++) {
                    for ($j = 0; $j < $columns; $j++) {
                        $seatData .= $_POST['lower_' . $i . '_' . $j] . ',';
                    }
                    $seatData .= $berth_type . '$;';
                }

                // Remove trailing "$;" if it exists
                if (substr($seatData, -2) === '$;') {
                    $seatData = substr($seatData, 0, -2);
                }

                $elements = explode("$;", $seatData); // Split the string into elements

                $digitCount = 0; // Initialize the count for digits

                foreach ($elements as $element) {
                    // Split each element into subparts
                    $parts = explode(",", $element);
                    foreach ($parts as $part) {
                        // Check if the part is numeric and doesn't contain letters, or if it's greater than 9
                        if (!empty($part) && $part != "LOWER" && $part != "UPPER") {
                            $digitCount++;
                        }
                    }
                }
                if ($digitCount == $totl_seat) {
                    $table = "tbl_bus";
                    $field = [
                        'title' => $title,
                        'bno' => $bno,
                        'bstatus' => $bstatus,
                        'tick_price' => $tick_price,
                        'driver_direction' => $driver_direction,
                        'decker' => $decker,
                        'lower_row' => $rows,
                        'lower_column' => $columns,
                        'upper_row' => "4",
                        'upper_column' => "4",
                        'rate' => $rate,
                        'totl_seat' => $totl_seat,
                        'seat_limit' => $seat_limit,
                        'bac' => $bac,
                        'is_sleeper' => $is_sleeper,
                        'seat_layout' => $seatData,
                        'bus_facility' => $facilitylist,
						'offday'=>$offday,
						'driver_mobile'=>$driver_mobile,
						'driver_name'=>$driver_name,
						'operator_id'=>$operator_id
                    ];
                    $where = "where id=" . $id . "";
                    $h = new Crud($bus);
                    $check = $h->busupdateData($field, $table, $where);
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Bus Update Successfully", "message" => "Bus section!", "action" => "list_bus.php"];
                } else {
                    $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Total Seat With Added Seat Total Not Matched Check Proper!!", "message" => "Bus section!", "action" => "add_bus.php?id=" . $id . ""];
                }
            } else {
                $rows = $_POST['rows'];
                $columns = $_POST['columns'];

                $rowss = $_POST['rowss'];
                $columnss = $_POST['columnss'];

                // Initialize a variable to store the seat data
                $seatData = "";
                $seatDatas = "";
                $berth_type = 'LOWER';
                $berth_types = 'UPPER';
                // Loop through the submitted data and process it
                for ($i = 0; $i < $rows; $i++) {
                    for ($j = 0; $j < $columns; $j++) {
                        $seatData .= $_POST['lower_' . $i . '_' . $j] . ',';
                    }
                    $seatData .= $berth_type . '$;';
                }

                for ($p = 0; $p < $rowss; $p++) {
                    for ($r = 0; $r < $columnss; $r++) {
                        $seatDatas .= $_POST['upper_' . $p . '_' . $r] . ',';
                    }
                    $seatDatas .= $berth_types . '$;';
                }

                // Remove trailing "$;" if it exists
                if (substr($seatData, -2) === '$;') {
                    $seatData = substr($seatData, 0, -2);
                }
                if (substr($seatDatas, -2) === '$;') {
                    $seatDatas = substr($seatDatas, 0, -2);
                }
                $mergedSeatData = $seatData . '$;' . $seatDatas;

                $elements = explode("$;", $mergedSeatData); // Split the string into elements

                $digitCount = 0; // Initialize the count for digits

                foreach ($elements as $element) {
                    // Split each element into subparts
                    $parts = explode(",", $element);
                    foreach ($parts as $part) {
                        // Check if the part is numeric and doesn't contain letters, or if it's greater than 9
                        if (!empty($part) && $part != "LOWER" && $part != "UPPER") {
                            $digitCount++;
                        }
                    }
                }

                if ($digitCount == $totl_seat) {
                    $table = "tbl_bus";
                    $field = [
                        'title' => $title,
                        'bno' => $bno,
                        'bstatus' => $bstatus,
                        'tick_price' => $tick_price,
                        'driver_direction' => $driver_direction,
                        'decker' => $decker,
                        'lower_row' => $rows,
                        'lower_column' => $columns,
                        'upper_row' => $rowss,
                        'upper_column' => $columnss,
                        'rate' => $rate,
                        'totl_seat' => $totl_seat,
                        'seat_limit' => $seat_limit,
                        'bac' => $bac,
                        'is_sleeper' => $is_sleeper,
                        'seat_layout' => $mergedSeatData,
                        'bus_facility' => $facilitylist,
						'offday'=>$offday,
						'driver_mobile'=>$driver_mobile,
						'driver_name'=>$driver_name,
						'operator_id'=>$operator_id
                    ];
                    $where = "where id=" . $id . "";
                    $h = new Crud($bus);
                    $check = $h->busupdateData($field, $table, $where);
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Bus Update Successfully", "message" => "Bus section!", "action" => "list_bus.php"];
                } else {
                    $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Total Seat With Added Seat Total Not Matched Check Proper!!", "message" => "Bus section!", "action" => "add_bus.php?id=" . $id . ""];
                }
            }
        }
	}
	elseif ($_POST["type"] == "add_coupon") {
        $expire_date = $_POST["expire_date"];
        $operator_id = $sdata["id"];
        $status = $_POST["status"];
        $coupon_code = $_POST["coupon_code"];
        $min_amt = $_POST["min_amt"];
        $coupon_val = $_POST["coupon_val"];
        $description = $bus->real_escape_string($_POST["description"]);
        $title = $bus->real_escape_string($_POST["title"]);
        $subtitle = $bus->real_escape_string($_POST["subtitle"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/coupon/";
        $url = "images/coupon/";
        $temp = explode(".", $_FILES["coupon_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["coupon_img"]["tmp_name"], $target_file);
            $table = "tbl_coupon";
            $field_values = [
                "expire_date",
                "status",
                "title",
                "coupon_code",
                "min_amt",
                "coupon_val",
                "description",
                "subtitle",
                "coupon_img",
				"operator_id"
            ];
            $data_values = [
                "$expire_date",
                "$status",
                "$title",
                "$coupon_code",
                "$min_amt",
                "$coupon_val",
                "$description",
                "$subtitle",
                "$url",
				"$operator_id"
            ];

            $h = new Crud($bus);
            $check = $h->businsertdata($field_values, $data_values, $table);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Coupon Add Successfully!!",
                    "message" => "Coupon section!",
                    "action" => "list_coupon.php",
                ];
            } 
        
    } elseif ($_POST["type"] == "edit_coupon") {
        $expire_date = $_POST["expire_date"];
        $operator_id = $sdata["id"];
        $id = $_POST["id"];
        $status = $_POST["status"];
        $coupon_code = $_POST["coupon_code"];
        $min_amt = $_POST["min_amt"];
        $coupon_val = $_POST["coupon_val"];
        $description = $bus->real_escape_string($_POST["description"]);
        $title = $bus->real_escape_string($_POST["title"]);
        $subtitle = $bus->real_escape_string($_POST["subtitle"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/coupon/";
        $url = "images/coupon/";
        $temp = explode(".", $_FILES["coupon_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["coupon_img"]["name"] != "") {
            
                move_uploaded_file(
                    $_FILES["coupon_img"]["tmp_name"],
                    $target_file
                );
                $table = "tbl_coupon";
                $field = [
                    "status" => $status,
                    "coupon_img" => $url,
                    "title" => $title,
                    "coupon_code" => $coupon_code,
                    "min_amt" => $min_amt,
                    "coupon_val" => $coupon_val,
                    "description" => $description,
                    "subtitle" => $subtitle,
                    "expire_date" => $expire_date,
					"operator_id"=>$operator_id
                ];
                $where =
                    "where id=" . $id . "";
                $h = new Crud($bus);
                $check = $h->busupdateData($field, $table, $where);

                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Coupon Update Successfully!!",
                        "message" => "Coupon section!",
                        "action" => "list_coupon.php",
                    ];
                } 
            
        } else {
            $table = "tbl_coupon";
            $field = [
                "status" => $status,
                "title" => $title,
                "coupon_code" => $coupon_code,
                "min_amt" => $min_amt,
                "coupon_val" => $coupon_val,
                "description" => $description,
                "subtitle" => $subtitle,
                "expire_date" => $expire_date,
				"operator_id"=>$operator_id
            ];
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData($field, $table, $where);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Coupon Update Successfully!!",
                    "message" => "Coupon section!",
                    "action" => "list_coupon.php",
                ];
            } 
        }
    }
	elseif ($_POST['type'] == "edit_bus_operator") {
		
		$bus_name = $bus->real_escape_string($_POST['title']);
		$status = $_POST['status'];
		$rate = $_POST['rate'];
		$id = $_POST['id'];
		$agent_commission = $_POST['agent_commission'];
		$admin_commission = $_POST['admin_commission'];
		$email = $bus->real_escape_string($_POST['email']);
		$password = $bus->real_escape_string($_POST['password']);
		$address = $bus->real_escape_string($_POST['address']);
		$lats = $_POST['lats'];
		$longs = $_POST['longs'];
		$bank_name = $_POST['bank_name'];
		$ifsc_code = $_POST['ifsc_code'];
		$receipt_name = $_POST['receipt_name'];
		$acc_no = $_POST['acc_no'];
		$pay_id = $_POST['pay_id'];
		$upi_id = $_POST['upi_id'];
		$target_dir = dirname(dirname(__FILE__)) . "/images/busoperator/";
		$url = "images/busoperator/";
        $temp = explode(".", $_FILES["op_img"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
		
		if($_FILES["op_img"]["name"] != "")
		{
			
                move_uploaded_file(
                    $_FILES["op_img"]["tmp_name"],
                    $target_file
                );
				
				$table = "tbl_bus_operator";
                $field = [
                    "bus_name" => $bus_name,
                    "op_img" => $url,
                    "status" => $status,
                    "rate" => $rate,
                    "agent_commission" => $agent_commission,
                    "admin_commission" => $admin_commission,
                    "email" => $email,
                    "password" => $password,
                    "address" => $address,
					"lats" => $lats,
					"longs" => $longs,
					"bank_name" => $bank_name,
					"ifsc_code" => $ifsc_code,
					"receipt_name" => $receipt_name,
					"acc_no" => $acc_no,
					"pay_id" => $pay_id,
					"upi_id" => $upi_id,
                ];
                $where =
                    "where id=" . $id . "";
                $h = new Crud($bus);
                $check = $h->busupdateData($field, $table, $where);

                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Bus Operator Update Successfully!!",
                        "message" => "Bus Operator section!",
                        "action" => "list_bus_operator.php",
                    ];
                } 
				
			
		}
		else 
		{
			$table = "tbl_bus_operator";
                $field = [
                    "bus_name" => $bus_name,
                    "status" => $status,
                    "rate" => $rate,
                    "agent_commission" => $agent_commission,
                    "admin_commission" => $admin_commission,
                    "email" => $email,
                    "password" => $password,
                    "address" => $address,
					"lats" => $lats,
					"longs" => $longs,
					"bank_name" => $bank_name,
					"ifsc_code" => $ifsc_code,
					"receipt_name" => $receipt_name,
					"acc_no" => $acc_no,
					"pay_id" => $pay_id,
					"upi_id" => $upi_id,
                ];
                $where =
                    "where id=" . $id . "";
                $h = new Crud($bus);
                $check = $h->busupdateData($field, $table, $where);

                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Bus Operator Update Successfully!!",
                        "message" => "Bus Operator section!",
                        "action" => "list_bus_operator.php",
                    ];
                } 
		}
		
		
	}
	elseif ($_POST['type'] == "add_bus_operator") {
		$bus_name = $bus->real_escape_string($_POST['title']);
		$status = $_POST['status'];
		$rate = $_POST['rate'];
		$agent_commission = $_POST['agent_commission'];
		$admin_commission = $_POST['admin_commission'];
		$email = $bus->real_escape_string($_POST['email']);
		$password = $bus->real_escape_string($_POST['password']);
		$address = $bus->real_escape_string($_POST['address']);
		$lats = $_POST['lats'];
		$longs = $_POST['longs'];
		$bank_name = $_POST['bank_name'];
		$ifsc_code = $_POST['ifsc_code'];
		$receipt_name = $_POST['receipt_name'];
		$acc_no = $_POST['acc_no'];
		$pay_id = $_POST['pay_id'];
		$upi_id = $_POST['upi_id'];
		$target_dir = dirname(dirname(__FILE__)) . "/images/busoperator/";
		$url = "images/busoperator/";
        $temp = explode(".", $_FILES["op_img"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
     
		
		move_uploaded_file($_FILES["op_img"]["tmp_name"], $target_file);
                    $table = "tbl_bus_operator";
                    $field_values = [
                        "bus_name",
                        "op_img",
                        "status",
                        "rate",
                        "agent_commission",
                        "admin_commission",
                        "email",
                        "password",
                        "address",
                        "lats",
                        "longs",
                        "bank_name",
                        "ifsc_code",
                        "receipt_name",
                        "acc_no",
                        "pay_id",
                        "upi_id"
                    ];
                    $data_values = [
                        "$bus_name",
                        "$url",
                        "$status",
                        "$rate",
                        "$agent_commission",
                        "$admin_commission",
                        "$email",
                        "$password",
                        "$address",
                        "$lats",
                        "$longs",
                        "$bank_name",
                        "$ifsc_code",
                        "$receipt_name",
                        "$acc_no",
                        "$pay_id",
                        "$upi_id"
                    ];

                    $h = new Crud($bus);
                    $check = $h->businsertdata($field_values, $data_values, $table);
					 if ($check == 1) {
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Bus Operator Add Successfully", "message" => "Bus section!", "action" => "add_bus_operator.php"];
                } 
				
		
		
	}
     elseif ($_POST['type'] == "add_bus") {
        $title = $bus->real_escape_string($_POST['title']);
        $bno = $bus->real_escape_string($_POST['bno']);
        $tick_price = $bus->real_escape_string($_POST['tick_price']);
        $driver_direction = $bus->real_escape_string($_POST['driver_direction']);
        $decker = $_POST['decker'];
		$operator_id = $sdata['id'];
		$driver_id = $_POST['driver_id'];
        $bstatus = $_POST['bstatus'];
        $rate = $_POST['rate'];
        $totl_seat = $_POST['totl_seat'];
        $seat_limit = $_POST['seat_limit'];
        $bac = $_POST['bac'];
        $is_sleeper = $_POST['is_sleeper'];
        $facilitylist = empty($_POST['facilitylist']) ? "" : implode(',', $_POST['facilitylist']);
		$offday = empty($_POST['offday']) ? "" : implode(',', $_POST['offday']);
        $target_dir = dirname(dirname(__FILE__)) . "/images/bus/";
        $url = "images/bus/";
        $temp = explode(".", $_FILES["bus_img"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            if ($decker == 1) {
                $rows = $_POST['rows'];
                $columns = $_POST['columns'];

                // Initialize a variable to store the seat data
                $seatData = "";
                $berth_type = 'LOWER';
                // Loop through the submitted data and process it
                for ($i = 0; $i < $rows; $i++) {
                    for ($j = 0; $j < $columns; $j++) {
                        $seatData .= $_POST['lower_' . $i . '_' . $j] . ',';
                    }
                    $seatData .= $berth_type . '$;';
                }

                // Remove trailing "$;" if it exists
                if (substr($seatData, -2) === '$;') {
                    $seatData = substr($seatData, 0, -2);
                }

                $elements = explode("$;", $seatData); // Split the string into elements

                $digitCount = 0; // Initialize the count for digits

                foreach ($elements as $element) {
                    // Split each element into subparts
                    $parts = explode(",", $element);
                    foreach ($parts as $part) {
                        // Check if the part is numeric and doesn't contain letters, or if it's greater than 9
                        if (!empty($part) && $part != "LOWER" && $part != "UPPER") {
                            $digitCount++;
                        }
                    }
                }
                if ($digitCount == $totl_seat) {
                    move_uploaded_file($_FILES["bus_img"]["tmp_name"], $target_file);
                    $table = "tbl_bus";
                    $field_values = [
                        "bus_img",
                        "title",
                        "bno",
                        "tick_price",
                        "driver_direction",
                        "decker",
                        "lower_row",
                        "lower_column",
                        "upper_row",
                        "upper_column",
                        "bstatus",
                        "rate",
                        "totl_seat",
                        "seat_limit",
                        "bac",
                        "is_sleeper",
                        "seat_layout",
                        "bus_facility",
						"offday",
						"driver_id",
						"operator_id"
                    ];
                    $data_values = [
                        "$url",
                        "$title",
                        "$bno",
                        "$tick_price",
                        "$driver_direction",
                        "$decker",
                        "$rows",
                        "$columns",
                        "4",
                        "4",
                        "$bstatus",
                        "$rate",
                        "$totl_seat",
                        "$seat_limit",
                        "$bac",
                        "$is_sleeper",
                        "$seatData",
                        "$facilitylist",
						"$offday",
						"$driver_id",
						"$operator_id"
                    ];

                    $h = new Crud($bus);
                    $check = $h->businsertdata($field_values, $data_values, $table);
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Bus Add Successfully", "message" => "Bus section!", "action" => "add_bus.php"];
                } else {
                    $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Total Seat With Added Seat Total Not Matched Check Proper!!".$rows."--".$columns, "message" => "Bus section!", "action" => false];
                }
            } else {
                $rows = $_POST['rows'];
                $columns = $_POST['columns'];

                $rowss = $_POST['rowss'];
                $columnss = $_POST['columnss'];

                // Initialize a variable to store the seat data
                $seatData = "";
                $seatDatas = "";
                $berth_type = 'LOWER';
                $berth_types = 'UPPER';
                // Loop through the submitted data and process it
                for ($i = 0; $i < $rows; $i++) {
                    for ($j = 0; $j < $columns; $j++) {
                        $seatData .= $_POST['lower_' . $i . '_' . $j] . ',';
                    }
                    $seatData .= $berth_type . '$;';
                }

                for ($p = 0; $p < $rowss; $p++) {
                    for ($r = 0; $r < $columnss; $r++) {
                        $seatDatas .= $_POST['upper_' . $p . '_' . $r] . ',';
                    }
                    $seatDatas .= $berth_types . '$;';
                }

                // Remove trailing "$;" if it exists
                if (substr($seatData, -2) === '$;') {
                    $seatData = substr($seatData, 0, -2);
                }
                if (substr($seatDatas, -2) === '$;') {
                    $seatDatas = substr($seatDatas, 0, -2);
                }
                $mergedSeatData = $seatData . '$;' . $seatDatas;

                $elements = explode("$;", $mergedSeatData); // Split the string into elements

                $digitCount = 0; // Initialize the count for digits

                foreach ($elements as $element) {
                    // Split each element into subparts
                    $parts = explode(",", $element);
                    foreach ($parts as $part) {
                        // Check if the part is numeric and doesn't contain letters, or if it's greater than 9
                        if (!empty($part) && $part != "LOWER" && $part != "UPPER") {
                            $digitCount++;
                        }
                    }
                }

                if ($digitCount == $totl_seat) {
                    move_uploaded_file($_FILES["bus_img"]["tmp_name"], $target_file);
                    $table = "tbl_bus";
                    $field_values = [
                        "bus_img",
                        "title",
                        "bno",
                        "tick_price",
                        "driver_direction",
                        "decker",
                        "lower_row",
                        "lower_column",
                        "upper_row",
                        "upper_column",
                        "bstatus",
                        "rate",
                        "totl_seat",
                        "seat_limit",
                        "bac",
                        "is_sleeper",
                        "seat_layout",
                        "bus_facility",
						"offday",
						"driver_name",
						"driver_mobile",
						"operator_id"
                    ];
                    $data_values = [
                        "$url",
                        "$title",
                        "$bno",
                        "$tick_price",
                        "$driver_direction",
                        "$decker",
                        "$rows",
                        "$columns",
                        "$rowss",
                        "$columnss",
                        "$bstatus",
                        "$rate",
                        "$totl_seat",
                        "$seat_limit",
                        "$bac",
                        "$is_sleeper",
                        "$mergedSeatData",
                        "$facilitylist",
						"$offday",
						"$driver_name",
						"$driver_mobile",
						"$operator_id"
                    ];

                    $h = new Crud($bus);
                    $check = $h->businsertdata($field_values, $data_values, $table);
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Bus Add Successfully", "message" => "Bus section!", "action" => "add_bus.php"];
                } else {
                    $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Total Seat With Added Seat Total Not Matched Check Proper!!", "message" => "Bus section!", "action" => "add_bus.php"];
                }
            }
        
    } elseif ($_POST['type'] == 'edit_code') {
        $okey = $_POST['status'];
        $title = $bus->real_escape_string($_POST['title']);
        $id = $_POST['id'];
        $table = "tbl_code";
        $field = ['status' => $okey, 'ccode' => $title];
        $where = "where id=" . $id . "";
        $h = new Crud($bus);
        $check = $h->busupdateData($field, $table, $where);
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Country Code Update Successfully!!", "message" => "Country Code section!", "action" => "list_code.php"];
        } 
    } elseif ($_POST['type'] == 'add_page') {
        $ctitle = $bus->real_escape_string($_POST['ctitle']);
        $cstatus = $_POST['cstatus'];
        $cdesc = $bus->real_escape_string($_POST['cdesc']);
        $table = "tbl_page";

        $field_values = ["description", "status", "title"];
        $data_values = ["$cdesc", "$cstatus", "$ctitle"];

        $h = new Crud($bus);
        $check = $h->businsertdata($field_values, $data_values, $table);
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Page Add Successfully!!", "message" => "Page section!", "action" => "list_page.php"];
        } 
    } elseif ($_POST['type'] == 'edit_page') {
        $id = $_POST['id'];
        $ctitle = $bus->real_escape_string($_POST['ctitle']);
        $cstatus = $_POST['cstatus'];
        $cdesc = $bus->real_escape_string($_POST['cdesc']);

        $table = "tbl_page";
        $field = ['description' => $cdesc, 'status' => $cstatus, 'title' => $ctitle];
        $where = "where id=" . $id . "";
        $h = new Crud($bus);
        $check = $h->busupdateData($field, $table, $where);
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Page Update Successfully!!", "message" => "Page section!", "action" => "list_page.php"];
        } 
    } elseif ($_POST['type'] == 'edit_payment') {
        $attributes = mysqli_real_escape_string($bus, $_POST['p_attr']);
        $ptitle = mysqli_real_escape_string($bus, $_POST['ptitle']);
        $okey = $_POST['status'];
        $id = $_POST['id'];
        $p_show = $_POST['p_show'];
        $target_dir = dirname(dirname(__FILE__)) . "/images/payment/";
        $url = "images/payment/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != '') {
            
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "tbl_payment_list";
                $field = ['status' => $okey, 'img' => $url, 'attributes' => $attributes, 'subtitle' => $ptitle, 'p_show' => $p_show];
                $where = "where id=" . $id . "";
                $h = new Crud($bus);
                $check = $h->busupdateData($field, $table, $where);

                if ($check == 1) {
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Payment Gateway Update Successfully!!", "message" => "Payment Gateway section!", "action" => "paymentlist.php"];
                } 
            
        } else {
            $table = "tbl_payment_list";
            $field = ['status' => $okey, 'attributes' => $attributes, 'subtitle' => $ptitle, 'p_show' => $p_show];
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData($field, $table, $where);
            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Payment Gateway Update Successfully!!", "message" => "Payment Gateway section!", "action" => "paymentlist.php"];
            } 
        }
    } elseif ($_POST['type'] == 'add_faq') {
        $question = mysqli_real_escape_string($bus, $_POST['question']);
        $answer = mysqli_real_escape_string($bus, $_POST['answer']);
        $okey = $_POST['status'];

        $table = "tbl_faq";
        $field_values = ["question", "answer", "status"];
        $data_values = ["$question", "$answer", "$okey"];

        $h = new Crud($bus);
        $check = $h->businsertdata($field_values, $data_values, $table);
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Faq Add Successfully!!", "message" => "Faq section!", "action" => "list_faq.php"];
        } 
    }elseif ($_POST['type'] == 'add_policy') {
        $hour = mysqli_real_escape_string($bus, $_POST['hour']);
        $rmat = mysqli_real_escape_string($bus, $_POST['rmat']);
        $okey = $_POST['status'];

        $table = "tbl_policy";
        $field_values = ["hour", "rmat"];
        $data_values = ["$hour", "$rmat"];

        $h = new Crud($bus);
        $check = $h->businsertdata($field_values, $data_values, $table);
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Cancellation Policy Add Successfully!!", "message" => "Policy section!", "action" => "list_policy.php"];
        } 
    }elseif ($_POST['type'] == 'edit_policy') {
        $hour = mysqli_real_escape_string($bus, $_POST['hour']);
        $rmat = mysqli_real_escape_string($bus, $_POST['rmat']);
        $okey = $_POST['status'];
        $id = $_POST['id'];

        $table = "tbl_policy";
        $field = ['hour' => $hour, 'rmat' => $rmat];
        $where = "where id=" . $id . "";
        $h = new Crud($bus);
        $check = $h->busupdateData($field, $table, $where);
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Cancellation Policy Update Successfully!!", "message" => "Policy section!", "action" => "list_policy.php"];
        } 
    } elseif ($_POST['type'] == 'edit_faq') {
        $question = mysqli_real_escape_string($bus, $_POST['question']);
        $answer = mysqli_real_escape_string($bus, $_POST['answer']);
        $okey = $_POST['status'];
        $id = $_POST['id'];

        $table = "tbl_faq";
        $field = ['question' => $question, 'status' => $okey, 'answer' => $answer];
        $where = "where id=" . $id . "";
        $h = new Crud($bus);
        $check = $h->busupdateData($field, $table, $where);
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Faq Update Successfully!!", "message" => "Faq section!", "action" => "list_faq.php"];
        } 
    }  elseif ($_POST['type'] == 'edit_profile') {
        
            $dname = $_POST['username'];
            $dsname = $_POST['password'];
            $id = $_POST['id'];
            $table = "admin";
            $field = ['username' => $dname, 'password' => $dsname];
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData($field, $table, $where);
            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Profile Update Successfully!!", "message" => "Profile  section!", "action" => "profile.php"];
            } 
        
    }  elseif ($_POST['type'] == 'edit_setting') {
        $webname = mysqli_real_escape_string($bus, $_POST['webname']);
        $timezone = $_POST['timezone'];
        $currency = $_POST['currency'];
        $id = $_POST['id'];
        $tax = $_POST['tax'];
        $agent_limit = $_POST['agent_limit'];
        $one_key = $_POST['one_key'];
        $one_hash = $_POST['one_hash'];
        $agent_status = $_POST['agent_status'];
        $scredit = $_POST['scredit'];
        $rcredit = $_POST['rcredit'];

        $target_dir = dirname(dirname(__FILE__)) . "/images/website/";
        $url = "images/website/";
        $temp = explode(".", $_FILES["weblogo"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["weblogo"]["name"] != '') {
            
                move_uploaded_file($_FILES["weblogo"]["tmp_name"], $target_file);
                $table = "tbl_setting";
                $field = ['timezone' => $timezone,'agent_limit'=>$agent_limit,'agent_status'=>$agent_status, 'weblogo' => $url, 'webname' => $webname, 'currency' => $currency, 'one_key' => $one_key, 'one_hash' => $one_hash, 'scredit' => $scredit, 'rcredit' => $rcredit,'tax'=>$tax];
                $where = "where id=" . $id . "";
                $h = new Crud($bus);
                $check = $h->busupdateData($field, $table, $where);

                if ($check == 1) {
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Setting Update Successfully!!", "message" => "Setting section!", "action" => "setting.php"];
                } 
            
        } else {
            $table = "tbl_setting";
            $field = ['timezone' => $timezone,'agent_limit'=>$agent_limit,'agent_status'=>$agent_status, 'webname' => $webname, 'currency' => $currency, 'one_key' => $one_key, 'one_hash' => $one_hash, 'scredit' => $scredit, 'rcredit' => $rcredit,'tax'=>$tax];
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData($field, $table, $where);
            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Setting Update Successfully!!", "message" => "Offer section!", "action" => "setting.php"];
            } 
        }
    } elseif ($_POST["type"] == "add_city") {
        $okey = $_POST["status"];
        $title = $bus->real_escape_string($_POST["title"]);
        
        
            
            $table = "tbl_city";
            $field_values = [ "status", "title"];
            $data_values = [ "$okey", "$title"];

            $h = new Crud($bus);
            $check = $h->businsertdata($field_values, $data_values, $table);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "City Add Successfully!!",
                    "message" => "City section!",
                    "action" => "list_city.php",
                ];
            } 
        
    } elseif ($_POST["type"] == "add_banner") {
        $okey = $_POST["status"];

        $target_dir = dirname(dirname(__FILE__)) . "/images/banner/";
        $url = "images/banner/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
            $table = "tbl_banner";
            $field_values = ["img", "status"];
            $data_values = ["$url", "$okey"];

            $h = new Crud($bus);
            $check = $h->businsertdata($field_values, $data_values, $table);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Banner Add Successfully!!",
                    "message" => "Banner section!",
                    "action" => "list_banner.php",
                ];
            } 
        
    }elseif ($_POST["type"] == "add_facility") {
        $okey = $_POST["status"];
        $title = $bus->real_escape_string($_POST["title"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/facility/";
        $url = "images/facility/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
       
            move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
            $table = "tbl_facility";
            $field_values = ["img", "status", "title"];
            $data_values = ["$url", "$okey", "$title"];

            $h = new Crud($bus);
            $check = $h->businsertdata($field_values, $data_values, $table);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Facility Add Successfully!!",
                    "message" => "Facility section!",
                    "action" => "list_facility.php",
                ];
            } 
        
    } elseif ($_POST["type"] == "faq_delete") {
        $id = $_POST["id"];
        $table = "tbl_faq";
        $where = "where id=" . $id . "";
        $h = new Crud($bus);
        $check = $h->busDeleteData($where, $table);
        if ($check == 1) {
            $returnArr = [
                "ResponseCode" => "200",
                "Result" => "true",
                "title" => "FAQ Delete Successfully!!",
                "message" => "FAQ section!",
                "action" => "list_faq.php",
            ];
        } 
    } elseif ($_POST["type"] == "add_subroute") {
		$operator_id = $sdata['id'];
        $board_id = $_POST['board_id'];
        $rpoint = $_POST['rpoint'];
        $btime = $_POST['btime'];
        $status = $_POST['status'];
        // Check for duplicate values in the rpoint array
        $duplicateValues = array_diff_assoc($rpoint, array_unique($rpoint));

        if (!empty($duplicateValues)) {
            // Duplicates found, return a JSON response
            $returnArr = [
                "ResponseCode" => "200",
                "Result" => "false",
                "title" => "Duplicate values in the Sub Route Point.",
                "message" => "Duplicate values in the Sub Route Point.",
                "action" => "add_pick_time.php",
            ];
        } else {
            $check = $bus->query("select * from tbl_sub_route_time where board_id=" . $board_id . "")->num_rows;
            if ($check != 0) {
                $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Alredy Inserted Please Update Data!!", "message" => "Operation Duplicate DISABLED!!", "action" => "add_pick_time.php"];
            } else {
                // Loop through the boarding points and times
                for ($i = 0; $i < count($rpoint); $i++) {
                    $point_id = $rpoint[$i];
                    $ptime = $btime[$i];
                    $statuss = $status[$i];

                    // Insert each point and time into the database
                    $table = "tbl_sub_route_time";
                    $field_values = ["board_id", "point_id", "ptime", "status","operator_id"];
                    $data_values = ["$board_id", "$point_id", "$ptime", "$statuss","$operator_id"];

                    $h = new Crud($bus);
                    $check = $h->businsertdata($field_values, $data_values, $table);
                }

                if ($check == 1) {
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Pick up Sub Route Add Successfully!!", "message" => "Pick up Sub Route section!", "action" => "add_pick_time.php"];
                } 
            }
        }
    } elseif ($_POST["type"] == "add_drop_subroute") {
        $board_id = $_POST['board_id'];
        $rpoint = $_POST['rpoint'];
		$operator_id = $sdata['id'];
        $btime = $_POST['btime'];
        $status = $_POST['status'];
        // Check for duplicate values in the rpoint array
        $duplicateValues = array_diff_assoc($rpoint, array_unique($rpoint));

        if (!empty($duplicateValues)) {
            // Duplicates found, return a JSON response
            $returnArr = [
                "ResponseCode" => "200",
                "Result" => "false",
                "title" => "Duplicate values in the Sub Route Point.",
                "message" => "Duplicate values in the Sub Route Point.",
                "action" => "add_drop_time.php",
            ];
        } else {
            $check = $bus->query("select * from tbl_drop_sub_route where board_id=" . $board_id . "")->num_rows;
            if ($check != 0) {
                $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Alredy Inserted Please Update Data!!", "message" => "Operation Duplicate DISABLED!!", "action" => "add_drop_time.php"];
            } else {
                // Loop through the boarding points and times
                for ($i = 0; $i < count($rpoint); $i++) {
                    $point_id = $rpoint[$i];
                    $ptime = $btime[$i];
                    $statuss = $status[$i];

                    // Insert each point and time into the database
                    $table = "tbl_drop_sub_route";
                    $field_values = ["board_id", "point_id", "ptime", "status", "operator_id"];
                    $data_values = ["$board_id", "$point_id", "$ptime", "$statuss", "$operator_id"];

                    $h = new Crud($bus);
                    $check = $h->businsertdata($field_values, $data_values, $table);
                }

                if ($check == 1) {
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Drop Sub Route Add Successfully!!", "message" => "Drop Sub Route section!", "action" => "add_drop_time.php"];
                } 
            }
        }
    } elseif ($_POST["type"] == "add_bdpoints") {
        $bus_id = $_POST['bus_id'];
		$operator_id = $sdata['id'];
        $check = $bus->query("select * from tbl_board_drop_points where bus_id=" . $bus_id . "")->num_rows;
        if ($check != 0) {
            $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Alredy Inserted Please Update Data!!", "message" => "Operation Duplicate DISABLED!!", "action" => "add_board_drop.php"];
        } else {
            $boarding_points = $_POST['bpoint'];
            $boarding_times = $_POST['btime'];
            $dropping_points = $_POST['dpoint'];
            $dropping_times = $_POST['dtime'];
			$differncetimes = $_POST['differncetime'];

            // Loop through the boarding points and times
            for ($i = 0; $i < count($boarding_points); $i++) {
                $boarding_point = $boarding_points[$i];
                $boarding_time = $boarding_times[$i];
                $dropping_point = $dropping_points[$i];
                $dropping_time = $dropping_times[$i];
                $differncetime = $differncetimes[$i];
                // Insert each point and time into the database
                $table = "tbl_board_drop_points";
                $field_values = ["bus_id", "bpoint", "btime", "dpoint", "dtime","differncetime","operator_id"];
                $data_values = ["$bus_id", "$boarding_point", "$boarding_time", "$dropping_point", "$dropping_time","$differncetime","$operator_id"];

                $h = new Crud($bus);
                $check = $h->businsertdata($field_values, $data_values, $table);
            }

            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Points Add Successfully!!", "message" => "Points section!", "action" => "add_board_drop.php"];
            } 
        }
    } elseif ($_POST["type"] == "edit_bdpoints") {
        $bus_id = $_POST['hidden_bus_id'];
        $id = $_POST['id'];
		$operator_id = $sdata['id'];
        $exist_boarding_points = $_POST['exist_bpoint'];
        $exist_boarding_times = $_POST['exist_btime'];
        $exist_dropping_points = $_POST['exist_dpoint'];
        $exist_dropping_times = $_POST['exist_dtime'];
		$exist_differncetimes = $_POST['exist_differncetime'];

        for ($i = 0; $i < count($exist_boarding_points); $i++) {
            $boarding_point = $exist_boarding_points[$i];
            $boarding_time = $exist_boarding_times[$i];
            $dropping_point = $exist_dropping_points[$i];
            $dropping_time = $exist_dropping_times[$i];
			$differncetime = $exist_differncetimes[$i];
            $idv = $id[$i];
            $table = "tbl_board_drop_points";
            $field = ['bpoint' => $boarding_point, 'btime' => $boarding_time, 'dpoint' => $dropping_point, 'dtime' => $dropping_time,'differncetime'=>$differncetime,'operator_id'=>$operator_id];
            $where = "where id=" . $idv . "";
            $h = new Crud($bus);
            $check = $h->busupdateData($field, $table, $where);
        }

        $new_boarding_points = $_POST['new_bpoint'];
        $new_boarding_times = $_POST['new_btime'];
        $new_dropping_points = $_POST['new_dpoint'];
        $new_dropping_times = $_POST['new_dtime'];
        $new_differncetimes = $_POST['new_differncetime'];
        if (is_array($new_boarding_points) && is_array($new_boarding_times) && is_array($new_dropping_points) && is_array($new_dropping_times)) {
            $count = count($new_boarding_points);

            for ($i = 0; $i < $count; $i++) {
                $boarding_point = $new_boarding_points[$i];
                $boarding_time = $new_boarding_times[$i];
                $dropping_point = $new_dropping_points[$i];
                $dropping_time = $new_dropping_times[$i];
				$differncetime = $new_differncetimes[$i];

                // Insert each point and time into the database
                $table = "tbl_board_drop_points";
                $field_values = ["bus_id", "bpoint", "btime", "dpoint", "dtime","differncetime","operator_id"];
                $data_values = ["$bus_id", "$boarding_point", "$boarding_time", "$dropping_point","$dropping_time", "$differncetime","$operator_id"];

                $h = new Crud($bus);
                $checks = $h->businsertdata($field_values, $data_values, $table);
            }
        }

        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Points Update Successfully!!", "message" => "Points section!", "action" => "list_board_drop.php"];
        } 
    } elseif ($_POST["type"] == "add_points") {
        $title = mysqli_real_escape_string($bus, $_POST['title']);
        $city_id = mysqli_real_escape_string($bus, $_POST['city_id']);
        $status = $_POST['status'];
        $address = mysqli_real_escape_string($bus, $_POST['address']);
        $mobile = mysqli_real_escape_string($bus, $_POST['mobile']);
        $lats = mysqli_real_escape_string($bus, $_POST['lats']);
        $longs = mysqli_real_escape_string($bus, $_POST['longs']);

        $table = "tbl_points";
        $field_values = ["title", "city_id", "status", "address", "mobile","lats","longs"];
        $data_values = ["$title", "$city_id", "$status", "$address", "$mobile","$lats","$longs"];

        $h = new Crud($bus);
        $check = $h->businsertdata($field_values, $data_values, $table);
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Points Add Successfully!!", "message" => "Points section!", "action" => "list_drop_pick.php"];
        } 
    } elseif ($_POST['type'] == 'edit_subroute') {
        $board_id = $_POST['hidden_boarding_id'];
        $id = $_POST['id'];
		$operator_id = $sdata['id'];
        $exist_rpoint = $_POST['exist_rpoint'];
        $exist_btime = $_POST['exist_btime'];
        $exist_status = $_POST['exist_status'];
        $new_rpoint = $_POST['new_rpoint'];
        $new_btime = $_POST['new_btime'];
        $new_status = $_POST['new_status'];
        function hasDuplicates($array)
        {
            return count($array) !== count(array_unique($array));
        }

        if (!empty($new_rpoint)) {
            // Combine both arrays into a single array
            $combinedRPoint = array_merge($exist_rpoint, $new_rpoint);
        } else {
            // If $new_rpoint is empty or null, just use $exist_rpoint
            $combinedRPoint = $exist_rpoint;
        }

        // Check for duplicates in the combined array
        $duplicateCombinedRPoint = hasDuplicates($combinedRPoint);

        if ($duplicateCombinedRPoint) {
            // Return a JSON response indicating that duplicates are not allowed
            $returnArr = [
                "ResponseCode" => "200", // You can use an appropriate HTTP status code
                "Result" => "false",
                "title" => "Duplicate values are not allowed for Sub Route Points.",
                "action" => "list_pick_time.php",
            ];
        } else {
            for ($i = 0; $i < count($exist_rpoint); $i++) {
                $exist_rpoints = $exist_rpoint[$i];
                $exist_btimes = $exist_btime[$i];
                $exist_statuss = $exist_status[$i];
                $idv = $id[$i];
                $table = "tbl_sub_route_time";
                $field = ['point_id' => $exist_rpoints, 'ptime' => $exist_btimes, 'status' => $exist_statuss,'operator_id'=>$operator_id];
                $where = "where id=" . $idv . "";
                $h = new Crud($bus);
                $check = $h->busupdateData($field, $table, $where);
            }

            if (is_array($new_rpoint) && is_array($new_btime) && is_array($new_status)) {
                $count = count($new_rpoint);

                for ($i = 0; $i < $count; $i++) {
                    $new_rpoints = $new_rpoint[$i];
                    $new_btimes = $new_btime[$i];
                    $new_statuss = $new_status[$i];

                    // Insert each point and time into the database
                    $table = "tbl_sub_route_time";
                    $field_values = ["board_id", "point_id", "ptime", "status","operator_id"];
                    $data_values = ["$board_id", "$new_rpoints", "$new_btimes", "$new_statuss","$operator_id"];

                    $h = new Crud($bus);
                    $checks = $h->businsertdata($field_values, $data_values, $table);
                }
            }

            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Sub route Pick up Update Successfully!!", "message" => "Sub route Pick up section!", "action" => "list_pick_time.php"];
            } 
        }
    } elseif ($_POST['type'] == 'edit_drop_subroute') {
        $board_id = $_POST['hidden_boarding_id'];
        $id = $_POST['id'];
		$operator_id = $sdata['id'];
        $exist_rpoint = $_POST['exist_rpoint'];
        $exist_btime = $_POST['exist_btime'];
        $exist_status = $_POST['exist_status'];
        $new_rpoint = $_POST['new_rpoint'];
        $new_btime = $_POST['new_btime'];
        $new_status = $_POST['new_status'];
        function hasDuplicates($array)
        {
            return count($array) !== count(array_unique($array));
        }

        if (!empty($new_rpoint)) {
            // Combine both arrays into a single array
            $combinedRPoint = array_merge($exist_rpoint, $new_rpoint);
        } else {
            // If $new_rpoint is empty or null, just use $exist_rpoint
            $combinedRPoint = $exist_rpoint;
        }

        // Check for duplicates in the combined array
        $duplicateCombinedRPoint = hasDuplicates($combinedRPoint);

        if ($duplicateCombinedRPoint) {
            // Return a JSON response indicating that duplicates are not allowed
            $returnArr = [
                "ResponseCode" => "200", // You can use an appropriate HTTP status code
                "Result" => "false",
                "title" => "Duplicate values are not allowed for Sub Route Points.",
                "action" => "list_drop_time.php",
            ];
        } else {
            for ($i = 0; $i < count($exist_rpoint); $i++) {
                $exist_rpoints = $exist_rpoint[$i];
                $exist_btimes = $exist_btime[$i];
                $exist_statuss = $exist_status[$i];
                $idv = $id[$i];
                $table = "tbl_drop_sub_route";
                $field = ['point_id' => $exist_rpoints, 'ptime' => $exist_btimes, 'status' => $exist_statuss, 'operator_id'=>$operator_id];
                $where = "where id=" . $idv . "";
                $h = new Crud($bus);
                $check = $h->busupdateData($field, $table, $where);
            }

            if (is_array($new_rpoint) && is_array($new_btime) && is_array($new_status)) {
                $count = count($new_rpoint);

                for ($i = 0; $i < $count; $i++) {
                    $new_rpoints = $new_rpoint[$i];
                    $new_btimes = $new_btime[$i];
                    $new_statuss = $new_status[$i];

                    // Insert each point and time into the database
                    $table = "tbl_drop_sub_route";
                    $field_values = ["board_id", "point_id", "ptime", "status","operator_id"];
                    $data_values = ["$board_id", "$new_rpoints", "$new_btimes", "$new_statuss", "$operator_id"];

                    $h = new Crud($bus);
                    $checks = $h->businsertdata($field_values, $data_values, $table);
                }
            }

            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Sub route Drop Update Successfully!!", "message" => "Sub route Drop section!", "action" => "list_drop_time.php"];
            } 
        }
    } elseif ($_POST['type'] == 'edit_points') {
        $title = mysqli_real_escape_string($bus, $_POST['title']);
        $city_id = mysqli_real_escape_string($bus, $_POST['city_id']);
        $status = $_POST['status'];
        $id = $_POST['id'];
        $address = mysqli_real_escape_string($bus, $_POST['address']);
        $mobile = mysqli_real_escape_string($bus, $_POST['mobile']);
        $lats = mysqli_real_escape_string($bus, $_POST['lats']);
        $longs = mysqli_real_escape_string($bus, $_POST['longs']);

        $table = "tbl_points";
        $field = ['city_id' => $city_id, 'status' => $status, 'title' => $title, 'address' => $address, 'mobile' => $mobile, 'lats' => $lats, 'longs' => $longs];
        $where = "where id=" . $id . "";
        $h = new Crud($bus);
        $check = $h->busupdateData($field, $table, $where);
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Points Update Successfully!!", "message" => "Points section!", "action" => "list_drop_pick.php"];
        } 
    } elseif ($_POST["type"] == "edit_city") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
        $title = $bus->real_escape_string($_POST["title"]);
        
            $table = "tbl_city";
            $field = ["status" => $okey, "title" => $title];
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData($field, $table, $where);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "City Update Successfully!!",
                    "message" => "City section!",
                    "action" => "list_city.php",
                ];
            } 
        
    } elseif ($_POST["type"] == "edit_banner") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
        $target_dir = dirname(dirname(__FILE__)) . "/images/banner/";
        $url = "images/banner/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != "") {
           
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "tbl_banner";
                $field = ["status" => $okey, "img" => $url];
                $where = "where id=" . $id . "";
                $h = new Crud($bus);
                $check = $h->busupdateData($field, $table, $where);

                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Banner Update Successfully!!",
                        "message" => "Banner section!",
                        "action" => "list_banner.php",
                    ];
                } 
            
        } else {
            $table = "tbl_banner";
            $field = ["status" => $okey];
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData($field, $table, $where);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Banner Update Successfully!!",
                    "message" => "Banner section!",
                    "action" => "list_banner.php",
                ];
            } 
        }
    } elseif ($_POST["type"] == "edit_facility") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
        $title = $bus->real_escape_string($_POST["title"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/facility/";
        $url = "images/facility/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != "") {
            
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "tbl_facility";
                $field = ["status" => $okey, "img" => $url, "title" => $title];
                $where = "where id=" . $id . "";
                $h = new Crud($bus);
                $check = $h->busupdateData($field, $table, $where);

                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Facility Update Successfully!!",
                        "message" => "Facility section!",
                        "action" => "list_facility.php",
                    ];
                } 
            
        } else {
            $table = "tbl_facility";
            $field = ["status" => $okey, "title" => $title];
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData($field, $table, $where);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Facility Update Successfully!!",
                    "message" => "Facility section!",
                    "action" => "list_facility.php",
                ];
            } 
        }
    }elseif ($_POST["type"] == "com_payout") {
        $payout_id = $_POST["payout_id"];
        $target_dir = dirname(dirname(__FILE__)) . "/images/proof/";
        $url = "images/proof/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
            $table = "payout_setting";
            $field = ["proof" => $url, "status" => "completed"];
            $where = "where id=" . $payout_id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData($field, $table, $where);

            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Payout Update Successfully!!",
                    "message" => "Payout section!",
                    "action" => "list_payout.php",
                ];
            } 
        
    }  elseif ($_POST["type"] == "point_delete") {
        $id = $_POST["id"];
        $table = "tbl_board_drop_points";
        $where = "where id=" . $id . "";
        $h = new Crud($bus);
        $check = $h->busDeleteData($where, $table);
        if ($check == 1) {
            $returnArr = [
                "ResponseCode" => "200",
                "Result" => "true",
                "title" => "Point Delete Successfully!!",
                "message" => "Point section!",
                "action" => "list_board_drop.php",
            ];
        } 
    } elseif ($_POST["type"] == "sub_pick_route_delete") {
        $id = $_POST["id"];
        $table = "tbl_sub_route_time";
        $where = "where id=" . $id . "";
        $h = new Crud($bus);
        $check = $h->busDeleteData($where, $table);
        if ($check == 1) {
            $returnArr = [
                "ResponseCode" => "200",
                "Result" => "true",
                "title" => "Sub route Delete Successfully!!",
                "message" => "Sub route section!",
                "action" => "list_pick_time.php",
            ];
        } 
    } elseif ($_POST["type"] == "sub_drop_route_delete") {
        $id = $_POST["id"];
        $table = "tbl_drop_sub_route";
        $where = "where id=" . $id . "";
        $h = new Crud($bus);
        $check = $h->busDeleteData($where, $table);
        if ($check == 1) {
            $returnArr = [
                "ResponseCode" => "200",
                "Result" => "true",
                "title" => "Sub route Delete Successfully!!",
                "message" => "Sub route section!",
                "action" => "list_drop_time.php",
            ];
        } 
    }	elseif ($_POST["type"] == "update_status") {
        $id = $_POST["id"];
        $status = $_POST["status"];
        $coll_type = $_POST["coll_type"];
        $page_name = $_POST["page_name"];
         if ($coll_type == "userstatus") {
            $table = "tbl_user";
            $field = "status=" . $status . "";
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData_single($field, $table, $where);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "User Status Change Successfully!!",
                    "message" => "User section!",
                    "action" => "userlist.php",
                ];
            } 
        } else if ($coll_type == "verifystatus") {
            $table = "tbl_user";
            $field = "is_verify=" . $status . "";
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData_single($field, $table, $where);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Agent Verify Status Change Successfully!!",
                    "message" => "User section!",
                    "action" => "userlist.php",
                ];
            } 
        } elseif ($coll_type == "dark_mode") {
		
            $table = "tbl_setting";
            $field = "show_dark=" . $status . "";
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData_single($field, $table, $where);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Dark Mode Status Change Successfully!!",
                    "message" => "Dark Mode section!",
                    "action" => $page_name,
                ];
            } 
	
        }
		elseif ($coll_type == "sdark_mode") {
		
            $table = "tbl_bus_operator";
            $field = "dark_mode=" . $status . "";
            $where = "where id=" . $id . "";
            $h = new Crud($bus);
            $check = $h->busupdateData_single($field, $table, $where);
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Dark Mode Status Change Successfully!!",
                    "message" => "Dark Mode section!",
                    "action" => $page_name,
                ];
            } 
	
        }
		

		else {
            $returnArr = [
                "ResponseCode" => "200",
                "Result" => "false",
                "title" => "Option Not There!!",
                "message" => "Error!!",
                "action" => "dashboard.php",
            ];
        }
    } else {
        $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Don't Try Extra Function!", "message" => "welcome admin!!", "action" => "dashboard.php"];
    }
} else {
    $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Don't Try Extra Function!", "message" => "welcome admin!!", "action" => "dashboard.php"];
}
echo json_encode($returnArr);
?>
