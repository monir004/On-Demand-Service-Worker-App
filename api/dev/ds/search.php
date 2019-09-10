<?php

require_once 'includes/connection.php';

if(!isset($_POST['search'])){
    header('Location: index.php');
}

$query = "SELECT count(*) as total FROM services WHERE srvice LIKE '".$_POST['search']."%' ORDER BY created DESC";
$data = $dbcon->query($query);
$count = $data->fetch(PDO::FETCH_OBJ);
$count = $count->total;
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
$query = "SELECT *FROM services WHERE srvice LIKE '".$_POST['search']."%' ORDER BY created DESC LIMIT ".$start.", 12";
$data = $dbcon->query($query);


require_once 'main-header-dhaka-setup.php';
?>

<!-- ad section -->
<div class="ad">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10">
                <img src="images/top-bannner.jpg">
            </div>
        </div>
    </div>
</div>
<!-- /ad section -->

<!-- cat-section -->



<section class="cat-section">
    <div class="container">
        <div class="row">
            <?php if($data->rowCount()<1) :?>
                <h3 class="heading">No Result Found</h3>
                <a href="index.php" class="btn btn-default" style="margin: 15px;">Go Back To Home</a>
            <?php endif;?>
            <?php while($service = $data->fetch(PDO::FETCH_OBJ)) :?>
                <div class="col-sm-3 col-xs-12">
                    <a href="single-cat.php?id=<?php echo $service->srv_sl?>">
                        <div class="category-image">
                            <img src="images/service/<?php echo $service->srvImage?>" alt="image-1" class="img-responsive">
                        </div>
                        <div class="cat-details">
                            <h3><?php echo $service->srvice?></h3>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<!-- / cat-section -->

<?php if($total_pages>0) : ?>
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
<?php endif;
require_once'main-footer-dhaka-setup.php';
?>

</body>

</html>