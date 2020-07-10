<?php
    if ( isset($_POST["submit"]) ) {

    if ( isset($_FILES["file"])) {

            //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "No file selected <br />";
        }
        else {
            header('Location: data.html');//to show the datatable
                //Print file details
            echo "Upload: " . $_FILES["file"]["name"] . "<br />";
           // echo "Type: " . $_FILES["file"]["type"] . "<br />";
            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
           // echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                //if file already exists
            if (file_exists("upload/" . $_FILES["file"]["name"])) {
            echo $_FILES["file"]["name"] . " already exists. ";
            }
            else {
                    //Store file in directory "upload" with the name of "uploaded_file.txt"
            $storagename = "uploaded_file.csv";
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);
            echo "Stored in: " . "upload/" . $storagename . "<br />";
            $storagename= "upload/" . $storagename;
            }
        }
    } else {
            echo "No file selected <br />";
    }
    }
    jj_readcsv($storagename,$header=true);

    function jj_readcsv($filename, $header=false) {
        $handle = fopen($filename, "r");
        echo '<table>';
        //display header row if true
        if ($header) {
            $csvcontents = fgetcsv($handle);
            echo '<tr>';
            foreach ($csvcontents as $headercolumn) {
                echo "<th>$headercolumn</th>";
            }
            echo '</tr>';
        }
        // displaying contents
        while ($csvcontents = fgetcsv($handle)) {
            echo '<tr>';
            foreach ($csvcontents as $column) {
                echo "<td>$column</td>";
            }
            echo '</tr>';
        }
        echo '</table>';
        fclose($handle);
    }
?>