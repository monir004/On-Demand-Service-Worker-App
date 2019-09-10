<?php

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
        case 'GET':
            $category_id = $_GET['cat'];
            getOperation($category_id);
            break;
        default:
            print('{"result": "Requested http method not supported here."}');
}

function getOperation($category_id){
    include "db.php";
    $sql = "SELECT services.srvice,services.srvImage,services.srvPrice,services.srvDetails FROM services WHERE services.srvCategory='".$category_id."';";
    //echo $sql;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $rows = array();
       while($r = mysqli_fetch_assoc($result)) {
          $rows["result"][] = $r;
       }
      echo json_encode($rows);
    } else {
        echo '{"result": "No data found"}';
    }
}

?>