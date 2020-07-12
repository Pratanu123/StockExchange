<?php

?>
<!DOCTYPE html>
<html>

<head>
    <title>Joe Stock Exchange</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="trade.php">Trading</a></li>
                </ul>
            </div>
        </nav>
        <br />
        <br />
        <form id="upload_csv" method="post" enctype="multipart/form-data">
            <div class="col-md-3">
                <br />
                <label>Upload Stock CSV</label>
            </div>
            <div class="col-md-4">
                <input type="file" name="csv_file" id="csv_file" accept=".csv" style="margin-top:15px;" />
            </div>
            <div class="col-md-5">
                <input type="submit" name="upload" id="upload" value="Upload" style="margin-top:10px;" class="btn btn-info" />
            </div>
            <div style="clear:both"></div>
        </form>
        <br />
        <br />
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>Stock ID</th>
                        <th>Stock Date</th>
                        <th>Stock Name</th>
                        <th>Stock Price</th>
                    </tr>
                </thead>
            </table>
        </div class="col-md-3">
        <div class="col-md-5" name="delete-div" id="delete-div" style="display:none">
            <input type="submit" name="delete" id="delete" value="Delete All Record" style="margin-top:10px;" class="btn btn-info" />
        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#delete-div').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                url: "delete.php",
                dataType: 'json',
                contentType: false,
                method: "POST",
                cache: false,
                processData: false,
                success: function(jsonData) {
                    location.reload();
                }
            });
        });
    });

    $(document).ready(function() {
        event.preventDefault();
        $.ajax({
            url: "fetch.php",
            method: "POST",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(jsonData) {
                $('#data-table').DataTable({
                    data: jsonData,
                    columns: [{
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
                $('#delete-div').css("display", "block");
            }
        });
    });

    $(document).ready(function() {
        $('#upload_csv').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "import.php",
                method: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(jsonData) {
                    $('#csv_file').val('');
                    $('#data-table').DataTable({
                        data: jsonData,
                        columns: [{
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
                    $('#delete-div').css("display", "block");
                }
            });
        });
    });
</script>