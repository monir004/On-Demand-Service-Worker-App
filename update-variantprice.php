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

        $a_sql = "select variant_price.price,variant_a.id as aid,variant_b.id as bid from service 
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
                    array_push($row,$var_price[$k]['price'].','.$var_price[$k]['aid'].','.$var_price[$k]['bid']);
                
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
                    <h2>Update Price Table</h2>

                    <ul class="nav navbar-right panel_toolbox">

                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <br />
                    <form id="createorder-form" action="#" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

        <table class="table table-bordered" <?php if(count($data[0])<=1) echo 'style="display:none"'?>>
            <thead>
                
                <tr>
                    
                    <?php
                    $thead = $data[0];
                    foreach ($thead as $ti => $hval) {
                        if($ti==0){
                            $hval = '<ul><li>'.$singleServiceDeails[0]['varb'].
                                    '</li><li>'.$singleServiceDeails[0]['vara'].'</li></ul>';
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
                        if($di==0){
                            echo '<td>'.$dval.'</td>';
                        } else{
                            $darr = explode(',',$dval);
                            echo '<td class="insertData" data-a="'.$darr[1].'" data-b="'.$darr[2].'" contenteditable>'.$darr[0].'</td>';
                        }
                    }
                    echo '</tr>';
                }
                ?>
                
            </tbody>
        </table>
        <input id="srvID" type="hidden" value="<?php echo $srvID;?>">

                        

        <div class="form-group">
        <?php echo '<a href="ViewSingleService.php?id='. $srvID. '" class="btn btn-lg btn-default pull-right" style="font-size: 16px;
                                            padding: 16px 24px">Back To Service</a>'?>
            <button type="submit" class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" id="addSrvBtn" name="addVar">Update Price</button>
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

<script>
    $('document').ready(function(){
        $(".insertData").each(function() {
            $(this).children('br[type="_moz"]').remove();
    })

    $("button").click(function(e){
        e.preventDefault();
        $.ajax({
        type: "POST",
        url: "api/adminapi/update-variant-api.php",
        data: {data:getValues(),id:$('#srvID').val()},
        success: function(data){
            console.log(data);
            window.location.href = "ViewSingleService.php?id="+$('#srvID').val();
        }
        });
    });
        
    });
    function getValues() {
        var pdata = [];
        $(".insertData").each(function() {
            item = {};
            item['vara'] = $(this).attr("data-a");
            item['varb'] = $(this).attr("data-b");
            item['price'] = $(this).html();
            pdata.push(item);
        })
        console.log(pdata);
        return pdata;
    }
</script>


    