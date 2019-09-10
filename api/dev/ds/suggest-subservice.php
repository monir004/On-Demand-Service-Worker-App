<?php
    
    require_once 'includes/connection.php' ;

    if(isset($_POST['category'])){
  
        echo '<option>Select Subcategory</option>';
        $category = $_POST['category'];
        $query = "SELECT * FROM subcategory WHERE category = '$category'";
        $queryData = $dbcon->query($query);
        
        while($subcategory = $queryData->fetch(PDO::FETCH_ASSOC)){
            echo '<option value="' . $subcategory['subcat_id'] . '">' . $subcategory['subcat_name'] . '</option>';
        }
    }

    if(isset($_POST['subcategory'])){
  
        echo '<option>Select Services</option>';
        $category = trim($_POST['categorized']);
        $subcategory = trim($_POST['subcategory']);
        $query = "SELECT srvice,srv_sl,srvPrice FROM services WHERE srvCategory = '$category' AND srvSubCategory = '$subcategory' ORDER BY srvice ASC";
        $queryData = $dbcon->query($query);
        
        while($services = $queryData->fetch(PDO::FETCH_ASSOC)){
            echo '<option value="' . $services['srv_sl'] . '">' . $services['srvice'] . '</option>';
        }
    }


    if(isset($_POST['serviceID'])){

        $serviceID = trim($_POST['serviceID']);
        $query = "SELECT * FROM prop WHERE srv_sl='$serviceID'";
        $queryData = $dbcon->query($query);
        $i = 0;
        while($services = $queryData->fetch(PDO::FETCH_ASSOC)){
            $i++;
            echo '<option value="' . $services['prop_id'] . '">' . $services['name'] . '</option>';
        }
        if($i == 0){
            echo 'no option';
            $serviceID = trim($_POST['serviceID']);
            $query = "SELECT srvPrice FROM services WHERE srv_sl='$serviceID'";
            $queryData = $dbcon->query($query);
            $price = $queryData->fetch(PDO::FETCH_ASSOC);
            echo $price['srvPrice'];
        }

    }

            

    if(isset($_POST['type'])){

        $typeID = trim($_POST['type']);
        $query = "SELECT price FROM prop WHERE prop_id='$typeID'";
        $queryData = $dbcon->query($query);
        $price = $queryData->fetch(PDO::FETCH_ASSOC);
        echo $price['price'];
    }

?>