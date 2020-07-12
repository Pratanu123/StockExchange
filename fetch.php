<?php 
require 'configs/dbConfig.php';

$db=new dbConfig();
$dbconn=$db->getConnection();

$sql = "SELECT *  FROM stock";
$result = $dbconn->query($sql);

while ($row = $result->fetch()) 
{
    $data[] = array(
        'stock_id'  => $row['id'],
        'stock_date'  => $row['date'],
        'stock_name'  => $row['name'],
        'stock_price'  => $row['price']
    );
}

echo json_encode($data);
?>