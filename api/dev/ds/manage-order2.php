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

        	<div class="page-title">
                <div class="title_left">
                    <h3>Order Management</h3>
                </div>

                <div class="title_right">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

            	<!-- order info -->
            	
            	<div class="col-md-3">
            		<div class="x_panel">
            			<div class="x_title">
            				<i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-user"></i>
            				<h2>Order Info</h2>
            				<button type="button" class="btn btn-default btn-sm pull-right" id="refresh">
							   <span style="color: grey" class="glyphicon glyphicon-option-vertical"></span>
							</button>
            				<div class="clearfix"></div>
            			</div>
            			<div class="x_body">
            				<p><b>Order ID:</b> <span style="padding-left: 5px;" id=""> b1002 </span></p>
            				<p><b>Sales Channel:</b> <span style="padding-left: 5px;" id=""> B2B </span></p>
            				<p><b>Service Category:</b> <span style="padding-left: 5px;" id=""> Building Maintenance	 </span></p>
            				<p><b>Created at:</b> <span style="padding-left: 5px;" id=""> 15 july 2018 </span></p>
            				<p><b>Starting Date:</b> <span style="padding-left: 5px;" id=""> 16 july 2018 </span></p>
            				<p><b>Served Date:</b> <span style="padding-left: 5px;" id=""> 17 july 2018 </span></p>
            				<p><b>Closed Date:</b> <span style="padding-left: 5px;" id=""> 18 july 2018 </span></p>
            			</div>
            		</div>
            	</div>

            	<!-- customer info -->

            	<div class="col-md-3">
            		<div class="x_panel">
            			<div class="x_title">
            				<i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-user"></i>
            				<h2>Order Info</h2>
            				 <div class="dropdown">
							  <button style="" type="button" class="btn btn-default btn-sm pull-right 
            						dropdown-toggle" data-toggle="dropdown">
							   <span style="color: grey" class="glyphicon glyphicon-option-vertical"></span>
								</button>
							  <ul class="dropdown-menu" style="margin-top: 32px; margin-left: 32px;">
							    <li><a href="#" data-toggle="modal" data-target="#customerModal">Edit Customer Detail</a></li>
							  </ul>
							</div>
            				<div class="clearfix"></div>
            			</div>
            			<div class="x_body">
            				<p><b>Company Name:</b> <span style="padding-left: 5px;" id=""> Sheba </span></p>
            				<p><b>Phone Number:</b> <span style="padding-left: 5px;" id=""> 01715431645 </span></p>
            				<p><b>Contact Person:</b> <span style="padding-left: 5px;" id=""> Firoze Ahmed	 </span></p>
            				<p><b>Phone Number:</b> <span style="padding-left: 5px;" id=""> 01715436525 </span></p>
            				<p><b>Email:</b> <span style="padding-left: 5px;" id=""> firoze@sheba.xyz </span></p>
            				<p><b>Location:</b> <span style="padding-left: 5px;" id=""> Mohammadpur, Dhaka </span></p>
            				<p><b>Address:</b> <span style="padding-left: 5px;" id=""> House #15/B, Block #C, Tajmahal Road,Mohammadpur, Dhaka-1205 </span></p>
            			</div>
            		</div>
            	</div>

            	<!-- Vendor info -->

            	<div class="col-md-3">
            		<div class="x_panel">
            			<div class="x_title">
            				<i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-user"></i>
            				<h2>Vendor Info</h2>

							<div class="dropdown">
							  <button style="" type="button" class="btn btn-default btn-sm pull-right 
            						dropdown-toggle" data-toggle="dropdown">
							   <span style="color: grey" class="glyphicon glyphicon-option-vertical"></span>
								</button>
							  <ul class="dropdown-menu" style="margin-top: 32px; margin-left: 32px;">
							    <li><a href="#" data-toggle="modal" data-target="#vendorModal">Add Vendor</a></li>
							  </ul>
							</div>

            				<div class="clearfix"></div>
            			</div>
            			<div class="x_body">
            			
            				<p><b>Name:</b> <span style="padding-left: 5px;" id=""> Alom enterprise </span></p>
            				<p><b>Type:</b> <span style="padding-left: 5px;" id=""> Board Supplier </span></p>
            				<p><b>Phone:</b> <span style="padding-left: 5px;" id=""> 01741258963	 </span></p>
            				<hr style="width: 100%; margin-top: -2px; margin-bottom: 5px ; color: #D3D3D3; height: 1px; background-color:grey;" />
            				<p><b>Name:</b> <span style="padding-left: 5px;" id=""> Kawser </span></p>
            				<p><b>Type:</b> <span style="padding-left: 5px;" id=""> Carpenter </span></p>
            				<p><b>Phone:</b> <span style="padding-left: 5px;" id=""> 01524852369	 </span></p>
            				<hr style="width: 100%; margin-top: -2px; margin-bottom: 5px ; color: #D3D3D3; height: 1px; background-color:grey;" />
            				<p><b>Name:</b> <span style="padding-left: 5px;" id=""> Kawser </span></p>
            				<p><b>Type:</b> <span style="padding-left: 5px;" id=""> Carpenter </span></p>
            				<p><b>Phone:</b> <span style="padding-left: 5px;" id=""> 01524852369	 </span></p>
            			</div>
            		</div>
            	</div>

            	<!-- Other info -->

            	<div class="col-md-3">
            		<div class="x_panel">
            			<div class="x_title">
            				<i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-user"></i>
            				<h2>Other Info</h2>
            				
            				<div class="dropdown">
							  <button style="" type="button" class="btn btn-default btn-sm pull-right 
            						dropdown-toggle" data-toggle="dropdown">
							   <span style="color: grey" class="glyphicon glyphicon-option-vertical"></span>
								</button>
							  <ul class="dropdown-menu" style="margin-top: 32px; margin-left: 32px;">
							    <li><a href="#" data-toggle="modal" data-target="#assigneeModal">
								    <span style="color: grey" class="glyphicon glyphicon-user"></span>
								    Assignee supervisor
									</a>
								</li>
								<li><a href="#" data-toggle="modal" data-target="#warrentyModal">
								    Set Warrenty
									</a>
								</li>
							  </ul>
							</div>

            				<div class="clearfix"></div>
            			</div>
            			<div class="x_body">
            			</br>
            				<p><b>Assignee:</b> <span style="padding-left: 5px;" id=""> MD. Rubel Hossain </span></p>
            				<p><b>Assignee:</b> <span style="padding-left: 5px;" id=""> MD. Jalal Amin </span></p>
            				<p><b>Created By:</b> <span style="padding-left: 5px;" id=""> Shakil </span></p>
            				<p><b>Warrenty:</b> <span style="padding-left: 5px;" id=""> 180 days of 1 year </span></p>
            			</div>
            		</div>
            	</div>


<!-- Customer Modal -->

<div class="modal fade" id="customerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Customer Info</h4>
            </div>
            <div class="modal-body">
				<form class="form-horizontal" action="/action_page.php">
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="company">Company Name:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="company">
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="phone_company">Phone Number:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="phone_company">
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="person">Contact Person:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="person">
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="phone_person"> Phone Number:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="phone_person">
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="email"> Email:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="email">
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="location">Location:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="location">
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="address"> Address:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="address">
				    </div>
				  </div>
				</form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="discApply">Update</button>
                <button class="btn btn-danger" data-dismiss="modal">close</button>
            </div>
        </div>
    </div>
</div>

<!-- Vendor Modal -->

<div class="modal fade" id="vendorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add vendor</h4>
            </div>
            <div class="modal-body">
				<form class="form-horizontal" action="/action_page.php">
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="vendorName">Vendor Name:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vendorName">
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="vendorNType">Vendor Type:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vendorType">
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="phone_vendor">Phone Number:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="phone_vendor">
				    </div>
				  </div>
				</form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="discApply">Add</button>
                <button class="btn btn-danger" data-dismiss="modal">close</button>
            </div>
        </div>
    </div>
</div>

<!-- Assignee Modal -->

<div class="modal fade" id="assigneeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add assignee</h4>
            </div>
            <div class="modal-body">
				<form class="form-horizontal" action="/action_page.php">
				  <div class="form-group">
				    <label for="assigneeSelect">Select Assignee:</label>
				      <select class="form-control" id="assigneeSelect">
				        <option>Md. Rubel Hussan</option>
				        <option>Rahim</option>
				        <option>Karim</option>
				        <option>Jalal</option>
				      </select>
				  </div>
				</form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="discApply">Add</button>
                <button class="btn btn-danger" data-dismiss="modal">close</button>
            </div>
        </div>
    </div>
</div>

<!-- Warrenty Modal -->

<div class="modal fade" id="warrentyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Set Warrenty</h4>
            </div>
            <div class="modal-body">
				<form class="form-horizontal" action="/action_page.php">
				  <div class="form-group">
				    <label class="control-label col-sm-3" for="vendorName">Warrenty Period:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vendorName">
				    </div>
				  </div>
				</form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="discApply">Set</button>
                <button class="btn btn-danger" data-dismiss="modal">close</button>
            </div>
        </div>
    </div>
</div>


        	</div>

        	<div class="row">
        		 <!--Order form
        ==============-->
            <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <i style="float: left; font-size: 20px; color: #000; padding-top: 5px; margin-right: 5px;" class="fa fa-file-text"></i>
                            <h2>Bill Info <span class="badge" style="color: white; background-color: red;margin-left: 10px;">Due</span> </h2>


                             <div class="dropdown pull-right">
							  <button style="" type="button" class="btn btn-default btn-sm pull-right 
            						dropdown-toggle" data-toggle="dropdown">
							   <span style="color: grey" class="glyphicon glyphicon-option-vertical"></span>
								</button>
							  <ul class="dropdown-menu" style="">
							    <li><a href="#" data-toggle="modal" data-target="#warrentyModal">
								    Download Bill
									</a>
								</li>
								<li><a href="#" data-toggle="modal" data-target="#warrentyModal">
								    Download Qoutation
									</a>
								</li>
								<li><a href="#" data-toggle="modal" data-target="#warrentyModal">
								    Adjust Cost
									</a>
								</li>
								<li><a href="#" data-toggle="modal" data-target="#warrentyModal">
								    Edit Information
									</a>
								</li>
								<li><a href="#" data-toggle="modal" data-target="#warrentyModal">
								    Add promo code
									</a>
								</li>
								<li><a href="#" data-toggle="modal" data-target="#warrentyModal">
								    Adjust Discount
									</a>
								</li>
							  </ul>
							</div> 

                            <a href="#" data-toggle="modal" data-target="#warrentyModal" class="btn-sm btn btn-primary pull-right">Add service +</a>
                            <a href="#" data-toggle="modal" data-target="#warrentyModal" class="btn-sm btn btn-primary pull-right">Additional</a>
                                        <div class="clearfix"></div>

                        </div>

                        <div class="x_content">
                            <br />
                             
                             

                    <div class=" row">
                    	<table id="billTable" class="table table-hover table-bordered">
                        <thead>
                            <tr style="background: #E8E8E8;">
                                <th class="col-md-3"> <i class="fa fa-cogs" style="margin-right: 2px;"></i> Service</th>
                                <th class="col-md-2"> <i class="fa fa-plus-square" style="margin-right: 2px;"></i> Options</th>
                                <th class="col-md-3"> <i class="fa fa-plus-square" style="margin-right: 2px;"></i> Description</th>
                                <th class="col-md-1"> <i class="fa fa-list-ol" style="margin-right: 2px;"></i> Qty</th>
                                <th class="col-md-1"> <i class="fa fa-usd" style="margin-right: 2px;"></i> Unit</th>
                                <th class="col-md-1"> <i class="fa fa-usd" style="margin-right: 2px;"></i> Total</th>
                                <th class="col-md-1"> <i class="fa fa-edit" style="margin-right: 2px;"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        	<tr>
                                <td>Ac service</th>
                                <td>1 ton, window</th>
                                <td>Sample Description</td>
                                <td>2</th>
                                <td class="text-right">1000</th>
                                <td class="text-right">2000</th>
                                <td class="text-center">
                                	<a class="btn btn-xs btn-primary">Edit </a>
                                	<a class="btn btn-xs btn-danger">Delete </a>
                                </td>
                            </tr>

                            <tr>
                                <td>Ac service</th>
                                <td>2 ton, split</th>
                                <td>Sample Description</td>
                                <td>2</th>
                                <td class="text-right">1500</th>
                                <td class="text-right">3000</th>
                                <td class="text-center">
                                	<a class="btn btn-xs btn-primary">Edit </a>
                                	<a class="btn btn-xs btn-danger">Delete </a>
                                </td>
                            </tr>
        
                        </tbody>
                    </table>
                    </div>

                    <div class="row">
		            	<div class="col-md-4">
		            		 <ul class="list-group" style="margin-left: -10px;">
							  <li class="list-group-item" >Material Purchase <span class="pull-right" >1000</span></li>
							  <li class="list-group-item">Labour bill <span class="pull-right">1500</span></li>
							  <li class="list-group-item">Transportation <span class="pull-right">500</span></li>
							  <li class="list-group-item">Other cost <span class="pull-right">500</span></li>
							  <li class="list-group-item" >Total cost <span class="pull-right">3500</span></li>
							</ul> 
		            	</div>
		            	<div class="col-md-4">
		            		<ul class="list-group">
							  <li class="list-group-item" style="">Total Cost <span class="pull-right" >3500</span></li>
							  <li class="list-group-item">Gross profit <span class="pull-right">500</span></li>
							</ul> 
							<div class="text-center" style="margin-top: 50px;">
								<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#warrentyModal">Adjust Collection</a>
							</div>
		            	</div>
		            	<div class="col-md-4">
		            		<ul class="list-group" style="margin-left: -10px;">
							  <li class="list-group-item" >Total bill <span class="pull-right" >1000</span></li>
							  <li class="list-group-item">Promo/Discount <span class="pull-right">1500</span></li>
							  <li class="list-group-item">Net bill <span class="pull-right">500</span></li>
							  <li class="list-group-item">Paid <span class="pull-right">500</span></li>
							  <li class="list-group-item" >Due<span class="pull-right">3500</span></li>
							</ul> 

			            </div>
			        </div>

                        </div>
                    </div>
                </div>


                
            </div>


            

            </div>
        	</div>
            	

            	

         </div>
    </div>



    <?php

        require_once 'includes/dashboard-footer.php';

        ?>