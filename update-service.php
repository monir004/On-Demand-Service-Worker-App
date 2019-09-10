<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    
    $loggedin = (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
     if($loggedin != 'True'){
        echo "<script>window.location.href = \"login.php\"</script>";
    } else{
        $user_name = $_SESSION['user_name'];
    }

    if(isset($_GET['id'])){
        $srvID=$_GET['id'];
    } else{
        echo '<script language="javascript">';
        echo 'window.location.href = "ViewService.php";';
        echo '</script>';
        
    }

    require_once 'includes/connection.php';
    require_once 'includes/servicesInDetails.php';

    // Get Single Service Details
    $sqlDetailsSingle= "SELECT 
    service.id as srv_sl,
    service.name as srvice,
    service.details as srvDetails,
    service.price as srvPrice,
    service.quantity as srvQuantity,
    service.unit as srvUnit,
    service.status as srvStatus,
    service.image as srvImage,
    service.created as created,
    service.modified as modified,
    service.var_a as vara,
    service.var_b as varb,
    service.vendor as vendor,
    service.vendor_mobile as vendor_mobile,
    category.id as cat_id,
    category.name as cat_name,
    subcategory.id as subcat_id,
    subcategory.name as subcat_name 
    FROM service inner join subcategory on service.subcategory_id=subcategory.id
        inner join category on category.id=subcategory.category_id        
        WHERE service.id=:id";
    $runDetailsSingleQuery = $dbcon->prepare($sqlDetailsSingle);
    $runDetailsSingleQuery->bindValue(':id',$srvID);
$runDetailsSingleQuery->execute();
    $singleServiceDeails = $runDetailsSingleQuery->fetch(PDO::FETCH_ASSOC);

    $srv_sl = $singleServiceDeails['srv_sl'];
    $srvice = $singleServiceDeails['srvice'];
    $srvCategory = $singleServiceDeails['cat_id'];
    $srvSubCategory = $singleServiceDeails['subcat_id'];
    $srvDetails = $singleServiceDeails['srvDetails'];
    $srvPrice = $singleServiceDeails['srvPrice'];
    $srvQuantity = $singleServiceDeails['srvQuantity'];
    $srvUnit = $singleServiceDeails['srvUnit'];
    $srvStatus = $singleServiceDeails['srvStatus'];
    $srvImage = $singleServiceDeails['srvImage'];
    $vara = $singleServiceDeails['vara'];
    $varb = $singleServiceDeails['varb'];
    $vendor = $singleServiceDeails['vendor'];
    $vendor_mobile = $singleServiceDeails['vendor_mobile'];
    $srvCreated = $singleServiceDeails['created'];
    $srvModified = $singleServiceDeails['modified'];

    $srvOrigin = (is_null($srvModified)) ? "Created: " . date("d M, Y", strtotime($srvCreated)) : "Last modified: ". date("d M, Y", strtotime($srvModified));
     // echo "<pre>";
    // print_r($singleServiceDeails);
    // echo "</pre>";

    require_once 'includes/dashboard-header.php';

?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>UPDATE SERVICE DETAILS: <small>ID: DHSA0<?php echo $srv_sl; ?></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <small class="pull-right"><i><?php echo $srvOrigin; ?></i></small>
                            <br />
                            <form id="createorder-form" action="#" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-name">Service Name <span>*</span>
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input type="text" id="service-name" name="serviceName" class="form-control col-md-7 col-xs-12" value="<?php echo $srvice;?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-details">Service Details <span class="required">*</span>
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <textarea type="text" name="serviceDetails" id="service-details" cols="30" rows="5" class="form-control col-md-7 col-xs-12" required><?php echo $srvDetails;?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-category">Service Category <span>*</span>
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <select name="serviceCategory" id="serviceCategory" class="form-control" required>
                                            <option value="">-- Select Category --</option>
                                            <?php
                                                foreach($allCategories as $key => $value){?>
                                                <option value="<?php echo  $value['id']?>" <?php if ($srvCategory==$value['id'] ) echo 'selected'; ?>>
                                                    <?php echo $value['name']; ?>
                                                </option>
                                                <?php
                                                        }
                                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-subcategory">Service Subcategory <span>*</span>
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <select name="serviceSubcategory" id="serviceSubcategory" class="form-control" onchange="showSubCat(this.value)" required>
                                            <option value="">-- Select Subcategory --</option>
                                            <?php
                                                foreach($allSubCategories as $key => $value){
                                                    ?>
                                                <option value="<?php echo $value['id']; ?>" <?php if ($srvSubCategory==$value['id'] ) echo 'selected'; ?>>
                                                    <?php echo $value['name']; ?>
                                                </option>
                                                <?php
                                                    }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-quantity">Visible to End-User?
                                    </label>
                                    <div class="col-md-3 col-sm-4 col-xs-8">
                                        <select name="serviceStatus" id="serviceStatus" class="form-control  col-md-7 col-xs-12" required>
                                            <option value="active" <?php if ($srvStatus=="active" ) echo 'selected'; ?>>Yes</option>
                                            <option value="inactive" <?php if ($srvStatus=="inactive" ) echo 'selected'; ?>>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-subcategory">Price <span>*</span>
                                    </label>
                                    <div class="col-md-3 col-sm-4 col-xs-8">
                                        <input type="text" class="form-control has-feedback-left" id="service-price" placeholder="Price" name="servicePrice" value="<?php echo $srvPrice;?>" required>
                                        <span class="form-control-feedback left" aria-hidden="true">৳</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-name">Unit Name
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input type="text" id="vendor-name" name="unit" value="<?php echo $srvUnit?>" class="form-control col-md-7 col-xs-12" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-name">Minimum Order Quantity 
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input type="text" id="vendor-name" name="quantity" value="<?php echo $srvQuantity?>" class="form-control col-md-7 col-xs-12" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-name">Variant A 
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input type="text" id="vendor-name" name="vara" value="<?php echo $vara?>" class="form-control col-md-7 col-xs-12" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-name">Variant B 
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input type="text" id="vendor-name" name="varb" value="<?php echo $varb?>" class="form-control col-md-7 col-xs-12" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-name">Vendor <span>*</span>
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input type="text" id="vendor-name" name="vendor_name" value="<?php echo $vendor?>" class="form-control col-md-7 col-xs-12" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-mobile">Vendor Mobile <span>*</span>
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input type="text" id="vendor-mobile" name="vendor_mobile" value="<?php echo $vendor_mobile?>" class="form-control col-md-7 col-xs-12" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-subcategory"> Service Image
                                    </label>
                                    <div class="col-md-3 col-sm-4 col-xs-8">
                                        <img src="images/services/<?php echo $srvImage;?>" class="img-responsive" id="imagepreview" style="" alt="">
                                        <input type="file" name="serviceImage" accept=".jpg, .jpeg" class="form-control" id="inputfile" data-input="false" data-classIcon="icon-plus" onchange="document.getElementById('imagepreview').src = window.URL.createObjectURL(this.files[0])">
                                        <label for="inputfile" style="margin-left:0px">Change Service Image</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default pull-right" id="addSrvBtn" name="updateThisService">Update Service</button>
                                    <button type="button" onclick="window.location.href='ViewSingleService.php?id=<?php echo $srv_sl; ?>'" class="btn btn-default pull-right" id="addSrvBtn">Back to Service page</button>
                                    <a href="deleteContent.php?serviceId=<?php echo $srv_sl; ?>" class="btn btn-default pull-right" style="padding:16px 30px;">DELETE SERVICE</a>
                                </div>
                            </form>
                            <?php
                                if (isset($_POST['updateThisService'])) {

                                    $serviceName = $_POST["serviceName"];
                                    $serviceDetails = $_POST["serviceDetails"];
                                    $serviceCategory = $_POST["serviceCategory"];
                                    $serviceSubcategory = $_POST["serviceSubcategory"];
                                    $serviceStatus=$_POST["serviceStatus"];
                                    $vara=$_POST["vara"];
                                    $varb=$_POST["varb"];
                                    $vendor=$_POST["vendor_name"];
                                    $vendor_mobile=$_POST["vendor_mobile"];
                                    $servicePrice = $_POST["servicePrice"];
                                    $serviceUnit = $_POST["unit"];
                                    $serviceQuantity = $_POST["quantity"];
                                    $imagename = $srvImage;
                                    $serviceModified = date('Y-m-d H:i:s');
                                    if($_FILES['serviceImage']['size']>0) {
                                        move_uploaded_file($_FILES['serviceImage']['tmp_name'], "images/services/" . $_FILES['serviceImage']['name']);
                                        $imagename = $_FILES['serviceImage']['name'];
                                    }
                                    $sqlupdateservices = "UPDATE `service` SET 
                                    `subcategory_id`='$serviceSubcategory', 
                                    `name`='$serviceName', 
                                    `details`='$serviceDetails', 
                                    `price`='$servicePrice', 
                                    `quantity`='$serviceQuantity', 
                                    `unit`='$serviceUnit', 
                                    `status`='$serviceStatus', 
                                    `modified`='$serviceModified', 
                                    `image`='$imagename', 
                                    `var_a`='$vara',
                                    `var_b`='$varb',
                                    vendor ='$vendor', 
                                    vendor_mobile = '$vendor_mobile' 
                                    WHERE `id`= '$srv_sl'";
                                    $updateOrdDetails = $dbcon->prepare($sqlupdateservices);
                                    $updateOrdDetails->execute();

                                    if ($updateOrdDetails->execute()) {
                                        echo '<script language="javascript">';
                                        echo 'alert("Thanks!  Service updated sucessfully.");';
                                        echo 'window.location.href = "ViewSingleService.php?id=';
                                        echo $srv_sl;
                                        echo '";'; 
                                        echo '</script>'; 
                                    } else { 
                                        echo '<script language="javascript">';
                                        echo 'alert("Opps! Service update failed. Please try again later");';
                                        // echo 'window.location.href = "createservices.php";';
                                        echo '</script>'; } } ?>
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
        $(document).ready(function() {
            $('.logouttab').click(function(e) {
                e.prevenDefault();
                var address = $('.logouttab').attr('href');
                window.location.href = address;
            });

            $('#serviceCategory').change(function() {
                if ($(this).val() == "Add New Category") {
                    $("#category-service-box").slideDown(200);
                } else {
                    $("#category-service-box").slideUp(200);
                }
            });

            $('#serviceSubcategory').change(function() {
                if ($(this).val() == "Add New Subcategory") {
                    $("#subcategory-service-box").slideDown(200);
                } else {
                    $("#subcategory-service-box").slideUp(200);
                }
            });

            $("#add-category-button").click(function(e) {
                e.preventDefault();
                $("#category-service-box").slideDown(200);
            });

            $("#add-subcategory-button").click(function(e) {
                e.preventDefault();
                $("#subcategory-service-box").slideDown(200);
            });

            $(".go").click(function(e) {
                e.preventDefault();
                $(this).parent().parent().parent().parent().slideUp(200);
            });


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#imagepreview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#inputfile").change(function() {
                readURL(this);
            });
        });
        </script>
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
