<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$loggedin = (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
if($loggedin != 'True'){
    echo "<script>window.location.href = \"login.php\"</script>";
}
else{
    $user_name = $_SESSION['user_name'];
}


require_once 'includes/connection.php';
require_once 'includes/servicesInDetails.php';
$trendID = $_GET['id'];

$sql = "SELECT * FROM trending WHERE `id`=:id";
$query=$dbcon->prepare($sql);
$query->bindValue(':id',$trendID);
$query->execute();
$query = $query->fetch();
$trendTitle = $query['name'];

$sql = "SELECT 
trending_service.id as id,
service.image as image, 
service.name as service
FROM `trending_service` inner join `service` on service.id=trending_service.service_id 
WHERE `trending_id`=:id";
$query=$dbcon->prepare($sql);
$query->bindValue(':id',$trendID);
$query->execute();
$row_count = $query->rowCount();
?>


<?php

require_once 'includes/dashboard-header.php';

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            </div>
            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $trendTitle; ?></h2>
                        <?php $url = "add-trending.php?id=".$trendID;?>
                        <a href="<?php echo $url;?>" class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" name="create-button" style="font-size: 16px;
                                            ">Add Trending Service</a>
                        <ul class="nav navbar-right panel_toolbox">
                            <li style="float: right; visibility:hidden"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th style="text-align: center;">Sl. No.</th>
                                <th style="text-align: center;">Trending Service</th>
                                <th style="text-align: center;">Service Name</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            foreach ($query as $i => $values) {
                                $id = $values['id'];
                                echo "<tr><td style=\"text-align:center;vertical-align: middle;\">" . ($i+1) . "</td>";
                                echo "<td style=\"text-align:center\"><img style='width: 70px;height: 70px' src='images/services/".$values['image']."' alt=''></td>";
                                echo "<td style=\"text-align:center;vertical-align: middle; \">" . $values['service'] . "</td>";
                                echo '<td class="action" style="text-align:center;vertical-align: middle;"><a  href="updateCategory.php?id='. $values['id']. '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                        <p class="text-center">Showing <?php echo "$row_count of $row_count";?> trendings. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php

    require_once 'includes/dashboard-footer.php';

    ?>
    <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#imagepreview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#inputfile").change(function() {
                readURL(this);
            });
        });
    </script>
    </body>

    </html>

