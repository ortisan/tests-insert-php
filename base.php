<?php
function getConnection() {
	$database_host = "localhost";
	$database_user = "root";
	$database_password = "xpto123";
	$database_name = "test";
	
	$link = mysql_connect ( $database_host, $database_user, $database_password, true );
	
	if (! $link) {
		die ( 'Impossible connect: ' . mysql_error () );
	}
	
	mysql_select_db ( $database_name, $link );
	return $link;
}
function closeConnection($conn) {
	mysql_close ( $conn );
}

?>