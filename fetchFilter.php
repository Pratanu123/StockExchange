<?php
require 'configs/dbConfig.php';

$db = new dbConfig();
$dbconn = $db->getConnection();
if (!empty($_POST['datepickerFrom']) && !empty($_POST['datepickerTo']) && !empty($_POST['company'])) {
    $datefrom=date("Y-m-d",strtotime($_POST['datepickerFrom']));
    $dateto=date("Y-m-d",strtotime($_POST['datepickerTo']));
    $name=$_POST['company'];
    $sql = "SELECT *  FROM stock where date between '".$datefrom."' and '".$dateto."' and name='".$name."'";
    $maxSql= "SELECT MAX(price) as max  FROM stock where date between '".$datefrom."' and '".$dateto."' and name='".$name."'";
    $minSql= "SELECT MIN(price) as min  FROM stock where date between '".$datefrom."' and '".$dateto."' and name='".$name."'";
    $result = $dbconn->query($sql);
    $max=$dbconn->query($maxSql)->fetch();
    $min=$dbconn->query($minSql)->fetch();
    while ($row = $result->fetch()) 
    {
        $price=0;
        if($row['price']==$max['max']){
            $price=$row['price']. " (Prefered Sell)";
        }
        else if($row['price']==$min['min']){
            $price=$row['price']. " (Prefered Buy)";
        }
        else{
            $price=$row['price'];
        }
        $data[] = array(
            'stock_id'  => $row['id'],
            'stock_date'  => $row['date'],
            'stock_name'  => $row['name'],
            'stock_price'  => $price
        );
    }
    echo json_encode($data);
}

?>