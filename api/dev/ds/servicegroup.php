<?php

    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $loggedin = (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
    if($loggedin != 'True'){
        //echo "<script>window.location.href = \"login.php\"</script>";
        $user_name = 'Guest';
    }
    else{
        $user_name = $_SESSION['user_name'];
    }

    require_once 'admin-functions.php';
    require_once 'includes/connection.php';
    
    require_once 'includes/dashboard-header.php';



    $query = "SELECT * FROM category";
    $queryData = $dbcon->query($query);
    $cats = array();
    $cat_cnt = 0;
    while($category = $queryData->fetch(PDO::FETCH_ASSOC)){
        array_push($cats, $category);
        $cat_cnt++;
    }
    for ($i=0 ; $i < $cat_cnt ; $i++ ) { 
        $query = "SELECT * FROM subcategory WHERE category='".$cats[$i]["cat_id"]."';";
        $queryData = $dbcon->query($query);
        $subcats = array();
        $subcat_cnt = 0;
        while($subcategory = $queryData->fetch(PDO::FETCH_ASSOC)){
            array_push($subcats, $subcategory);
            $subcat_cnt++;
        }
        $cats[$i]['subcategory_counter']=$subcat_cnt;
        $cats[$i]['subcategory']=$subcats;

    }

    for ($i=0; $i < $cat_cnt; $i++) { 
      $cat = $cats[$i]["cat_id"];
      $subcatArray = $cats[$i]["subcategory"];
      for ($j=0; $j < $cats[$i]["subcategory_counter"]; $j++) { 
        $subcat = $subcatArray[$j]["subcat_id"];
        //echo $cat." ".$subcat."\n";
        $query = "SELECT * FROM services WHERE srvCategory=".$cat." AND srvSubCategory=".$subcat;
        $queryData = $dbcon->query($query);
        $srvCounter = 0;
        $srvArray = array();
        while($srv = $queryData->fetch(PDO::FETCH_ASSOC)) {
          array_push($srvArray, $srv);
          $srvCounter++;
        }
        $subcatArray[$j]["srvCounter"] = $srvCounter;
        $subcatArray[$j]["srvArray"] = $srvArray;
        $cats[$i]["subcategory"] = $subcatArray;
      }
    }
                
    ?>



    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3></h3>
                </div>

                <div class="title_right">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>SERVICE GROUP & CATEGORY</h2>
                            <ul class="nav navbar-right panel_toolbox">

                                <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <br />
                            

                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th style="display: none;">cat id</th>
                                    <th style="display: none;">subcat id</th>
                                    <th style="display: none;">srv id</th>
                                    <th></th>
                                    <th>name</th>
                                    <th>status</th>
                                    <th style="width: 300px;">action</th>
                                </tr>
                                </thead>

                                <tbody>
                                    
                    <?php
                        $data = array();
                        $query = "SELECT * FROM category";
                        $queryData = $dbcon->query($query);
                        while($category = $queryData->fetch(PDO::FETCH_ASSOC)){
                            $temp = array($category['cat_id'],
                                    '-1',
                                    '-1',
                                    $category['cat_name'],
                                    $category['catStatus']);
                            array_push($data,$temp);?>
                            <tr style="background: limegreen; color: white; font-weight: bold;">
                                
                                <td style="display: none;"><?php echo $temp[0];?></td>
                                <td style="display: none;"><?php echo $temp[1];?></td>
                                <td style="display: none;"><?php echo $temp[2];?></td>
                                <td style="background: white; color: grey; width:5px;" class="mcat">
                                     <span class="glyphicon glyphicon-menu-right white" style="font-size:15px;"></span>
                                </td>
                                <td><?php echo $temp[3];?></td>
                                <td>
                                    <?php
                                        if ($temp[4] == 'Active') {
                                            echo '<span class="glyphicon glyphicon-ok-circle white" style="font-size:25px;"></span>';
                                        }else{
                                            echo '<span class="glyphicon glyphicon-ban-circle red" style="font-size:25px;"></span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $add_link = "add-subcategory.php";
                                        $edit_link = "updateCategory.php?id=".$category['cat_id'];
                                        $publish_link = "publish.php";
                                    ?>
                                    <a href=<?php echo $add_link;?> class="btn btn-primary">add subcat</a>
                                    <a href=<?php echo $edit_link;?> class="btn btn-primary" >edit</a>
                                    <?php
                                        if ($temp[4] == 'Active') {
                                            echo '<a href='. $publish_link.' class="btn btn-primary" > unpublish</a>';
                                        }else{
                                            echo '<a href='. $publish_link.' class="btn btn-primary" > publish</a>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $query2 = "SELECT * FROM subcategory WHERE category='".$category['cat_id']."';";
                            $queryData2 = $dbcon->query($query2);
                            while($subcategory2 = $queryData2->fetch(PDO::FETCH_ASSOC)){
                                $temp = array($category['cat_id'],
                                        $subcategory2['subcat_id'],
                                        '-1',
                                        $subcategory2['subcat_name'],
                                        $subcategory2['subcatStatus']);
                                array_push($data,$temp);
                                ?>
                            <tr style="background: DeepSkyBlue; color: white;">
                                <td style="display: none;"><?php echo $temp[0];?></td>
                                <td style="display: none;"><?php echo $temp[1];?></td>
                                <td style="display: none;"><?php echo $temp[2];?></td>
                                <td style="background: white; color: grey; width:5px;">c</td>
                                <td><?php echo $temp[3];?></td>
                                <td>
                                    <?php
                                        if ($temp[4] == 'Active') {
                                            echo '<span class="glyphicon glyphicon-ok-circle white" style="font-size:25px;"></span>';
                                        }else{
                                            echo '<span class="glyphicon glyphicon-ban-circle red" style="font-size:25px;"></span>';
                                        }
                                    ?> 
                                </td>
                                <td>
                                    <?php 
                                        $add_link = "createservices.php";
                                        $edit_link = "updateSubcategory.php?id=".$subcategory2['subcat_id'];
                                        $publish_link = "publish.php";
                                    ?>
                                    <a href=<?php echo $add_link;?> class="btn btn-primary">add srvice</a>
                                    <a href=<?php echo $edit_link;?> class="btn btn-primary" >edit</a>
                                    <?php
                                        if ($temp[4] == 'Active') {
                                            echo '<a href='. $publish_link.' class="btn btn-primary" > unpublish</a>';
                                        }else{
                                            echo '<a href='. $publish_link.' class="btn btn-primary" > publish</a>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php
                                $query3 = "SELECT * FROM services WHERE srvCategory=".$category['cat_id']." AND srvSubCategory=".$subcategory2['subcat_id'];
                                $queryData3 = $dbcon->query($query3);
                                while($srv3 = $queryData3->fetch(PDO::FETCH_ASSOC)) {
                                        $temp = array($category['cat_id'],
                                            $subcategory2['subcat_id'],
                                            $srv3['srv_sl'],
                                            $srv3['srvice'],
                                            $srv3['srvStatus']);
                                        array_push($data,$temp);

                                        ?>
                            <tr >
                                <td style="display: none;"><?php echo $temp[0];?></td>
                                <td style="display: none;"><?php echo $temp[1];?></td>
                                <td style="display: none;"><?php echo $temp[2];?></td>
                                <td style="background: white; color: grey; width:5px;"></td>
                                <td><?php echo $temp[3];?></td>
                                <td>
                                    <?php
                                        if ($temp[4] == 'Active') {
                                            echo '<span class="glyphicon glyphicon-ok-circle green" style="font-size:25px;"></span>';
                                        }else{
                                            echo '<span class="glyphicon glyphicon-ban-circle red" style="font-size:25px;"></span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $add_link = "update-service.php?id=".$srv3['srv_sl'];
                                        $edit_link = "update-service.php?id=".$srv3['srv_sl'];
                                        $publish_link = "publish.php";
                                    ?>
                                    <a href=<?php echo $add_link;?> class="btn btn-primary">add option</a>
                                    <a href=<?php echo $edit_link;?> class="btn btn-primary" >edit</a>
                                    <?php
                                        if ($temp[4] == 'Active') {
                                            echo '<a href='. $publish_link.' class="btn btn-primary" > unpublish</a>';
                                        }else{
                                            echo '<a href='. $publish_link.' class="btn btn-primary" > publish</a>';
                                        }
                                    ?>

                                </td>
                            </tr>
                            <?php
                                }
                            }
                                
                        }
                    ?>

                                </tbody>

                            </table>



                        </div>
                    </div>
                </div>
            </div>

        </div>


        <?php

            require_once 'includes/dashboard-footer.php'
                

        ?>
        
    

<script type="text/javascript">
$(document).ready(function () {

    $.ajax({
        url:'suggest-subservice2.php',
        method:'get',
        dataType:'json',
        success: function(data){
            $('#datatable').datatable({
                data: data,

            });
        }
    });

    $("td.mcat").click(function(){
        $(this).parent().nextUntil("tr:has(td.mcat)").slideToggle(50);
        $(this).find('span').toggleClass('glyphicon glyphicon-menu-down glyphicon glyphicon-menu-right ');
    });
    $("td.mcat").each(function(){
        $(this).parent().nextUntil("tr:has(td.mcat)").slideToggle(50);
    });
    // $(".breakrow1").click(function(){
    //     $(this).nextUntil('.breakrow1').slideToggle(500);
    // });
    // $(".breakrow2").click(function(){
    //     $(this).nextUntil('.breakrow2').slideToggle(200);
    // });
    // $(".breakrow3").click(function(){
    //     $(this).nextUntil('.breakrow3').slideToggle(200);
    // });
});
</script>
<style type="text/css">
    .breakrow1{
        background: #FFF0DD;
        color: black;
    }
    .breakrow2{
        background: #FFF8ED;
        color: black;
    }
    .breakrow3{
        background: #FFFFFF;
        color: black;
    }
</style>

