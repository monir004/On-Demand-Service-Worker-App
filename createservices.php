<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    
    $loggedin = (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
     if($loggedin != 'True'){
        echo "<script>window.location.href = \"login.php\"</script>";
    }
    else{
        $user_name = $_SESSION['user_name'];
    }


    require_once 'includes/connection.php';
    require_once 'includes/servicesInDetails.php';
?>
            <?php 

            require_once 'includes/dashboard-header.php';

            ?>

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>CREATE NEW SERVICE</h3>
                        </div>

                        <div class="title_right">
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>SERVICE INFORMATION</h2>

                                    <ul class="nav navbar-right panel_toolbox">

                                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>

                                    </ul>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <br />
                                    <form id="createorder-form" action="#" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-name">Service Name <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="text" id="service-name" required name="serviceName" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-details">Service Details <span class="required">*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <textarea type="text" name="serviceDetails" required id="service-details" cols="30" rows="5" class="form-control col-md-7 col-xs-12" required></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-category">Service Category <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">

                                                <select name="serviceCategory" id="serviceCategory" class="form-control" required>
                                                    <option value="">-- Select Category --</option>

                                                    <?php
                                                        // echo var_dump($allCategories);
                                                        foreach($allCategories as $key => $value){
                                                            echo "<option value=\"".$value['id']. "\">". $value['name'] . "</option>";
                                                        }
                                                        ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-subcategory">Service Subcategory <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">

                                                <select name="serviceSubcategory" id="serviceSubcategory" class="form-control"  onchange="showSubCat(this.value)" required>
                                                    <option value="">-- Select Subcategory --</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-subcategory">Price <span>*</span>
                                            </label>
                                            <div class="col-md-3 col-sm-4 col-xs-8">
                                                <input type="text" class="form-control has-feedback-left" id="service-price" placeholder="Price" name="servicePrice" required>
                                                <span class="form-control-feedback left" aria-hidden="true">৳</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-name">Unit Name <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="text" id="vendor-name" name="serviceUnit" class="form-control col-md-7 col-xs-12" value="unit" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-name">Minimum Order Quantity <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="text" id="vendor-name" name="serviceQuantity" class="form-control col-md-7 col-xs-12" value="1" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-name">Vendor <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="text" id="vendor-name" name="vendor_name" class="form-control col-md-7 col-xs-12" value="Dhaka Setup" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-mobile">Vendor Mobile <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="text" id="vendor-mobile" name="vendor_mobile" class="form-control col-md-7 col-xs-12" value="01670894117" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-subcategory"> Service Image
                                            </label>
                                            <div class="col-md-3 col-sm-4 col-xs-8">
                                                <img src="images/imageplaceholder.jpg" class="img-responsive" id="imagepreview" style="" alt="">
                                                
                                                <input type="file" name="serviceImage"  accept=".jpg, .jpeg" class="form-control" id="inputfile" data-input="false" data-classIcon="icon-plus" onchange="document.getElementById('imagepreview').src = window.URL.createObjectURL(this.files[0])">
                                                <label for="inputfile" style="margin-left:0px">Choose Image</label>
                                            </div>
                                            <!-- <div class="imageuploaderdiv"></div> -->
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" id="addSrvBtn" name="addServiceEntry">Add Service</button>
                                        </div>
                                    </form>
                                    <?php
                                        if (isset($_POST['addServiceEntry'])) {

                                            $serviceName = $_POST["serviceName"];
                                            $serviceDetails = $_POST["serviceDetails"];
                                            $serviceCategory = $_POST["serviceCategory"];
                                            $serviceSubcategory = $_POST["serviceSubcategory"];
                                            $servicePrice = $_POST["servicePrice"];
                                            $serviceUnit = $_POST["serviceUnit"];
                                            $serviceQuantity = $_POST["serviceQuantity"];
                                            $vendor_name = $_POST["vendor_name"];
                                            $vendor_contact = $_POST["vendor_mobile"];
                                            $serviceStatus="active";
                                            $serviceCreated = date('Y-m-d H:i:s');
                                            move_uploaded_file($_FILES['serviceImage']['tmp_name'], "images/services/" . $_FILES['serviceImage']['name']);

                                            $sqlservices = "INSERT INTO service( subcategory_id, name, details, price, unit, quantity, status, created, image,vendor,vendor_mobile ) VALUES ('$serviceSubcategory',  '$serviceName',  '$serviceDetails', '$servicePrice', '$serviceUnit', '$serviceQuantity', '$serviceStatus', '$serviceCreated','".$_FILES['serviceImage']['name']."','$vendor_name','$vendor_contact')";

                                            if ($dbcon->query($sqlservices)) {
                                                echo '<script language="javascript">';
                                                echo 'alert("Thanks! New SERVICE added sucessfully.");';
                                                // echo 'window.location.href = "index.html";';
                                                echo "window.location.href = \"ViewService.php\"";
                                                echo '</script>';
                                            } else {
                                                echo '<script language="javascript">';
                                                echo 'alert("Sorry! New SERVICE creation failed. Please try again later");';
                                                // echo 'window.location.href = "createservices.php";';
                                                echo '</script>';
                                            }
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?php 

                require_once 'includes/dashboard-footer.php';

                ?>


    <script>
        $("#subcategory-service-box").hide();
        $("#category-service-box").hide();
        $(document).ready(function () {
            
            $('.logouttab').click(function(e){
                    e.prevenDefault();
                    var address = $('.logouttab').attr('href');
                    window.location.href = address;
                });
                
                $('#serviceCategory').change(function(e){
                    if($(this).val() != 'Select Category'){
                        var category = $(this).val();
                    }
                    $.ajax({
                        type: 'POST',
                        url: 'suggest-subservice.php',
                        data: {"category": category},
                        dataType: 'html',
                        success: function(data){
                            $('#serviceSubcategory').html(data);
                        }
                    });
                });


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#imagepreview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#inputfile").change(function () {
                readURL(this);
            });
        });
    </script>

</body>

</html>