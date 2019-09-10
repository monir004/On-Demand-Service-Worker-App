<?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require_once 'includes/connection.php';

        if(isset($_GET['subcat'])){
            $subcat_id = $_GET['subcat'];
        }
        else{
            header("Location: index.php");
        }
        require_once 'main-header-dhaka-setup.php';

        $query = "SELECT category.cat_name,category.cat_id,subcategory.subcat_name,subcategory.subcat_id,count(*) as total_service 
                  FROM services,category,subcategory WHERE srvSubCategory = :subcat
                  AND services.srvSubCategory=subcategory.subcat_id AND services.srvCategory = category.cat_id";
        $subcat_query =$dbcon->prepare($query);
        $subcat_query->bindValue(":subcat",$subcat_id);
        $subcat_query->execute();
        $subcat = $subcat_query->fetch(PDO::FETCH_OBJ);
        $count = $subcat->total_service;
        $total_pages = ceil($count / 12);
        if(isset($_GET['page'])){
            $start = 12 * $_GET['page'] - 12;
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

        $subcat_query = "SELECT * FROM services WHERE srvStatus=:servstatus AND srvSubCategory=:subcat";
        $subcat_query = $dbcon->prepare($subcat_query);
        $subcat_query->bindValue(":subcat",$subcat_id);
        $subcat_query->bindValue(":servstatus",'Active');
        $subcat_query->execute();
?>
        <!-- heading section -->
        <div class="heading-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h1><?php echo $subcat->subcat_name; ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="breadcumb text-right">
                            <ol class="breadcrumb">
                                <li><a href="single-cat.php?id=<?php echo $subcat->cat_id; ?>"><?php echo $subcat->cat_name; ?></a></li>
                                <li><a href="view-all.php?subcat=<?php echo $subcat->subcat_id; ?>"><?php echo $subcat->subcat_name; ?></a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /heading section -->
    
        <!-- service-section -->
        <div class="service-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="heading"><?php echo $subcat->subcat_name; ?></h3>
                        <div class="All-service-section">
                            <?php while($service = $subcat_query->fetch(PDO::FETCH_OBJ)) : ?>
                                <div class="col-sm-4 col-xs-12 hover_effect">
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
                            <?php endwhile;?>
                        </div>
                    </div>
                </div>
		</div>
		</div>
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