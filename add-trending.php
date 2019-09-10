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

    $trendID = $_GET['id'];

    $sql = "SELECT * FROM trending WHERE `id`=:id";
    $query=$dbcon->prepare($sql);
    $query->bindValue(':id',$trendID);
    $query->execute();
    $query = $query->fetch();
    $trendTitle = $query['name'];
?>
            <?php 

            require_once 'includes/dashboard-header.php';

            ?>

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $trendTitle; ?></h3>
                        </div>

                        <div class="title_right">
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>ADD NEW TRENDING</h2>

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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-subcategory">Service Service <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">

                                                <select name="services" id="services" class="form-control"  onchange="showSubCat(this.value)" required>
                                                    <option value="">-- Select Service --</option>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <button type="submit" class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" id="addSrvBtn" name="addServiceEntry">Add Service</button>
                                        </div>
                                    </form>
                                    <?php
                                        if (isset($_POST['addServiceEntry'])) {

                                            $serviceID = $_POST["services"];
                                            $sqlservices = "INSERT INTO trending_service(trending_id,service_id) VALUES ('$trendID',  '$serviceID')";


                                            if ($dbcon->query($sqlservices)) {
                                                echo '<script language="javascript">';
                                                echo "window.location.href = \"ViewTrendService.php?id=".$trendID."\"";
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

            $('#serviceSubcategory').change(function(e){
                if($(this).val() != 'Select Subcategory'){
                    var subcategory = $(this).val();
                }
                $.ajax({
                    type: 'POST',
                    url: 'suggest-subservice.php',
                    data: {"subcategory": subcategory},
                    dataType: 'html',
                    success: function(data){
                        $('#services').html(data);
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