<?php

        if(isset($_GET['id'])){
            $srvID=$_GET['id'];
        } else{
            $user = "";
            $srvID = 11;
            
        }
        include 'includes/connection.php';
        // include 'includes/servicesInDetails.php';
        $sqlDetailsSingle= "SELECT * FROM services,category,subcategory WHERE srv_sl = '$srvID' AND category.cat_id = services.srvCategory AND subcategory.subcat_id = services.srvSubcategory LIMIT 1;";
        $runDetailsSingleQuery = $dbcon->prepare($sqlDetailsSingle);
        $runDetailsSingleQuery->execute();
        $singleServiceDeails = $runDetailsSingleQuery->fetchAll(PDO::FETCH_ASSOC);

require_once 'main-header-dhaka-setup.php';

?>

    <!-- Order History -->
    <section>
        <div class="service-single">
            <div class="container">
                <div class="col-md-6">
             <?php
                    // echo($singleServiceDeails);
                        foreach ($singleServiceDeails as $i => $values) {
                     // echo '<img src="data:image/jpeg;base64,'.base64_encode( $values['srvImage'] ).'"  class="img-responsive" alt="" style="margin-bottom:50px;"/>';
                ?>
                    <img src="images/services/<?php echo $values['srvImage']?>" class="img-responsive" alt="" style="margin-bottom:50px;">
                </div>
                <div class="col-md-6">
                   
                    <h1 id="service-name"><?php echo $values['srvice'];?></h1>
                    <h4 id="service-id">Service ID: DHSA0<?php echo $values['srv_sl'];?></h4>
                    <p id="service-category">Category: <a href="single-cat.php?id=<?php echo $values['cat_id']?>"><?php echo $values['cat_name'];?> </a></p>
                    <p id="service-subcategory">Sub Category: <?php echo $values['subcat_name'];?> </p>
                    <h2>৳ <?php echo $values['srvPrice'];?>.00<small>&nbsp;/unit.</small></h2>
                    <p class="description" style="border:none;"><?php echo nl2br($values['srvDetails']);?><p>
                    <form action="#">
                    <p style="overflow:auto">
                        <span class="col-md-4" style="padding-left:0px;">
                            <label for="">Quantity</label>
                        </span>
                        <span class="col-md-2">
                            <input type="number" class="form-control" id="quantity" value="1" min="1" required style="border-radius: 0px">
                        </span>
                        <!-- <span class="col-md-8"></span> -->
                    </p>
                    <p style="overflow:auto">
                        <span class="col-md-4" style="padding-left:0px;">
                            <label for="">Scheduled Address *</label>
                        </span>
                        <span class="col-md-8">
                            <textarea style="border: 1px solid #ccc;border-radius: 0px" type="text" name="address" id="user-sch-addrs" cols="30" rows="5" required class="form-control"></textarea>
                        </span>
                    </p>
                    <p style="overflow:auto">
                        <span class="col-md-4" style="padding-left:0px;">
                            <label for="">Scheduled Date *</label>
                        </span>
                        <span class="col-md-8">
                            <input style="border: 1px solid #ccc;border-radius: 0px" id="user-sch-date" class="form-control" required type="text" value="">
                        </span>
                    </p>

                    <p style="overflow:auto">
                        <span class="col-md-4" style="padding-left:0px;">
                            <label for="">Scheduled Time *</label>
                        </span>
                        <span class="col-md-8">
                            <select id="users-sch-time" required style="border: 1px solid #ccc;border-radius: 0px" class="form-control" required>
                                <option>Select your time</option>
                                <option value="09:00am-11:00am">09:00am-11:00am</option>
                                <option value="11:00am-01:00pm">11:00am-01:00pm</option>
                                <option value="01:00pm-03:00pm">01:00pm-03:00pm</option>
                                <option value="03:00pm-05:00pm">03:00pm-05:00pm</option>
                                <option value="05:00pm-07:00pm">05:00pm-07:00pm</option>
                                <option value="07:00pm-09:00pm">07:00pm-09:00pm</option>
                            </select>
                        </span>
                    </p>

                    <p style="overflow:auto">
                        <span class="col-md-4" style="padding-left:0px;">
                            <label for="">Short Note</label>
                        </span>
                        <span class="col-md-8">
                            <textarea style="border: 1px solid #ccc;border-radius: 0px" type="text" name="note" id="users-note" cols="30" rows="5" class="form-control col-md-7 col-xs-12"></textarea>
                        </span>
                    </p>
                        <button class="btn btn-default confirm-cart" value="<?php echo $values['srv_sl'];?>">ADD TO CART</button>
                    <?php
                        }
                    ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- / Order History -->

<?php 

require_once 'main-footer-dhaka-setup.php';

?>

</body>

</html>