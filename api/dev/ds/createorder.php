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

    $DhakaAdmin = new DhakaAdmin();
    $query = "SELECT * FROM category;" ;
    $serviceData = $dbcon->query($query);

?>
                <?php

                require_once 'includes/dashboard-header.php';

                ?>

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3>CREATE NEW ORDER</h3>
                            </div>

                            <div class="title_right">
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>CUSTOMER INFORMATION</h2>

                                        <ul class="nav navbar-right panel_toolbox">

                                            <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>

                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <br />
                                        <form id="createorder-form" action="#" data-parsley-validate class="form-horizontal form-label-left">

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Mobile Number <span>*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="text" id="phone-number" class="form-control col-md-7 col-xs-12" required>
                                                    <div class="user-error" id="num_error"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Customer Name <span>*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="text" id="first-name" class="form-control col-md-7 col-xs-12">
                                                </div>
                                            </div>
                                             
                                             <!--
                                             <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Last Name <span>*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="text" id="first-name" class="form-control col-md-7 col-xs-12">
                                                </div>
                                            </div>
                                            -->

                                            

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email-name">Email ID 
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="email" id="users-email" name="email" class="form-control col-md-7 col-xs-12">
                                                    <div class="user-error" id="mail_error"></div>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--ORDER DETAILS FORM
                        =========================-->

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>ORDER DETAILS</h2>

                                        <ul class="nav navbar-right panel_toolbox">

                                            <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>

                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <br />

                                        <form id="order-details-form" data-parsley-validate class="form-horizontal form-label-left">
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="order-category">Order Category <span class="required">*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">

                                                    <select name="order-category" id="users-order-category" class="form-control" required>
                                                        <option>Select Category</option>
                                                        <?php
                                                            while($service = $serviceData->fetch(PDO::FETCH_ASSOC)){
                                                                echo '<option value="' . $service['cat_id'] . '">' . $service['cat_name'] . '</option>';
                                                            }
                                                        
                                                        ?>
                                                    </select>
                                                    <div class="service-error" id="srvc_error"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="order-subcategory">Order Subcategory <span class="required">*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">

                                                    <select name="order-subcategory" id="users-order-subcategory" class="form-control" required>
                                                        <option>Select Subcategory</option>
                                                    </select>
                                                    <div class="service-error" id="srvsc_error"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="order-service">Service <span class="required">*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">

                                                    <select name="order-Service" id="users-order-services" class="form-control" required>
                                                        <option>Select Service</option>
                                                    </select>
                                                    <div class="service-error" id="srvs_error"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="users-order-price">Price
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="text" id="users-order-price" class="form-control col-md-7 col-xs-12" required>
                                                    <div class="service-error" id="pr_error"></div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="users-order-quantity">Quantity
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12" style="width:10%">
                                                    <input type="number" id="users-order-quantity" min="1" value="1" class="form-control col-md-7 col-xs-12">
                                                </div> 
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Schedule Address <span class="required">*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <textarea type="text" name="address" id="users-address" cols="30" rows="5" class="form-control col-md-7 col-xs-12" required></textarea>
                                                    <div class="service-error" id="scha_error"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Schedule Date <span class="required">*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input id="schedule-date" class="form-control col-md-7 col-xs-12" type="text" value="" required>
                                                    <div class="service-error" id="schd_error"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="schedule-time">Schedule Time <span class="required">*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">

                                                    <select name="schedule-time" id="users-schedule-time" class="form-control" required>
                                                        <option>Select your time</option>
                                                        <option value="09:00am-11:00am">09:00am-11:00am</option>
                                                        <option value="11:00am-01:00pm">11:00am-01:00pm</option>
                                                        <option value="01:00pm-03:00pm">01:00pm-03:00pm</option>
                                                        <option value="03:00pm-05:00pm">03:00pm-05:00pm</option>
                                                        <option value="05:00pm-07:00pm">05:00pm-07:00pm</option>
                                                        <option value="07:00pm-09:00pm">07:00pm-09:00pm</option>
                                                    </select>
                                                    <div class="service-error" id="scht_error"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Short Note
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <textarea type="text" name="note" id="users-note" cols="30" rows="5" class="form-control col-md-7 col-xs-12"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-default col-md-offset-3 col-sm-offset-3" id="add-service-button">Add Service</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--INVOICE
                    ==============-->

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>INVOICE</h2>

                                        <ul class="nav navbar-right panel_toolbox">

                                            <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>

                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <br />

                                        <form id="invoice" data-parsley-validate class="form-horizontal form-label-left">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>SI</th>
                                                        <th>Service Name</th>
                                                        <th>Price (BDT)</th>
                                                        <th>Quantity</th>
                                                        <th>Total (BDT)</th>
                                                        <th>Schedule Date</th>
                                                        <th>Schedule Time</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                
                                                </tbody>
                                            </table>
                                            <button class="btn btn-default" id="create-order-button">Create Order</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <?php

                    require_once 'includes/dashboard-footer.php';

                    ?>


        <script type="text/javascript">
            $(document).ready(function () {

                var i = 0;
                var serviceObj = [{}];
                var constantServiceID;

                $('.logouttab').click(function (e) {
                    e.prevenDefault();
                    var address = $('.logouttab').attr('href');
                    window.location.href = address;
                });                
                $('#users-order-category').change(function(e){
                    if($(this).val() != 'Select Category'){
                        var category = $(this).val();
                    }
                    $.ajax({
                        type: 'POST',
                        url: 'suggest-subservice.php',
                        data: {"category": category},
                        dataType: 'html',
                        success: function(data){
                            $('#users-order-subcategory').html(data);
                        }
                    });
                });
                
                $('#users-order-subcategory').change(function(e){
                    $("#users-order-services").editableSelect('destroy');
                    if($(this).val() != 'Select Subcategory'){
                        var subcategory = $(this).val();
                        var category = $('#users-order-category').val();
                    }
                    $.ajax({
                        type: 'POST',
                        url: 'suggest-subservice.php',
                        data: {
                            "subcategory": subcategory,
                            "categorized": category
                        },
                        dataType: 'html',
                        cache: false,
                        success: function(data){
                            $('#users-order-services').html(data);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown){
                            console.log(errorThrown);
                        },
                        complete: function(XMLHttpRequest, status){
                            $('#users-order-services')
                                .editableSelect()
                                .on('select.editable-select', function (e, li) {
                                    constantServiceID = li.val();
                                    $.ajax({
                                        type: 'POST',
                                        url: 'suggest-subservice.php',
                                        data: {"serviceID" : constantServiceID},
                                        dataType: 'html',
                                        success: function(data){
                                            $('#users-order-price').val(data);
                                        }
                                    });
                            });
                        }
                    });
                });

                $('#add-service-button').click(function (e) {
                    e.preventDefault();

                    i++;
                    var invoiceTable = $('#invoice table');
                    var error=0;
                    var errormsg;

                    var serviceName = $('#users-order-services').val();
                    var serviceCategory = $('#users-order-category').val();
                    var serviceSubcategory = $('#users-order-subcategory').val();
                    var servicePrice = $('#users-order-price').val();
                    var serviceQuantity = $('#users-order-quantity').val();
                    var serviceTotalCost = servicePrice * serviceQuantity;
                    var user_address = $('#users-address').val();
                    var schedule_date = $('#schedule-date').val();
                    var schedule_time = $('#users-schedule-time').val();
                    var userNote = $('#users-note').val();
                    
                    if(serviceName == 'Select Service'){
                        errormsg = "Please Choose a Service!!";
                        error = 1;
                        $("#srvs_error").html(errormsg);
                    }
                    
                    if(serviceCategory == 'Select Category'){
                        errormsg = "Please Choose a Category!!";
                        error = 1;
                        $("#srvc_error").html(errormsg);
                    }
                    
                    if(serviceSubcategory == 'Select Subcategory'){
                        errormsg = "Please Choose a Sub-Category!!";
                        error = 1;
                        $("#srvsc_error").html(errormsg);
                    }
                    
                    if(servicePrice.length == 0){
                        errormsg = "Please Enter The Price!!";
                        error = 1;
                        $("#pr_error").html(errormsg);
                    }


                    if(user_address.length==0){
                        msg = "Empty User Address!!";
                        error = 1;
                        $("#scha_error").html(msg);
                    }

                    if(schedule_date.length==0){
                        msg = "Empty Scheduled Date!!";
                        error = 1;
                        $("#schd_error").html(msg);
                    }

                    if(schedule_time == 'Select your time'){
                        msg = "Empty Scheduled Time!!";
                        error = 1;
                        $("#scht_error").html(msg);
                    }
                    
                    
                    if(error==0){
                        var invoicerow = '<tr id=' + i + '><th scope="row">' + i + '</th><td>' + serviceName + '</td><td>' + servicePrice + '</td><td>' + serviceQuantity + '</td><td>' + serviceTotalCost + '</td><td>' + schedule_date + '</td><td>' + schedule_time + '</td><td class="action"><a href="' + i + '"><i class="fa fa-times-circle" aria-hidden="true"></i></a></td></tr>'

                        serviceObj.push({
                            serviceID: constantServiceID,
                            servicename: serviceName,
                            servicecategory: serviceCategory,
                            servicesubcategory: serviceSubcategory,
                            serviceprice: servicePrice,
                            servicequantity: serviceQuantity,
                            servicetotal: serviceTotalCost,
                            schedule_address: user_address,
                            schdule_date: schedule_date,
                            schedule_time: schedule_time,
                            note: userNote
                        });

                        console.log(serviceObj);

                        invoiceTable.append(invoicerow);
                        $('.service-error').html('');
                    }
                    
                    console.log(errormsg);
                    $('#users-order-services').val('');
                    $('#users-order-category').prop('selectedIndex', 0);
                    $('#users-order-subcategory').prop('selectedIndex', 0);
                    $('#users-order-price').val('');
                    $('#users-address').val('');
                    $('#schedule-date').val('');
                    $('#users-schedule-time').val('');
                    $('#users-order-quantity').val('1');
                    $('#users-note').val('');
                    constantServiceID = 0;
                });

                $("body").on('click', '.action a', function (e) {
                    e.preventDefault();
                    var row = $(this).closest('tr');
                    var id = $(this).attr('href');
                    delete serviceObj[id];
                    row.remove();
                });

                $('#create-order-button').click(function (e) {
                    e.preventDefault();
                    var error = 0;
                    var msg;
                    var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    var user_firstname = $('#first-name').val();
                    var user_lastname = $('#last-name').val();
                    var user_mobile = $('#phone-number').val();
                    var user_mail = $('#users-email').val();
                    
                    if(user_mobile.length != 11){
                        if(user_mobile.length==0){
                            msg = "Mobile Number is Empty!!";
                            $("#num_error").html(msg);
                        }
                        else{
                           msg = "Mobile Number is not valid!!"; 
                           $("#num_error").html(msg);
                        }
                        error = 1;
                    }
                    
                    /* if(!reg.test(user_mail)){
                        msg = "Invalid Email Address!!";
                        error = 1;
                        $("#mail_error").html(msg);
                    }
                    
                    */
                    
                    if(error==0){
                        var user_info = {
                        firstname: user_firstname,
                        lastname: user_lastname,
                        email: user_mail,
                        mobile: user_mobile
                        };
                        if (Object.keys(serviceObj).length > 1) {
                            var serviceObjString = JSON.stringify(serviceObj);
                            $.ajax({
                                type: 'POST',
                                url: 'add-order.php',
                                data: {
                                    "user-data": user_info,
                                    "order-data": serviceObjString
                                },
                                dataType: "html",
                                success: function (data) {
                                    alert(data);
                                },
                                complete: function(XMLHttpRequest, status){
                                    serviceObj = [{}];
                                    $('#invoice table').html("<thead><tr><th>SI</th><th>Service Name</th><th>Price (BDT)</th><th>Quantity</th><th>Total (BDT)</th><th>Schedule Date</th><th>Schedule Time</th><th>Action</th></tr></thead>");
                                    $('.user-error').html('');
                                    $('.service-error').html('');
                                    $('#first-name').val('');
                                    $('#last-name').val('');
                                    $('#phone-number').val('');
                                    $('#users-email').val('');
                                },
                                error: function (XMLHttpRequest, status, error) {
                                    console.log(error);
                                }
                            });
                        }
                    }
                    
                    else{
                        console.log(msg);
                    }
                });
                
                $('#schedule-date').datepicker({});
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                autosize($('.resizable_textarea'));
            });
        </script>
        <!-- /Autosize -->



    </body>

    </html>