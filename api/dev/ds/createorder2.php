<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$loggedin = (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
if($loggedin != 'True'){
//echo "<script>window.location.href = \"login.php\"</script>";
    $user_name = 'Guest';
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

            <!--modal-->

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="modal fade" id="loginModal" tabindex="-1">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Discount</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <input id="discInput" type="text" name="usernames" class="form-control" value="">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" id="discApply">Apply</button>
                                        <button class="btn btn-danger" data-dismiss="modal">close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="page-title">
                <div class="title_left">
                    <h3>CREATE NEW ORDER</h3>
                </div>

                <div class="title_right">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

        <!--User FORM
            =========================-->
            <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
                <!-- user tite -->
                <div class="x_title">
                    <i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-user"></i>

                    <h2>SEARCH CUSTOMER</h2>

                    
                    <div class="clearfix"></div>

                </div>

                <div class="x_content" style="height: 350px">
                    <br />
            
            <!-- user body -->

         <form id="createorder-form" action="#" data-parsley-validate class="form-horizontal form-label-left">

            <div class="form-group">
               
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1">+88</span>
                      <input type="text" id="phone-number" class="form-control col-md-7 col-xs-12" placeholder="01715xxxxxx" required>
                      
                    </div>
                    <div class="user-error" id="num_error"></div>
                </div>
                <div class="col-md-4 col-sm-3 col-xs-12" id="search_user_btn">
                    <button id="search_customer" class="btn btn-default" id="create-order-button">Search Customer</button>
                </div>
            </div>

            <p id="customernotfoundp" style="display: none; text-align: center;">No customer data available please enter customer information!</p>
            
            <hr style="width: 100%;  height: 1px; background-color:#ccc;" />

         </form>

         <div class="row" id="customerfound" style="display: block; padding-top: 20px;">
             <div class="col-md-6">
                 <div class="panel panel-default">
                  <div class="panel-heading">Customer Info</div>
                  <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="">
                                <img width="30px" height="30px" src="http://www.personalbrandingblog.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640-300x300.png" alt="Chania"> 
                                <button type="button" class="btn btn-success" 
                                   style="width: 30px; height: 15px; font-size: 10px; padding: 0px; margin-top: 15px;">
                                    <span class="glyphicon glyphicon-search" style="font-size: 5px; padding: 0px;"></span> view
                                </button>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h2 style="margin: 0px;" id="u_name">Nazmus Sakib</h2>
                            
                            <p style="margin: 2px;" id="u_mobile"> 
                                <i class="fa fa-phone" aria-hidden="true" style="margin-right: 3px; padding-top: 3px;"></i> 
                                +8801521220462 
                            </p>
                            
                            <p style="margin: 2px;" id="u_email"> 
                                <i class="fa fa-envelope" aria-hidden="true" style="margin-right: 3px;padding-top: 3px;"></i> 
                                sakib6900@gmail.com 
                            </p>
                            
                            <p style="margin: 2px;" id="u_company"> 
                                <i class="fa fa-briefcase" aria-hidden="true" style="margin-right: 3px;padding-top: 3px;"></i>
                                 Sheba platform ltd 
                            </p>
                            
                            <p style="margin: 2px;" id="u_address"> 
                                <i class="fa fa-map-marker" aria-hidden="true" style="margin-right: 3px;padding-top: 3px;"></i>
                                 Mohammadpur, Dhaka
                            </p>
                        </div>
                    </div>
                  </div>
                </div>
             </div>
             <div class="col-md-6">
                 <div class="panel panel-default">
                <div class="panel-heading">Customer History</div>
                  <div class="panel-body" style="padding: 8px 0px">

                    <p class="col-md-6" style="text-align: right;">Total order:</p>
                    <p class="col-md-6">2</p>

                    <p class="col-md-6" style="text-align: right;">Total Amount:</p>
                    <p class="col-md-6">24,500</p>

                    <p class="col-md-6" style="text-align: right;">Due:</p>
                    <p class="col-md-6">3,000</p>

                    <p class="col-md-6" style="text-align: right;">Last order:</p>
                    <p class="col-md-6">20 march 2018</p>

                  </div>
                </div>
             </div>
         </div>

         <div class="row" id="customernotfound" style="display: none;">
             <div class="col-md-12">
                 
                         <form action="/action_page.php">
                          <div class="form-group">
                            <label for="email"> <i class="fa fa-user" style="margin-right: 5px;"></i> Customer name:</label>
                            <input type="email" class="form-control" id="email">
                          </div>
                          <div class="form-group">
                            <label for="pwd"> <i class="fa fa-university" style="margin-right: 5px;"></i> Company name:</label>
                            <input type="password" class="form-control" id="pwd">
                          </div>
                          <div class="form-group">
                            <label for="pwd"> <i class="fa fa-envelope" style="margin-right: 5px;"></i> Email ID:</label>
                            <input type="password" class="form-control" id="pwd">
                          </div>
                        </form> 
                  
             </div>
             
         </div>


                </div>
            </div>
        </div>
            

            <!--LOCATION FORM
            =========================-->

            
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <!-- location tite -->

                        <div class="x_title">
                            <i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-map-marker"></i>

                            <h2>LOCATION</h2>

                           
                            <div class="clearfix"></div>

                        </div>

                        <div class="x_content" style="height: 350px">
                    <br />

                        <!-- location body -->

                        <div class="x_content">
                            <br />

                            <form id="order-details-form" data-parsley-validate class="form-horizontal form-label-left" style="margin-top: -20px;">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select name="order-category" id="users-order-category2" class="form-control" required>
                                            <option>Select District</option>
                                            <?php
                                                while($service = $serviceData->fetch(PDO::FETCH_ASSOC)){
                                                    echo '<option value="' . $service['cat_id'] . '">' . $service['cat_name'] . '</option>';
                                                }
                                            
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                        <select name="order-subcategory" id="users-order-subcategory2" class="form-control" required>
                                            <option>Select Area</option>
                                        </select>
                                        <div class="service-error" id="srvsc_error"></div>
                                    </div>
                                </div>

                               

                                <div class="form-group">
                                    
                                    <div class="col-md-12" style="font-size: 18px;">
                                        <label for="pwd"> <i class="fa fa-home" style="margin-right: 5px;"></i> Address:</label>
                                        <textarea type="text" name="address" id="users-address" cols="30" rows="5" class="form-control col-md-7 col-xs-12" required></textarea>
                                        <div class="service-error" id="scha_error"></div>
                                  </div> 
                              </div>

                                <div class="form-group" style="margin-top: 15px;">
                                    
                                    <div class="col-md-12" >
                                          <div class="radio">
                                              <label><input type="radio" name="optradio" >B2B</label>
                                            </div>
                                            <div class="radio">
                                              <label><input type="radio" name="optradio">Retail</label>
                                            </div>
                                  </div>    
                              </div>                                


                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <!--Starting schedule
        ==============-->

                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <!-- schedule tite -->

                        <div class="x_title">
                            <i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-clock-o"></i>

                            <h2>STARTING SCHEDULE</h2>

                            <div class="clearfix"></div>

                        </div>

                        <div class="x_content" style="height: 100px">
                    <br />

                        <!-- schedule body -->

                        <div class="x_content" style="margin-top: -25px;">
                            <br />

                        <form>
                            <div class="form-group col-md-6">
                                <label for="name" class="control-label"><i class="fa fa-calendar" style="margin-right: 5px;"></i> Starting Date</label>
                                <input id="schedule-date" class="form-control" type="text" value="" required>
                                                    <div class="service-error" id="schd_error"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label" for="schedule-time"> <i class="fa fa-clock-o" style="margin-right: 5px;"></i> Starting Time </label>
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

                        </form>

                        </div>
                    </div>
                </div>
            </div>


                
              <!--Assignee Form
        ==============-->

                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <!-- ASSIGNEE tite -->

                        <div class="x_title">
                            <i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-group"></i>

                            <h2>ASSIGNEE</h2>

                            
                            <div class="clearfix"></div>

                        </div>

                        <div class="x_content" style="height: 100px">
                    <br />

                        <!-- ASSIGNEE body -->

                        <div class="x_content" style="margin-top: -25px;">
                            <br />

                        <form>

                            <div class="form-group col-md-12">
                                <label class="control-label" for="schedule-time"> <i class="fa fa-user" style="margin-right: 5px;"></i> Assigne Employee </label>
                                <select name="schedule-time" id="users-schedule-time" class="form-control" required>
                                                        <option>Select your worker</option>
                                                        <option value="09:00am-11:00am">Md. Shagor</option>
                                                        <option value="11:00am-01:00pm">Rahim</option>
                                                        <option value="01:00pm-03:00pm">KArim</option>
                                                        <option value="01:00pm-03:00pm">Ram</option>
                                                        <option value="01:00pm-03:00pm">Shaam</option>
                                                    </select>
                                                    <div class="service-error" id="scht_error"></div>
                            </div>

                        </form>

                        </div>
                    </div>
                </div>
            </div>


            <!--Service Form
            =========================-->

            
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <!-- Service tite -->

                        <div class="x_title">
                            <i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-cogs"></i>

                            <h2>Select Service</h2>

                        
                            <div class="clearfix"></div>

                        </div>

                        <div class="x_content" style="height: 700px">
                    <br />

                        <!-- Service body -->

                        <div class="x_content">
                            <br />
                            <form id="order-details-form" data-parsley-validate class="form-horizontal form-label-left" style="margin-top: -20px;">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label" style="margin-bottom: 5px; margin-top: -15px; margin-left: 2px;">Category Group</label>

                                        <select name="order-category" id="users-order-category" class="form-control" required>
                                            <option>Select Category Group</option>
                                            <?php
                                                $DhakaAdmin = new DhakaAdmin();
                                                $query = "SELECT * FROM category;" ;
                                                $serviceData = $dbcon->query($query);
                                                while($service = $serviceData->fetch(PDO::FETCH_ASSOC)){
                                                    echo '<option value="' . $service['cat_id'] . '">' . $service['cat_name'] . '</option>';
                                                }
                                            
                                            ?>
                                        </select>
                                        <div class="service-error" id="srvc_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label" style="margin-bottom: 5px; margin-left: 2px;">Category</label>

                                        <select name="order-subcategory" id="users-order-subcategory" class="form-control" required>
                                            <option>Category</option>
                                        </select>
                                        <div class="service-error" id="srvsc_error"></div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label" style="margin-bottom: 5px; margin-left: 2px;">Service</label>
                                        <select name="order-Service" id="users-order-services" class="form-control" required>
                                            <option>Select Service</option>
                                        </select>
                                        <div class="service-error" id="srvs_error"></div>
                                    </div>
                                </div>

                               
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label" style="margin-bottom: 5px; margin-left: 2px;">Select Type</label>
                                        <select name="order-Service" id="users-order-type" class="form-control" required>
                                            <option>Select Type</option>
                                            <option value="09:00am-11:00am">1</option>
                                            <option value="09:00am-11:00am">2</option>
                                            <option value="09:00am-11:00am">3</option>
                                            <option value="09:00am-11:00am">4</option>
                                        </select>
                                        <div class="service-error" id="srvs_error"></div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin: 0px;">
                                        <label class="control-label" style="margin-bottom: 5px; margin-left: 2px;">Price</label>
                                        <input id="users-order-price" type="text"  class="form-control" style="margin-left: 0px; margin-right: 10px;" required>
                                        <div class="service-error" id="pr_error"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                        <label class="control-label" style="margin-bottom: 5px; margin-left: 10px;">Quantity</label>
                                    <div class="col-md-12" >
                                        <input type="number" id="users-order-quantity" min="1" value="1" class="form-control col-md-7 col-xs-12">
                                    </div> 
                                </div>
                                


                                


                                <div class="form-group">
                                    
                                    <div class="col-md-12" >
                                        <label for="pwd"> Additional information:</label>
                                        <textarea type="text" name="address" id="users-address" cols="30" rows="3" class="form-control col-md-7 col-xs-12" required></textarea>
                                        <div class="service-error" id="scha_error"></div>
                                  </div> 
                              </div>

                              <div class="col-md-12 text-center" id="search_user_btn" style="margin-top: 20px;">
                                <button class="btn btn-default" id="add-service-button">Add service +</button>
                            </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>


                <!--Order form
        ==============-->
            <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-file-text"></i>
                            <h2>Order details</h2>

                             <ul class="nav navbar-right panel_toolbox">

                                           

                                        </ul>
                                        <div class="clearfix"></div>

                        </div>

                        <div class="x_content">
                            <br />
                             
                             <div class="dropdown" style="margin-top: -70px; float: right;">
                              <button class=" dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-bars"></i></button>

                              <ul class="dropdown-menu pull-right">
                                <li><a href="#" data-target="#loginModal" data-toggle="modal">Discount <i class="fa fa-plus" style="margin-left: 60px;"></i></a>  </li>
                                <li><a href="#">Promo Code <i class="fa fa-plus" style="margin-left: 40px;"></i></a></li>
                              </ul>
                            </div> 

                            <form id="invoice" data-parsley-validate class="form-horizontal form-label-left">
                                <table id="invoiceTable" class="table table-hover table-bordered">
                                    <thead>
                                        <tr style="background: #E8E8E8;">
                                            <th class="col-md-3"> <i class="fa fa-cogs" style="margin-right: 2px;"></i> Service</th>
                                            <th class="col-md-3"> <i class="fa fa-plus-square" style="margin-right: 2px;"></i> Options</th>
                                            <th class="col-md-2"> <i class="fa fa-list-ol" style="margin-right: 2px;"></i> Qty</th>
                                            <th class="col-md-2"> <i class="fa fa-usd" style="margin-right: 2px;"></i> Unit</th>
                                            <th class="col-md-2"> <i class="fa fa-usd" style="margin-right: 2px;"></i> Total</th>
                                        </tr>

                                        <!-- <tr>
                                            <td>Ac service</th>
                                            <td>1 ton, window</th>
                                            <td>2</th>
                                            <td class="text-right">10000</th>
                                            <td class="text-right">20000</th>
                                        </tr>

                                        <tr>
                                            <td>Ac service Ac service </th>
                                            <td>1 ton, window 1 ton, window</th>
                                            <td>2</th>
                                            <td class="text-right">100000</th>
                                            <td class="text-right">200000</th>
                                        </tr> -->

                                        <tr id="tableEnd">
                                            <td colspan="4" class="text-right" > total </td>
                                            <td class="text-right"> <div id="totTable">0</div> </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" class="text-right"> Promo / discount </td>
                                            <td class="text-right"> <div id="discTable">0</div> </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" class="text-right"> Net Bill </td>
                                            <td class="text-right"> <div id="netTable">0</div> </td>
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

        

        </div>


        <?php

        require_once 'includes/dashboard-footer.php';

        ?>


<script type="text/javascript">
$(document).ready(function () {

    
    var customernotfound = document.getElementById("customernotfound");
    var customernotfoundp = document.getElementById("customernotfoundp");
    var customerfound = document.getElementById("customerfound");
    var search_user_btn = document.getElementById("search_user_btn");
    var toggler = true;

    var discInput = document.getElementById("discInput");
    var discApply = document.getElementById("discApply");
    var totTable = document.getElementById("totTable");
    var discTable = document.getElementById("discTable");
    var netTable = document.getElementById("netTable");


    // search_user_btn.onclick= function(){
    //     if (toggler) {
    //         customernotfound.style.display = "block";
    //         customernotfoundp.style.display = "block";
    //         customerfound.style.display="none";
    //     } else {
    //         customernotfound.style.display = "none";
    //         customernotfoundp.style.display = "none";
    //         customerfound.style.display="block";
    //     }
    //     toggler = !toggler;
    // }


    discApply.onclick = function(){

        var discInput1 = Number(discInput.value);
        var totTable1 = Number(totTable.innerHTML);
        var discTable1 = Number(discTable.innerHTML);
        var netTable1 = Number(netTable.innerHTML);

        discTable.innerHTML = discInput1;
        netTable.innerHTML = totTable1 - discInput1;

        console.log(discTable1+","+discInput1);
        
    }

    $('#discApply').click(function(){
        $('#loginModal').modal('hide');
    });

    $("#search_customer").click(function(e){
        e.preventDefault();
        //alert("click");
        var phone = $('#phone-number').val();
        ///alert(phone);
        $.ajax({
            type: 'POST',
            url: 'suggest-subservice2.php',
            data: {"phone": phone},
            dataType: 'JSON',
            success: function(data){
                //alert(data);
                if (data==false) {
                    customernotfound.style.display = "block";
                    customernotfoundp.style.display = "block";
                    customerfound.style.display="none";
                    return;
                }else {
                    customernotfound.style.display = "none";
                    customernotfoundp.style.display = "none";
                    customerfound.style.display="block";
                    p_text("#u_name",data.first_name);
                    p_text("#u_address",data.address);
                    p_text("#u_mobile",data.user_mobile);
                    p_text("#u_email",data.email);
                }
            }
        });
    })

    function p_text(element_id,text){
        var icon = $(element_id).find('i');
        $(element_id).text("");
        $(element_id).append(icon);
        $(element_id).append(text);
    }

    // playing around

    var i = 0;
    var netGlobal = 0;
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

                                if (data.substring(0,9)=="no option") {
                                    //alert(data);
                                    $('#users-order-type').empty();
                                    $('#users-order-type').prop( "disabled", true );
                                    $('#users-order-price').val(data.substring(9));
                                }
                                else{
                                    var i = "<option>Select Services</option>";
                                    i = i+data;
                                    $('#users-order-type').empty().append(i);
                                    $('#users-order-type').prop( "disabled", false );
                                }
                                //$('#users-order-price').val(data);
                            }
                        });
                });
            }
        });
    });

    $('#users-order-type').change(function(e){
        if($(this).val() != 'Select Category'){
            var type = $(this).val();
        }
        $.ajax({
            type: 'POST',
            url: 'suggest-subservice.php',
            data: {"type": type},
            dataType: 'html',
            success: function(data){
                $('#users-order-price').val(data);
            }
        });
    });

    $('#add-service-button').click(function (e) {
        e.preventDefault();

        //i++;
        var si=0;
        var invoiceTable = $('#tableEnd');
        var error=0;
        var errormsg;

        var serviceName = $('#users-order-services').val();
        var serviceCategory = $('#users-order-category').val();
        var serviceSubcategory = $('#users-order-subcategory').val();
        var serviceType = $('#users-order-type').val();
        var serviceTypeName = $('#users-order-type option:selected').text();
        var servicePrice = $('#users-order-price').val();
        var serviceQuantity = $('#users-order-quantity').val();
        var serviceTotalCost = servicePrice * serviceQuantity;
        netGlobal = netGlobal + serviceTotalCost;
        $('#totTable').text(netGlobal);
        /*var user_address = $('#users-address').val();
        var schedule_date = $('#schedule-date').val();
        var schedule_time = $('#users-schedule-time').val();
        var userNote = $('#users-note').val();*/
        
        if(serviceName == 'Select Service'){
            errormsg = "Please Choose a Service!!";
            error = 1;
            $("#srvs_error").html(errormsg);
        }
        
        if(serviceCategory == 'Select Category Group'){
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

        /*
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
        }*/
        
        
        if(error==0){
            // var invoicerow = '<tr id=' + i + '><th scope="row">' + i + '</th><td>' + serviceName + '</td><td>' + servicePrice + '</td><td>' + serviceQuantity + '</td><td>' + serviceTotalCost + '</td><td>' + schedule_date + '</td><td>' + schedule_time + '</td><td class="action"><a href="' + i + '"><i class="fa fa-times-circle" aria-hidden="true"></i></a></td></tr>'
            if (serviceType==null) {
                serviceTypeName = "no option";
            }

            var invoicerow = '<tr><td>'+serviceName+'</td><td>'+ serviceTypeName+'</td><td>'+serviceQuantity +'</td><td class="text-right">' +servicePrice 
                 +'</td><td class="text-right">'+serviceTotalCost+'</td></tr>';

            serviceObj.push({
                serviceID: constantServiceID,
                servicename: serviceName,
                servicecategory: serviceCategory,
                servicesubcategory: serviceSubcategory,
                serviceprice: servicePrice,
                servicequantity: serviceQuantity,
                servicetotal: serviceTotalCost,
                // schedule_address: user_address,
                // schdule_date: schedule_date,
                // schedule_time: schedule_time,
                //note: userNote
            });

            console.log(serviceObj);

            invoiceTable.before(invoicerow);
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
        else {
            document.getElementById("num_error").style.display="none";
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
                    //url: 'add-order.php',
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