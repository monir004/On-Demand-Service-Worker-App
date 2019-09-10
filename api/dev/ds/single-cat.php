<?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
        require_once 'includes/connection.php';

        if(isset($_GET['id'])){
            $cat_id=$_GET['id'];
        }
        else{
            header("Location: index.php");
        }
        require_once 'main-header-dhaka-setup.php';
          $query = "SELECT count(*) as total_cat FROM subcategory WHERE category = :category";
        $count_query =$dbcon->prepare($query);
        $count_query->bindValue(":category",$cat_id);
        $count_query->execute();
        $count = $count_query->fetch(PDO::FETCH_OBJ);
        $count = $count->total_cat;
        $total_pages = ceil($count / 4);
        if(isset($_GET['page'])){
            $start = 4 * $_GET['page'] - 4;
            if($_GET['page'] == 1){
                $first_page=true;
            }
            else{
                $first_page=false;
            }
            if($_GET['page'] == $total_pages){
                $last_page = true;
            }
            else{
                $last_page=false;
            }
        }
        else{
            $start=0;
            $first_page=true;
            if($total_pages==1){
                $last_page = true;
            }
            else{
                $last_page=false;
            }
        }

        $query = "SELECT * FROM category WHERE cat_id=:catId";
        $category_data = $dbcon->prepare($query);
        $category_data->bindValue(':catId',$cat_id);
        $category_data->execute();
        $category_count = $category_data->rowCount();
        $category = $category_data->fetch(PDO::FETCH_OBJ);


        $query = "SELECT * FROM subcategory WHERE category = :category ORDER BY `subcat_id` DESC LIMIT ".$start.", 4";

        $subcategory_data = $dbcon->prepare($query);
        $subcategory_data->bindValue(":category",$cat_id);
        $subcategory_data->execute();
        $subcategory_count = $subcategory_data->rowCount();
?>

	<?php if($category_count) : ?>
	<!-- heading section -->
        <div class="heading-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h1><?php echo $category->cat_name?></h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="breadcumb text-right">
                            <ol class="breadcrumb">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="single-cat.php?id=<?php echo $category->cat_id?>"><?php echo $category->cat_name?></a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /heading section -->
        <?php endif;?>
        
        <!-- service-section -->
        <div class="service-section">
            <div class="container">
                <?php if($subcategory_count<1) :?>
                    <h3 class="heading">No Subcategory Available</h3>
                    <a href="index.php" class="btn btn-default" style="margin: 15px;">Go Back To Home</a>
                <?php endif;?>
                <?php while($subcategory = $subcategory_data->fetch(PDO::FETCH_OBJ)) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="heading"><?php echo $subcategory->subcat_name?></h3>
                        <?php
                        $servStatus="Active";

                        $service_query = "SELECT srv_sl,srvice,srvImage FROM services WHERE srvStatus=:servstatus AND srvCategory=:category AND srvSubCategory=:subcategory ORDER BY created DESC LIMIT 8 ";
                        $service_query = $dbcon->prepare($service_query);
                        $service_query->bindValue(":category",$subcategory->category);
                        $service_query->bindValue(":subcategory",$subcategory->subcat_id);
                        $service_query->bindValue(":servstatus",$servStatus);
                        $service_query->execute();

                        ?>
                        <div class="service-slider owl-carousel">
                            <?php while($service = $service_query->fetch(PDO::FETCH_OBJ)) : ?>
                            <div class="item" style="padding: 0px 10px;">
                                <div class="hover_effect">
                                    <div class="flipEffect">
                                        <div class="front-content">
                                            <div class="service-image">
                                                <img src="images/services/<?php echo $service->srvImage?>" alt="image-1" class="img-responsive">
                                            </div>
                                            <div class="service-details">
                                                <h3><?php echo $service->srvice?></h3>
                                            </div>
                                        </div>
                                        <div class="serv-btns">
                                            <a href="single.php?id=<?php echo $service->srv_sl?>" class="btn btn-default view-btn">view details</a>
                                            <a href="<?php echo $service->srv_sl?>" data-toggle="modal" data-target="#cartModal" class="btn btn-default add-cart">add to cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <a href="view-all.php?subcat=<?php echo $subcategory->subcat_id;?>" class="btn btn-default">view all</a>
                    </div>
                </div>
                <?php endwhile;?>
            </div>
        </div>
        </div>
        <!-- / service-section -->
	
	<?php if($total_pages>0) : ?>
        <!-- pagination -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12 text-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php if($first_page==true) { echo'disabled';} ?>">
                                <a class="page-link" href="single-cat.php?id=<?php echo $cat_id?>&page=1" tabindex="-1">First</a>
                            </li>
                            <?php for($i=1; $i<= $total_pages; $i++) : ?>
                                <li class="page-item"><a class="page-link" href="single-cat.php?id=<?php echo $cat_id?>&page=<?php echo $i;?>"><?php echo $i;?></a></li>
                            <?php endfor;?>
                            <li class="page-item <?php if($last_page==true) { echo'disabled';} ?>">
                                <a class="page-link" href="single-cat.php?id=<?php echo $cat_id?>&page=<?php echo $total_pages?>">Last</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- /pagination -->
        <?php endif;?>

        <!-- cart modal -->
        <div id="cart-modal">
            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" id="cartModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="cartModalLabel"><span class="fa fa-shopping-cart"></span> Cart Information</h4>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <label for="quantity">Quantity</label>
                                <input style="width: 100px; padding: 2px 0px 2px 10px" type="number" value="1" min="1" id="quantity" required>
                                <label for="sch-date">Schedule Date</label>
                                <input type="text" placeholder="Please select a date" name="sch-date" required id="user-sch-date">
                                <label for="sch-time">Schedule Time</label>
                                <select name="schedule-time" id="users-sch-time" required>
                                    <option>Select your time</option>
                                    <option value="09:00am-11:00am">09:00am-11:00am</option>
                                    <option value="11:00am-01:00pm">11:00am-01:00pm</option>
                                    <option value="01:00pm-03:00pm">01:00pm-03:00pm</option>
                                    <option value="03:00pm-05:00pm">03:00pm-05:00pm</option>
                                    <option value="05:00pm-07:00pm">05:00pm-07:00pm</option>
                                    <option value="07:00pm-09:00pm">07:00pm-09:00pm</option>
                                </select>
                                <label for="sch-date">Schedule Address</label>
                                <textarea placeholder="Please enter your address" name="sch-addrs" rows="5" required id="user-sch-addrs"></textarea>
                                <label for="users-note">Short Note</label>
                                <textarea style="border: 1px solid #ccc;border-radius: 0px" type="text" name="note" id="users-note" cols="30" rows="5" class="form-control col-md-7 col-xs-12"></textarea>
                                <button class="btn btn-default col-md-offset-10 confirm-cart" value="" style="margin-top: 30px;">CONFIRM</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        require_once'main-footer-dhaka-setup.php';
        ?>

<script>
    $('.add-cart').click(function () {
        $('.confirm-cart').val($(this).attr('href'));
    });
</script>

    </body>

</html>