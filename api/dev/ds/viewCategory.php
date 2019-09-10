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

$sql = "SELECT * FROM category";
$query=$dbcon->prepare($sql);
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
                        <h2>ALL SERVICES</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
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
                                <th style="text-align: center;">Category Name</th>
                                <th style="text-align: center;">Category Image</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            foreach ($query as $i => $values) {
                                $id = $values['cat_id'];
                                echo "<tr><td style=\"text-align:center;vertical-align: middle;\">" . ($i+1) . "</td>";
                                echo "<td style=\"text-align:center;vertical-align: middle; \">" . $values['cat_name'] . "</td>";
                                echo "<td style=\"text-align:center\"><img style='width: 70px;height: 70px' src='images/category/".$values['cat_image']."' alt=''></td>";
                                // echo '<td class="action" style="text-align:center"><a class="mymodal" href="#animatedModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
                                echo '<td class="action" style="text-align:center;vertical-align: middle;"><a  href="updateCategory.php?id='. $id. '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                        <p class="text-center">Showing <?php echo "$row_count of $row_count";?> services. </p>
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

