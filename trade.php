<?php
require 'configs/dbConfig.php';
$db = new dbConfig();
$dbconn = $db->getConnection();
$sql = "Select distinct name from stock";
$result = $dbconn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Joe Stock Exchange</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="https://cdn.syncfusion.com/ej2/dist/ej2.min.js"></script>
    <link href="https://cdn.syncfusion.com/ej2/material.css" rel="stylesheet">


</head>

<body>
    <div class="container">
        <br />
        <h2 align="center">Joe Stock Exchange</h2>
        <br />
        <br />
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="about.php">JSE</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href="#">Trading</a></li>
                </ul>
            </div>
        </nav>
        <div class="jumbtron" style="text-align: center;">
            <h3>Lets Trade</h3>
            <br />
            <br />
            <form class="form-inline " id="filterdata">
                <div class="form-group">
                    <input id="datepickerFrom" type="text" placeholder="From Date">
                </div>
                <div class="form-group">
                    <input id="datepickerTo" type="text" placeholder="To Date">
                </div>
                <div class="form-group">
                    <select id="company" name="company" class="form-control form -control-lg">
                        <option value="0" selected="selected">Select Company</option>
                        <?php
                        if (!empty($result)) {
                            while ($row = $result->fetch()) {
                                echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                            }
                        }
                        ?>
                    </select>

                </div>
                <button type="submit" class="btn btn-success">Apply</button>
            </form>
        </div>
        <br />
        <br />

        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="data-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th>Stock ID</th>
                        <th>Stock Date</th>
                        <th>Stock Name</th>
                        <th>Stock Price</th>
                    </tr>
                </thead>
            </table>
        </div>
        <br />
        <br />
        <div class="jumbtron" name="jumbo" id="jumbo" style="text-align: center; display:none">
            <button class="btn btn-success" onclick="getSelected()">Buy</button>
            <button type="submit" class="btn btn-success">Sell</button>
            <br />
        </div>

    </div>


</html>
<script>
    var datepicker1 = new ej.calendars.DatePicker({
        width: "255px"
    });
    datepicker1.appendTo('#datepickerFrom');
    var datepicker2 = new ej.calendars.DatePicker({
        width: "255px",
    });
    datepicker2.appendTo('#datepickerTo');

    function getSelected() {
        var selectId = table.column(0).check
        alert(selectId);
    }
    var table;
    $(document).ready(function() {
        $('#filterdata').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "fetchFilter.php",
                method: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(jsonData) {
                    $('#jumbo').css({
                        "display": "block"
                    });
                    $('#datepickerFrom').val('');
                    $('#datepickerTo').val('');
                    $('#company').val('');
                    table = $('#data-table').DataTable({
                        columnDefs: [{
                            orderable: false,
                            defaultContent: '',
                            className: 'select-checkbox',
                            targets: 0,
                            checkboxes: {
                                selectRow: false
                            }
                        }],
                        select: {
                            style: 'os',
                            selector: 'td:first-child'
                        },
                        order: [
                            [1, 'asc']
                        ],
                        data: jsonData,
                        columns: [{
                                data: "id"
                            },
                            {
                                data: "stock_id"
                            },
                            {
                                data: "stock_date"
                            },
                            {
                                data: "stock_name"
                            },
                            {
                                data: "stock_price"
                            }
                        ]

                    });

                }
            });
        });
    });
</script>