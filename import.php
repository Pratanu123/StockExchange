
<?php
require 'configs/dbConfig.php';

$db = new dbConfig();

$dbconn = $db->getConnection();
if (!empty($_FILES['csv_file']['name'])) {
    $file_data = fopen($_FILES['csv_file']['name'], 'r');
    fgetcsv($file_data);
    while ($row = fgetcsv($file_data)) {
        $data[] = array(
            'stock_id'  => $row[0],
            'stock_date'  => $row[1],
            'stock_name'  => $row[2],
            'stock_price'  => $row[3]
        );
        $date=date("Y-m-d",strtotime($row[1]));
        $import = $dbconn->exec("INSERT into  stock (id,date,name,price)  values('$row[0]','$date','$row[2]','$row[3]')");
    }
    echo json_encode($data);
}

?>