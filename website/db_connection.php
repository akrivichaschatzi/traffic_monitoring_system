<?php

function db_open() {
	$dtbhost="localhost";
	$dtbsocket="/zstorage/home/ictest00760/mysql/run/mysql.sock";
	$dtbuser="root";
	$dtbpass="akrivi123$#";
	$dtbname="traffic_monitoring_system";
	$db = new mysqli("$dtbhost", "$dtbuser", "$dtbpass", "$dtbname", 0, $dtbsocket );
	if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
	}
	mysqli_query($db, "SET CHARACTER SET utf8");
	mysqli_query($db, "SET NAMES utf8");
	return $db;
}

function CloseCon($conn){
	 $conn -> close();
}

?>
