<?php 
require 'configs/dbConfig.php';

$db=new dbConfig();
$dbconn=$db->getConnection();

$sql = "DELETE from stock";
$result = $dbconn->query($sql);
echo json_encode("Success");
?>