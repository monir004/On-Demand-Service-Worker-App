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
    $sql = "SELECT * FROM category ";
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
      $sql = "SELECT * FROM subcategory WHERE category='".$categoryArray[$i]["cat_id"]."';";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        $subcatCounter = 0;
        $subcatArray = array();
        while($r = mysqli_fetch_assoc($result)) {
          $subcatArray[$subcatCounter] = $r;
          $subcatCounter++;
        }
        $categoryArray[$i]["subcatCounter"] = $subcatCounter;
        $categoryArray[$i]["subcatArray"] = $subcatArray;
      }
    }
    
    for ($i=0; $i < $categoryCounter; $i++) { 
      $cat = $categoryArray[$i]["cat_id"];
      $subcatArray = $categoryArray[$i]["subcatArray"];
      for ($j=0; $j < $categoryArray[$i]["subcatCounter"]; $j++) { 
        $subcat = $subcatArray[$j]["subcat_id"];
        //echo $cat." ".$subcat."\n";
        $sql = "SELECT * FROM services WHERE srvCategory=".$cat." AND srvSubCategory=".$subcat;
        $result = mysqli_query($conn, $sql);
        $srvCounter = 0;
        $srvArray = array();
        while($r = mysqli_fetch_assoc($result)) {
          $srvArray[$srvCounter] = $r;
          $srvCounter++;
        }
        $subcatArray[$j]["srvCounter"] = $srvCounter;
        $subcatArray[$j]["srvArray"] = $srvArray;
        $categoryArray[$i]["subcatArray"] = $subcatArray;
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