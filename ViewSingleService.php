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
        $sqlDetailsSingle= "SELECT 
        service.id as srv_sl,
        service.name as srvice,
        service.details as srvDetails,
        service.price as srvPrice,
        service.status as srvStatus,
        service.quantity as srvQuantity,
        service.unit as srvUnit,
        service.image as srvImage,
        service.var_a as vara,
        service.var_b as varb,
        category.name as cat_name,
        subcategory.name as subcat_name 
        FROM service inner join subcategory on service.subcategory_id=subcategory.id
        inner join category on category.id=subcategory.category_id        
        WHERE service.id=:id";
        $runDetailsSingleQuery = $dbcon->prepare($sqlDetailsSingle);
        $runDetailsSingleQuery->bindValue(':id',$srvID);
        $runDetailsSingleQuery->execute();
        $singleServiceDeails = $runDetailsSingleQuery->fetchAll(PDO::FETCH_ASSOC);

        $a_sql = "select name from variant_a where service_id=:id";
        $a_query = $dbcon->prepare($a_sql);
        $a_query->bindValue(':id',$srvID);
        $a_query->execute();
        $var_a = $a_query->fetchAll(PDO::FETCH_ASSOC);

        $a_sql = "select name from variant_b where service_id=:id";
        $a_query = $dbcon->prepare($a_sql);
        $a_query->bindValue(':id',$srvID);
        $a_query->execute();
        $var_b = $a_query->fetchAll(PDO::FETCH_ASSOC);

        $a_sql = "select variant_price.price from service 
        inner join variant_a on service.id=variant_a.service_id
        inner join variant_b on service.id=variant_b.service_id
        left join variant_price on variant_a.id=variant_price.variant_a_id and variant_b.id=variant_price.variant_b_id 
        where service.id=:id order by variant_a.id,variant_b.id";
        $a_query = $dbcon->prepare($a_sql);
        $a_query->bindValue(':id',$srvID);
        $a_query->execute();
        $var_price = $a_query->fetchAll(PDO::FETCH_ASSOC);

        // echo '<pre>';
        // print_r($var_a);
        // print_r($var_b);
        $data = array();
        $row1 = array("");
        for ($i=0; $i < count($var_b); $i++) { 
            array_push($row1,$var_b[$i]['name']);
        }
        array_push($data,$row1);
        $offset = 0;
        for ($i=0; $i < count($var_a); $i++) { 
            $row = array($var_a[$i]['name']);
            for ($j=0; $j < count($var_b); $j++) { 
                $k = $offset + $j;
                array_push($row,$var_price[$k]['price']);
            }
            array_push($data,$row);
            $offset = $offset + count($var_b);
        }
        // print_r($data);
        // echo '</pre>';
        // die();
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
                                        $retVal = ($values['srvStatus']== "active") ? "<span class='statusSign1'>&nbsp;Active</span>" : "<span class='statusSign0'>&nbsp;Not Active</span>" ;
                            ?>
                                <img src="images/services/<?php echo $values['srvImage']?>" class="img-responsive" alt="" style="margin-bottom:50px;">
                            </div>
                            <div class="col-md-6">
                               
                                <h1 id="service-name"><?php echo $values['srvice'] . $retVal;?></h1> 
                                <h4 id="service-id">Service ID: DHSA0<?php echo $values['srv_sl'];?></h4>
                                <p id="service-category">Category: <?php echo $values['cat_name'];?> </p>
                                <p id="service-subcategory">Sub Category: <?php echo $values['subcat_name'];?> </p>
                                <h2>৳ <?php echo $values['srvPrice']==-1.00? 'Price on inspection' : $values['srvPrice'].'/'.$values['srvUnit'];?><small>&nbsp;</small></h2>
                                <p id="service-qty">Min Order Quantity: <?php echo $values['srvQuantity'];?> </p>
                                <p class="description" style="border:none;"><?php echo nl2br($values['srvDetails']);?></p>
                                <table class="table table-bordered" <?php if(count($data[0])<=1) echo 'style="display:none"'?>>
                                    <thead>
                                       
                                        <tr>
                                            
                                            <?php
                                            $thead = $data[0];
                                            foreach ($thead as $ti => $hval) {
                                                if($ti==0){
                                                    $hval = '<ul><li>'.$values['varb'].
                                                            '</li><li>'.$values['vara'].'</li></ul>';
                                                }
                                                echo '<th>'.$hval.'</th>';
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for ($i=1; $i < count($data); $i++) { 
                                            echo '<tr>';
                                            $tdata = $data[$i];
                                            foreach ($tdata as $di => $dval) {
                                                echo '<td>'.$dval.'</td>';
                                            }
                                            echo '</tr>';
                                        }
                                        ?>
                                        
                                    </tbody>
                                </table>
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
                                        <?php echo '<a href="update-variant.php?id='. $id. '" class="btn btn-lg btn-default">EDIT VARIANT</a>'?>
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
