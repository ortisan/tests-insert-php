<?php
error_reporting ( E_ALL );
include 'base.php';
function checarDados() {
	$handle = @fopen ( "C:/temp/TestesGeracaoID.jtl", "r" );
	
	$conn = getConnection ();
	
	if ($handle) {
		while ( ($buffer = fgets ( $handle, 4096 )) !== false ) {
			
			preg_match ( "/resId(\d+).+newId1:(\d+).+newId2:(\d+)/", $buffer, $matches );
			$resId = $matches [1];
			$id1 = $matches [2];
			$id2 = $matches [3];
			
			$query = "SELECT ID_RESOURCE FROM TB_USUARIOS WHERE ID = $id1;";
			$result = mysql_query ( $query, $conn );
			$row = mysql_fetch_assoc ( $result );
			$idBase = $row ["ID_RESOURCE"];
			
			echo $id1 . " -- " . ($idBase == $resId ? 'true' : 'false') . " <br/> ";
			
			$query = "SELECT ID_RESOURCE FROM TB_USUARIOS WHERE ID = $id2;";
			$result = mysql_query ( $query, $conn );
			
			$idBase = $row ["ID_RESOURCE"];
			
			echo $id2 . " -- " . ($idBase == $resId ? 'true' : 'false') . " <br/> ";
		}
		
		if (! feof ( $handle )) {
			echo "Error: unexpected fgets() fail\n";
		}
		
		fclose ( $handle );
	}
	
	closeConnection ( $conn );
}

checarDados ();

?>

