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
        if(isset($_GET['id'])){
            $srvID=$_GET['id'];
        } else{
            // $user = "";
            echo '<script language="javascript">';
            echo 'window.location.href = "dashboard.php";';
            echo '</script>';
            
        }
        
        require_once 'includes/connection.php';
        require_once 'includes/servicesInDetails.php';
        // include 'includes/servicesInDetails.php';
        $sqlDetailsSingle= "SELECT services.srv_sl,services.srvice,services.srvDetails,services.srvDetails,services.srvPrice,services.srvStatus,services.srvImage,
                          category.cat_name,subcategory.subcat_name FROM services,category,subcategory 
                          WHERE services.srv_sl=:id AND services.srvCategory=category.cat_id AND services.srvSubCategory=subcategory.subcat_id";
        $runDetailsSingleQuery = $dbcon->prepare($sqlDetailsSingle);
        $runDetailsSingleQuery->bindValue(':id',$srvID);
        $runDetailsSingleQuery->execute();
        $singleServiceDeails = $runDetailsSingleQuery->fetchAll(PDO::FETCH_ASSOC);
?>


            <?php

            require_once 'includes/dashboard-header.php';

            ?>
            <style type="text/css">
                /*===============================
                        Service-Single.html
                =================================*/

                .service-single {
                    padding-top: 40px;
                    padding-bottom: 10px;
                }

                .service-single button {
                    border: 2px solid transparent;
                    color: white;
                    font-weight: 100;
                    width: auto;
                    height: auto;
                    padding: 15px 25px;
                    margin-top: 30px;
                }

                .service-single button:hover {
                    background-color: transparent;
                    border: 2px solid #01b1d7;
                    color: black;
                }

                #service-name {
                    margin-top: 0px;
                }

                #service-id {
                    opacity: 0.7;
                    margin-bottom: 20px;
                }

                #service-category {
                    margin-bottom: 0px;
                }

                #service-subcategory {
                    margin-bottom: 20px;
                }

                .description {
                    margin-top: 30px;
                    margin-bottom: 30px;
                    text-align: justify;
                }
                .statusSign0{
                    font-size: 33%;
                    color: red;
                    font-style: italic;
                }
                .statusSign1{
                    font-size: 33%;
                    color: blue;
                    font-style: italic;
                }
            </style>
            <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                    <div class="service-single">
                        <div class="container">
                            <div class="row" style="margin-top: 40px;">
                                <div class="col-md-6">
                         <?php
                                    // echo "<pre>";
                                    // print_r($singleServiceDeails);
                                    // echo "</pre>";
                                    foreach ($singleServiceDeails as $i => $values) {
                                        $retVal = ($values['srvStatus']== "Active") ? "<span class='statusSign1'>&nbsp;Active</span>" : "<span class='statusSign0'>&nbsp;Not Active</span>" ;
                            ?>
                                <img src="images/services/<?php echo $values['srvImage']?>" class="img-responsive" alt="" style="margin-bottom:50px;">
                            </div>
                            <div class="col-md-6">
                               
                                <h1 id="service-name"><?php echo $values['srvice'] . $retVal;?></h1> 
                                <h4 id="service-id">Service ID: DHSA0<?php echo $values['srv_sl'];?></h4>
                                <p id="service-category">Category: <?php echo $values['cat_name'];?> </p>
                                <p id="service-subcategory">Sub Category: <?php echo $values['subcat_name'];?> </p>
                                <h2>৳ <?php echo $values['srvPrice'];?>.00<small>&nbsp;/unit.</small></h2>
                                <p class="description" style="border:none;"><?php echo nl2br($values['srvDetails']);?></p>
                                <!--
                                <form action="#">
                                <p style="overflow:auto">
                                    <span class="col-md-2" style="padding-left:0px;">
                                         
                                        <label for="">Quantity</label>
                                        
                                    </span>
                                    <span class="col-md-2">
                                        
                                        <input type="number" class="form-control" value="1" min="1" style="border-radius: 0px">
                                       
                                    </span>
                                    <span class="col-md-8"></span> 
                                </p>
                                <?php
                                    }
                                ?>
                                
                                <a href="#" class="btn btn-lg btn-default">BOOK NOW</a>
                                
                                </form>
                                -->
                            </div>
                            </div>
                            <?php
                            $id = $values['srv_sl'];
                            ?>
                            <div class="row" style="border-top: 1px solid #ccc;">
                                <div class="col-md-12">
                                    <div class="edit-btn pull-right" style="margin-top: 20px;">
                                        <?php echo '<a href="update-service.php?id='. $id. '" class="btn btn-lg btn-default">EDIT NOW</a>'?>
                                        <a href="ViewService.php" class="btn btn-lg btn-default">BACK TO LIST</a>
                                    </div>
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
</body>

</html>
