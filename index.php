<?php
include_once('MethodsFile.php');
$obj = new MethodsClass();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <?php echo $obj->cssLinks(); ?>

</head>

<body>
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Add New Number
                    </div>
                    <div class="card-body">
                        <div class="mb-3" id="message"></div>
                        <form method="POST" id="contact_form">
                            <div class="form-group">
                                <input type="hidden" name="id_field" id="id_field" value="">
                                <label>Contact Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="number_field" id="number_field" placeholder="eg: (country code)-368-401454">
                            </div>
                            <div class="form-group">
                                <label>Contact Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name_field" id="name_field" placeholder="enter contact name">
                            </div>
                            <input type="submit" value="Submit" name="submit_btn">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                All Contact Numbers
                            </div>
                            <div class="col-md-4">
                                <input type="search" class="form-control" name="keyword_field" id="keyword_field" placeholder="enter keywords to search" onkeyup="readData()">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Contry Short Code</th>
                                    <th>Prefix</th>
                                    <th>Number</th>
                                    <th>Last Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $obj->jsLinks(); ?>

</body>

</html>