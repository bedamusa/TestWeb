<?php
session_start();
//if(!defined('muweb') or !muweb) die();
//include 'includes/functions.php';
include 'includes/ConfigMe.php';
	$ip = $_SERVER["REMOTE_ADDR"];
	$time = date('Y-m-d H:i:s');
	$username = ($_POST['username']);
    $password = ($_POST['password']);
	$regex = "#^[a-zA-Z0-9_-]+$#";
	$regusername = (preg_match($regex, $username));
	$regpassword = (preg_match($regex, $password));
$response = NULL;
if (!empty($username) && !empty($password)) {
	if (empty($username) || empty($password)) {
            $code = 'error';
            $message = 'Some fields contain forbidden characters.';
			
    }
	
	else if ( $regusername === 0 || $regpassword === 0) {
		$code = 'error';
        $message = 'Some fields contain forbidden characters.';
		
	}
	
	else if (strlen($username) <= 3 || strlen($password) <= 3) {
		$code =  'error';
        $message = 'Username and password length must be more than 4';
		
	}
	
	else {
		$stmt = "SELECT memb___id, memb__pwd FROM MEMB_INFO WHERE memb___id= ? and memb__pwd= ? ";
		$params = array($username, $password);
		$query = sqlsrv_query( $conn, $stmt, $params);
		$result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
		
		//$lastTry  = date_create('1988-08-10');
		//$diff  	= date_diff( $lastTry, $time );
		if (is_array($result)){
			//if ($diff->i < 15 ) {
			if ($test == 'ok' ) {
				$code = 'error';
				$message = 'You have exceeded the login attempts limit. You can try again after 15';
			}
			$code = 'error';
            $message = 'You have logged in successfully.';
		}
		else {
			$code = 'error';
            //$message = 'Invalid login details. Login attempts 1 of 10.';
            $message = 'else';
		}
		
		
	}
	
}
else {
        $code =  'error';
        $message = 'Some fields were left blank.';
}
$response = array("code" => $code, "message" => $message);
echo json_encode($response);

?>