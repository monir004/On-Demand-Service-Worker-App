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

        $vara_data = '';
        foreach ($var_a as $i => $values) {
            $vara_data = $vara_data . $values['name'].',';
        }
        $vara_data=rtrim($vara_data,',');

        $a_sql = "select name from variant_b where service_id=:id";
        $a_query = $dbcon->prepare($a_sql);
        $a_query->bindValue(':id',$srvID);
        $a_query->execute();
        $var_b = $a_query->fetchAll(PDO::FETCH_ASSOC);

        $varb_data = '';
        foreach ($var_b as $i => $values) {
            $varb_data = $varb_data . $values['name'].',';
        }
        $varb_data=rtrim($varb_data,",");

        $a_sql = "select variant_price.price from service 
        inner join variant_a on service.id=variant_a.service_id
        inner join variant_b on service.id=variant_b.service_id
        inner join variant_price on variant_a.id=variant_price.variant_a_id and variant_b.id=variant_price.variant_b_id 
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
                //array_push($row,$var_price[$k]['price']);
            }
            array_push($data,$row);
            $offset = $offset + 4;
        }
        // print_r($data);
        // echo '</pre>';
        // die();
?>

<?php

require_once 'includes/dashboard-header.php';

?>

<div class="right_col" role="main">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo $singleServiceDeails[0]['srvice']?></h3>
        </div>

        <div class="title_right">
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>UPDATE VARIANTS</h2>

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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-name">Variant A 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                
                <textarea type="text" name="vara"  id="service-details" cols="30" rows="1" class="form-control col-md-7 col-xs-12" ><?php echo $vara_data;?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-details">Variant B 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea type="text" name="varb"  id="service-details" cols="30" rows="1" class="form-control col-md-7 col-xs-12" ><?php echo $varb_data;?></textarea>
            </div>
        </div>

                        

        <div class="form-group">
        <?php echo '<a href="ViewSingleService.php?id='. $srvID. '" class="btn btn-lg btn-default pull-right" style="font-size: 16px;
                                            padding: 16px 24px">Back To Service</a>'?>
            <?php echo '<a href="update-variantprice.php?id='. $srvID. '" class="btn btn-lg btn-default pull-right" style="font-size: 16px;
                                            padding: 16px 24px">Price Table</a>'?>
            <button type="submit" class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" id="addSrvBtn" name="addVar">Save Variant Names</button>
        </div>
                    </form>
                    <?php
                        if (isset($_POST['addVar'])) {

                            $vara_all = $_POST["vara"];
                            $varb_all = $_POST["varb"];

                            $vara_arr = explode(',',$vara_all);
                            $varb_arr = explode(',',$varb_all);
                            
                            echo '<pre>';
                            print_r($vara_arr);
                            print_r($varb_arr);
                            foreach ($varb_arr as $key => $value) {
                                echo $value.PHP_EOL;
                            }
                            echo '</pre>';
                            

                            $query = "DELETE FROM `variant_a` WHERE service_id=:id";
                            $query = $dbcon->prepare($query);
                            $query->bindValue(":id",$srvID);
                            $query->execute();
                            $query = "DELETE FROM `variant_b` WHERE service_id=:id";
                            $query = $dbcon->prepare($query);
                            $query->bindValue(":id",$srvID);
                            $query->execute();
                            if($vara_all!='' && $varb_all!=''){
                                foreach ($vara_arr as $key => $value) {
                                    echo $value.PHP_EOL;
                                    $insert_sql = "INSERT INTO `variant_a`(`name`, `service_id`) VALUES ('$value','$srvID')";
                                    $dbcon->query($insert_sql);
                                }
                                foreach ($varb_arr as $key => $value) {
                                    echo $value.PHP_EOL;
                                    $insert_sql = "INSERT INTO `variant_b`(`name`, `service_id`) VALUES ('$value','$srvID')";
                                    $dbcon->query($insert_sql);
                                }
                            }
                            echo '<script language="javascript">';
                            echo "window.location.href = \"update-variant.php?id=".$srvID."\"";
                            echo '</script>';
        
                            $sqlservices = "INSERT INTO service( subcategory_id, name, details, price, status, created, image,vendor,vendor_mobile ) VALUES ('$serviceSubcategory',  '$serviceName',  '$serviceDetails', '$servicePrice', '$serviceStatus', '$serviceCreated','".$_FILES['serviceImage']['name']."','$vendor_name','$vendor_contact')";

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


    