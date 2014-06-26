<?php
include 'base.php';

// THIS FUNCTION IS SOURCE FROM: http://stackoverflow.com/questions/7766978/geo-location-based-on-ip-address-php
function geoCheckIP($ip) {
	if (! filter_var ( $ip, FILTER_VALIDATE_IP )) {
		throw new InvalidArgumentException ( "IP is not valid" );
	}
	
	$response = @file_get_contents ( 'http://www.netip.de/search?query=' . $ip );
	if (empty ( $response )) {
		throw new InvalidArgumentException ( "Error contacting Geo-IP-Server" );
	}
	
	$patterns = array ();
	$patterns ["domain"] = '#Domain: (.*?)&nbsp;#i';
	$patterns ["country"] = '#Country: (.*?)&nbsp;#i';
	$patterns ["state"] = '#State/Region: (.*?)<br#i';
	$patterns ["town"] = '#City: (.*?)<br#i';
	
	$ipInfo = array ();
	
	foreach ( $patterns as $key => $pattern ) {
		$ipInfo [$key] = preg_match ( $pattern, $response, $value ) && ! empty ( $value [1] ) ? $value [1] : 'not found';
	}
	
	return $ipInfo;
}
function getIpFromClient() {
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
	// descomentar quando estiver remoto
	// $ip = getIpFromClient();
	// comentar quando estiver remoto
	$ip = '200.221.2.45';
	$geoInfoArray = geoCheckIP ( $ip );
	
	$country = $geoInfoArray ['country'];
	$region = $geoInfoArray ['state'];
	$city = $geoInfoArray ['town'];
	
	$link = getConnection ();
	
	mysql_select_db ( $database_name );
	
	mysql_query ( "INSERT INTO TB_USERSS_REGION (COUNTRY, REGION, CITY) VALUES ('$country', '$region', '$city');", $link );
	
	echo "Id:" . mysql_insert_id ( $link ) . "<br>";
	
	closeConnection ( $link );
}

for($i = 0; $i < 1000; $i ++) {
	TesteBatista ();
}

?>

