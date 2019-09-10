<?php

header('Content-Type: application/json charset=utf-8');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
        case 'GET':
            getOperation();
            break;
        default:
            print('{"result": "Requested http method not supported here."}');
}

function getOperation(){
    include "db2.php";
    $sql = "SELECT * FROM category; ";
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
     //print_r($categoryArray);
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
    for ($i=0; $i < $categoryCounter; $i++) { 
      $cat = $categoryArray[$i]["cat_id"];
      $subcatArray = $categoryArray[$i]["subcatArray"];
      for ($j=0; $j < $categoryArray[$i]["subcatCounter"]; $j++) { 
        $subcat = $subcatArray[$j]["subcat_id"];
        $srvArray = $subcatArray[$j]["srvArray"];
        //echo $cat." ".$subcat."\n";
        for ($k=0; $k < $subcatArray[$j]["srvCounter"]; $k++) { 
          $srvice = $srvArray[$k]["srv_sl"];
          $sql = "SELECT * FROM prop WHERE srv_sl=".$srvice;
          //echo $sql."\n";
          $result = mysqli_query($conn, $sql);
          $propCounter = 0;
          $propArray = array();
          while($r = mysqli_fetch_assoc($result)) {
            $propArray[$propCounter] = $r;
            $propCounter++;
          }
          $srvArray[$k]["propCounter"] = $propCounter;
          $srvArray[$k]["propArray"] = $propArray;
        }
        $subcatArray[$j]["srvArray"] = $srvArray;
      }
      $categoryArray[$i]["subcatArray"] = $subcatArray;
    }
    $res = array();
    $res["categoryCounter"] = $categoryCounter;
    $res["categoryArray"] = $categoryArray;
    //print_r($res);
    
    $sql = "SELECT * FROM trending ORDER by trend_id ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $trendArray = array();
      $trendCounter = 0;
      while($r = mysqli_fetch_assoc($result)) {
        $trendArray[$trendCounter] = $r;
        $trendCounter++;
      }
      //$categoryArray["categoryCounter"] = $categoryCounter;
    }
    
    $res["trendCounter"] = $trendCounter;
    $res["trendArray"] = $trendArray;
    
    echo json_encode(utf8ize( $res ));
    //print_r($res);


}
function utf8ize($d) {
  if (is_array($d)) {
     foreach ($d as $k => $v) {
       $d[$k] = utf8ize($v);
     }
  } else if (is_string ($d)) {
     return utf8_encode($d);
  }
   return $d;
}

?>