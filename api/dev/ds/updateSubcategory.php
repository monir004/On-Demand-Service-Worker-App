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
    $subcat_id =$_GET['id'];
} else{
    // $user = "";
    echo '<script language="javascript">';
    echo 'window.location.href = "dashboard.php";';
    echo '</script>';

}

$sql = "SELECT * FROM subcategory,category WHERE subcat_id=:id AND subcategory.category=category.cat_id";
$statement = $dbcon->prepare($sql);
$statement->bindValue(':id',$subcat_id);
$statement->execute();

$result = $statement->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM category";
$statement = $dbcon->prepare($sql);
$statement->execute();

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
                        <h2>ADD NEW SUBCATEGORY</h2>
                        <ul class="nav navbar-right panel_toolbox">

                            <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <br />
                        <form action="updateSubcategory.php?id=<?php echo $subcat_id;?>" method="post" data-parsley-validate class="form-horizontal form-label-left">


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"">SELECT CATEGORY <span>*</span>
                                </label>
                                <div class="col-md-5 col-sm-6 col-xs-12">
                                    <select name="category" required class="form-control" id="">
                                        <option value="">--SELECT CATEGORY--</option>
                                        <?php
                                        while ($categories = $statement->fetch(PDO::FETCH_OBJ)){?>
                                            <option value='<?php echo $categories->cat_id?>' <?php if($categories->cat_id==$result['cat_id']){echo 'selected';}?> ><?php echo $categories->cat_name?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subcat-name">SUBCATEGORY NAME <span>*</span>
                                </label>
                                <div class="col-md-5 col-sm-6 col-xs-12">
                                    <input type="text" name="subcat-name" required value="<?php echo $result['subcat_name']?>" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                            <a href="deleteContent.php?subcatId=<?php echo $subcat_id;?>" class="btn btn-default pull-right" style="font-size: 16px;
                                            padding: 15px 24px">DELETE SUBCATEGORY</a>
                                <button class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" name="create-subcat" style="font-size: 16px;
                                            padding: 15px 24px">UPDATE SUBCATEGORY</button>
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
        $category = $_POST['category'];
        $subcat_name = $_POST['subcat-name'];

        $sql = "UPDATE subcategory SET subcat_name=:name,category=:category WHERE subcat_id=:id";
        $query = $dbcon->prepare($sql);
        $query->bindValue(':name',$subcat_name);
        $query->bindValue(':category',$category);
        $query->bindValue(':id',$subcat_id);

        $query->execute();
        echo '<script>location.href="viewSubcategory.php"</script>';
    }

    ?>
