<?php
    
    $username = "forqa_dev";
    $password = "82N[nw,p!hXA4)\\j^.%/z6u*";
    $database = "forqa_dev";
    
	//mysql_connect('localhost',$username,$password);
	//@mysql_select_db($database) or die("Error");
	
	$mysqli = new mysqli("localhost", $username, $password, $database);

    $user_id = $_GET["user_id"];
    $token = $_GET["token"];

    $query = "INSERT INTO `tbl_user_device_token` (`user_id`, `device_token`, `device_os`) VALUES ('$user_id', '$token', 'ios') "." ON DUPLICATE KEY UPDATE `device_token` = '$token';";

$result = $mysqli->query($query) or die($mysqli->error);
$num = $mysqli->affected_rows;
//$result = mysql_query($query) or die(mysql_error());
//$num = mysql_num_rows($result);


$response = array();
if($num == 0) {
	$response = array('status'=>0, 'message'=>"Registration Failed", 'data'=>array());
}
else {
    $query2 = "SELECT `tbl_user_device_token`.* FROM `tbl_user_device_token`
            WHERE `tbl_user_device_token`.`user_id` = '$user_id' AND `tbl_user_device_token`.`device_token` = '$token'";
    $result2 = $mysqli->query($query2) or die($mysqli->error);
	$rows = array();
	while ($r = $result2->fetch_assoc())
	{
		$rows[] = $r;
	}
	
    $mysqli->close();
	$response = array('status'=>1, 'message'=>"Registration Successful", 'data'=>$rows);
}

echo json_encode($response);

?>