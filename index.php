<?php
error_reporting ( E_USER_ERROR );

include 'base.php';
function getIp() {
	if (! empty ( $_SERVER ['HTTP_CLIENT_IP'] )) {
		$ip = $_SERVER ['HTTP_CLIENT_IP'];
	} elseif (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
		$ip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER ['REMOTE_ADDR'];
	}
	return $ip;
}
function TesteBatista() {
	
	// if (isset ( $_COOKIE ['id_client'] )) {
	// echo "Know user. <br>";
	// } else {
	// echo "Unknow user . <br>";
	$link = getConnection ();
	
	$idThread = mysql_thread_id ( $link );
	
	if (! $link) {
		die ( "Impossible to connect: " . mysql_error () );
	}
	
	echo "resId" . $idThread . "\t\t";
	
	mysql_select_db ( $database_name );
	
	$ip = getIp ();
	
	$id = mysql_insert_id ( $link );
	
	echo "oldId:" . $id . "\t\t";
	
	mysql_query ( "INSERT INTO TB_USERSS (ID_RESOURCE) VALUES ('$idThread');", $link );
	
	$id = mysql_insert_id ( $link );
	
	echo "newId1:" . $id . "\t\t";
	
	mysql_query ( "INSERT INTO TB_USERSS (ID_RESOURCE) VALUES ('$idThread');", $link );
	
	$id = mysql_insert_id ( $link );
	
	echo "newId2:" . $id . "\t\t";
	
	// setcookie ( 'id_client', $id, time () + (86400 * 7) );
	
	closeConnection ( $link );
	
	$link = getConnection ();
	
	$id = mysql_insert_id ( $link );
	
	echo "endId:" . $id;
	
	closeConnection ( $link );
	// }
}

TesteBatista ();

?>





