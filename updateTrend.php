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

require_once 'admin-functions.php';
require_once 'includes/connection.php';
require_once 'includes/dashboard-header.php';

if(isset($_GET['id'])){
    $trendID =$_GET['id'];
} else{
    // $user = "";
    echo '<script language="javascript">';
    echo 'window.location.href = "dashboard.php";';
    echo '</script>';

}

$sql = "SELECT * FROM trending WHERE `id`=:id";
$query=$dbcon->prepare($sql);
$query->bindValue(':id',$trendID);
$query->execute();
$query = $query->fetch();
$trendTitle = $query['name'];

?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3></h3>
            </div>

            <div class="title_right">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>UPDATE TRENDING TITLE</h2>
                        <ul class="nav navbar-right panel_toolbox">

                            <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <br />
                        <form action="updateTrend.php?id=<?php echo $trendID;?>" method="post" data-parsley-validate class="form-horizontal form-label-left">


                           
                       

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subcat-name">Trending Title <span>*</span>
                                </label>
                                <div class="col-md-5 col-sm-6 col-xs-12">
                                    <input type="text" name="subcat-name" required value="<?php echo $trendTitle?>" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            
                            <div class="form-group">
                            <a href="deleteContent.php?trendId=<?php echo $trendID;?>" class="btn btn-default pull-right" style="font-size: 16px;
                                            padding: 15px 24px">DELETE TRENDING</a>
                                <button class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" name="create-subcat" style="font-size: 16px;
                                            padding: 15px 24px">UPDATE TRENDING</button>
                            </div>
                        </form>

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
    </script>

    <?php

    if(isset($_POST['create-subcat'])){
        $subcat_name = $_POST['subcat-name'];

        $sql = "UPDATE trending SET name=:name WHERE id=:id";
        $query = $dbcon->prepare($sql);
        $query->bindValue(':name',$subcat_name);
        $query->bindValue(':id',$trendID);

        $query->execute();
        echo '<script>location.href="ViewTrend.php"</script>';
    }

    ?>
