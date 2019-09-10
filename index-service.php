<?php
require_once 'includes/connection.php';

    if(isset($_POST['service-subcategory']) && isset($_POST['service-category'])){
        $subcategory = trim($_POST['service-subcategory']);
        $category = trim($_POST['service-category']);
        
        $query = "SELECT srvice,srv_sl,srvImage FROM services WHERE srvCategory='$category' AND srvSubCategory='$subcategory' ORDER BY srvice ASC";
            
        $preparedQuery = $dbcon->prepare($query);
        $preparedQuery->execute();
        $services = $preparedQuery->fetchAll(PDO::FETCH_ASSOC);
        
        if(empty($services)){
            echo 'empty';
        }
        
        foreach($services as $serv => $n){
            $serviceid = $n['srv_sl'];
            $servicename = $n['srvice'];
            $serviceImage = $n['srvImage'];
            echo '<div class="col-sm-4">
            <div class="service-box">
                <a href="single.php?id=' . $serviceid . '">
                    <div class="image">
                        <img src="images/services/'.$serviceImage.'" class="img-responsive" alt="">
                        <button value="'.$serviceid.'" class="btn btn-default add-cart"><i class="fa fa-cart-plus"></i></button>
                    </div>
                    <div class="detail">
                        <h3>' . $servicename . '</h3>
                    </div>
                </a>
            </div>
        </div>  ';
        }
    }

if(isset($_POST['index-default'])){
    $sql = "SELECT * FROM services ORDER BY `srv_sl` DESC LIMIT 6";
    $statement = $dbcon->prepare($sql);
    $statement->execute();
    while($result = $statement->fetch(PDO::FETCH_OBJ)) :?>

        <div class="col-sm-4">
            <div class="service-box">
                <a href="single.php?id=<?php echo $result->srv_sl; ?>">
                    <div class="image">
                        <img src="images/services/<?php echo $result->srvImage; ?>" class="img-responsive" alt="">
                        <button value="<?php echo $result->srv_sl; ?>" class="btn btn-default add-cart"><i class="fa fa-cart-plus"></i></button>
                    </div>
                    <div class="detail">
                        <h3><?php echo $result->srvice; ?></h3>
                    </div>
                </a>
            </div>
        </div>

    <?php endwhile;
}
?>