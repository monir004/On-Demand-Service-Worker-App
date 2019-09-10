<?php
	
        require_once 'includes/connection.php';
        $query = "SELECT count(*) as total_cat FROM category";
        $count_query =$dbcon->query($query);
        $count = $count_query->fetch(PDO::FETCH_OBJ);
        $count = $count->total_cat;
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

if(isset($_SESSION['order_created'])){
    alert($_SESSION['order_created']);
    unset($_SESSION['order_created']);
}

$ad = "SELECT * FROM ad";
$ad = $dbcon->query($ad);

        
        $query = "SELECT * FROM category ORDER BY cat_id DESC LIMIT ".$start.", 12";

        $data = $dbcon->query($query);
        require_once 'main-header-dhaka-setup.php';
?>
       
        <!-- ad section -->
                <div class="ad">
                    <div class="ad-carousel owl-carousel">
                        <?php while($advertise = $ad->fetch(PDO::FETCH_OBJ)) : ?>
                        <div class="item">
                            <a href="<?php echo $advertise->link?>">
                                <img src="images/ad/<?php echo $advertise->ad_image?>" alt="">
                            </a>
                        </div>
                        <?php endwhile;?>
                    </div>
                </div>
                <!-- /ad section -->
                
        <!-- cat-section -->

        <section class="cat-section">
            <div class="container">
                <div class="row">
                    <?php while($category = $data->fetch(PDO::FETCH_OBJ)) :?>
                    <div class="col-sm-3 col-xs-12">
                        <a href="single-cat.php?id=<?php echo $category->cat_id?>">
                            <div class="category-image">
                                <img src="images/category/<?php echo $category->cat_image?>" alt="image-1" class="img-responsive">
                            </div>
                            <div class="cat-details">
                                <h3><?php echo $category->cat_name?></h3>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <!-- / cat-section -->

	<?php if($total_pages >0) : ?>
        <!-- pagination -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12 text-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php if($first_page==true) { echo'disabled';} ?>">
                                <a class="page-link" href="index.php?page=1" tabindex="-1">First</a>
                            </li>
                            <?php for($i=1; $i<= $total_pages; $i++) : ?>
                            <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>
                            <?php endfor;?>
                            <li class="page-item <?php if($last_page==true) { echo'disabled';} ?>">
                                <a class="page-link" href="index.php?page=<?php echo $total_pages?>">Last</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- /pagination -->
        <?php endif;?>
        <?php 
        require_once'main-footer-dhaka-setup.php';
        ?>

            </body>

            </html>