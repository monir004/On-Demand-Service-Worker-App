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
?>


            <?php

            require_once 'includes/dashboard-header.php';

            ?>
            <style>
               table thead tr th,
               table tbody tr td{
                text-align: center!important;
               } 
               .form-control-feedback {
                    margin: 6px 10px 0 0!important;
                }
            </style>
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
                                <div  id="allServices" class="x_content">
                                    <div class="form-group has-feedback col-sm-3 col-sm-offset-9">
                                        <input type="text" class="filter-box form-control" data-filter-options='{ "filterTarget":"#allServices .service td.name", "filterHide":"#allServices .service", "highlightColor":"#1ABB9C"}' placeholder="e.g. garments products">
                                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <br />
                                    <br />
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="service">
                                                <th>Sl. No.</th>
                                                <th>Service Name</th>
                                                <th>Service Category</th>
                                                <th>Service Subcategory</th>
                                                <th>Price (BDT)</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 

                                            foreach ($allServicesDeails as $i => $values) {
                                                $id = $values['srv_sl'];
                                                  echo "<tr class='service'>";
                                                  echo "<td>" . ($i+1) . "</td>";
                                                  echo "<td class='name'>" . $values['srvice'] . "</td>";
                                                  echo "<td>" . $values['cat_name'] . "</td>";
                                                  echo "<td>" . $values['subcat_name'] . "</td>";
                                                  echo "<td>" . $values['srvPrice'] . "</td>";
                                                  echo "<td>" . $values['srvStatus'] . "</td>";
                                                  // echo '<td class="action" style="text-align:center"><a class="mymodal" href="#animatedModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
                                                  echo '<td class="action"><a  href="ViewSingleService.php?id='. $id. '"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;&nbsp;/&nbsp;&nbsp;<a  href="update-service.php?id='. $id. '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
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
                <script type="text/javascript" src="js/filterThis.js"></script>
    <script>
    $("input.filter-box").filterThis();
    $("#subcategory-service-box").hide();
    $("#category-service-box").hide();
    $(document).ready(function() {

        $('#serviceCategory').change(function() {
            if ($(this).val() == "Add New Category") {
                $("#category-service-box").slideDown(200);
            } else {
                $("#category-service-box").slideUp(200);
            }
        });

        $('#serviceSubcategory').change(function() {
            if ($(this).val() == "Add New Subcategory") {
                $("#subcategory-service-box").slideDown(200);
            } else {
                $("#subcategory-service-box").slideUp(200);
            }
        });

        $("#add-category-button").click(function(e) {
            e.preventDefault();
            $("#category-service-box").slideDown(200);
        });

        $("#add-subcategory-button").click(function(e) {
            e.preventDefault();
            $("#subcategory-service-box").slideDown(200);
        });


        $(".go").click(function(e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent().slideUp(200);
        });


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
