<?php

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
        case 'GET':
            getOperation();
            break;
        default:
            print('{"result": "Requested http method not supported here."}');
}

function getOperation(){
    include "db.php";
    $sql = "SELECT cat_id,cat_name FROM category ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $categoryArray = array();
      $categoryCounter = 0;
      while($r = mysqli_fetch_assoc($result)) {
        $categoryArray[$categoryCounter] = $r;
        $categoryCounter++;
      }
      //$categoryArray["categoryCounter"] = $categoryCounter;
    }
    // print_r($category);
    for ($i=0; $i < $categoryCounter ; $i++) { 
      $sql = "SELECT services.srvice,services.srvImage,services.srvPrice,services.srvDetails FROM services WHERE services.srvCategory='".$categoryArray[$i]["cat_id"]."';";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        $serviceCounter = 0;
        $serviceArray = array();
        while($r = mysqli_fetch_assoc($result)) {
          $serviceArray[$serviceCounter] = $r;
          $serviceCounter++;
        }
        $categoryArray[$i]["serviceCounter"] = $serviceCounter;
        $categoryArray[$i]["serviceArray"] = $serviceArray;
      }
    }
    //print_r($categoryArray);
    $res = array();
    $res["categoryCounter"] = $categoryCounter;
    $res["categoryArray"] = $categoryArray;
    //print_r($res);
    echo json_encode($res);


}

?>