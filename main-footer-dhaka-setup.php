<!-- / get in touch-->
        <!--Site Footer-->
        <section id="footer">
            <div class="footer-contain">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <div class="help_section">
                                <h3>Help</h3>
                                <ul class="list-unstyled">
                                    <li><a href="#">FAQs</a></li>
                                    <li><a href="#">Payment</a></li>
                                    <li><a href="#">Service</a></li>
                                    <li><a href="#">Report</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="other_menu_section">
                                <h3>Dhakasetup.com</h3>
                                <ul class="list-unstyled">
                                    <li><a href="#">About</a></li>
                                    <li><a href="#">Career</a></li>
                                    <li><a href="#">Become Service partner</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="social_section">
                                <h3>Social</h3>
                                <ul class="list-unstyled list-inline">
                                    <li><a href="https://www.facebook.com/DhakaSetup/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google plus" aria-hidden="true"></i></a></li>
                                    <li><a href="https://www.linkedin.com/company-beta/15237636" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="company_info">
                                <h3>Contact</h3>
                                <ul>
                                    <li>Mirpur Dhaka - 1216</li>
                                    <li>Email: @dhakasetup.com</li>
                                    <li>Call: +880-1670-894117</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-footer">
                <p>all right reserved &copy;2017 copyright</p>
            </div>
        </section>
        <!-- / Site Footer-->
        <!-- jQuery -->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="owl-carousel/owl.carousel.min.js"></script>
        <script type="text/javascript" src="js/datepicker.js"></script>
        <script type="text/javascript" src="js/validator.min.js"></script>
        <script type="text/javascript" src="js/cookie.js"></script>
        <script src="https://sdk.accountkit.com/en_EN/sdk.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
<script>
    $(document).ready(function () {
        var add_running = true;
        $('#schedule').datepicker({
            format: "dd-mm-yyyy",
            autoclose:true
        });
        $('#user-sch-date').datepicker({
            format: "dd-mm-yyyy",
            autoclose:true
        });
        $('.redirect').click(function (e) {
            e.prevenDefault();
            var address = $('.redirect').attr('href');
            window.location.href = address;
        });


        $("body").on('click', '.confirm-cart', function (e){
            e.preventDefault();
            var count = parseInt($('.aa-cart-notify').text(),10);
            var product_count = count;
            var id = $(this).val();
            var quantity = $('#quantity').val();
            var schedule_address = $('#user-sch-addrs').val();
            var schedule_date = $('#user-sch-date').val();
            var schedule_time = $('#users-sch-time').val();
            var userNote = $('#users-note').val();
            if(quantity != '' && schedule_address != '' && schedule_date != '' & schedule_time != ''){
                if(add_running == true){
                    if(!($.cookie('item_on_cart') == null)){
                        var item = jQuery.parseJSON($.cookie('item_on_cart'));
                        var i;
                        product_count++;
                        $.each( item, function( key, value ) {
                            $.each(value, function(key1,value1){
                                if(value1 == id){
                                    product_count = count;
                                }
                            });
                        });
                    }

                    else{
                        product_count=1;
                    }
                    $.ajax({
                        type: 'POST',
                        url: 'Ajaxcart.php',
                        data: {
                            "id": id,
                            "quantity": quantity,
                            "address": schedule_address,
                            "date" : schedule_date,
                            "time" : schedule_time,
                            "note" : userNote
                        },
                        dataType: 'html',
                        beforeSend: function(){
                            add_running = false;
                        },
                        success: function (data) {
                            $('.aa-cartbox-summary>ul').append(data);
                            $('#empty').hide();
                        },
                        complete: function(XMLHttpRequest, status){
                            $('#place_button').show();
                            $('.aa-cart-notify').text(product_count);
                            $('#quantity').val(1);
                            $('#user-sch-addrs').val('');
                            $('#user-sch-date').val('');
                            $('#users-note').val('');
                            $('#users-sch-time').prop('selectedIndex', 0);
                            $('#cartModal').modal('hide')
                            add_running=true;
                        }
                    });
                }

            }
            else{
                alert("ALL FIELDS ARE REQUIRED");
            }
        });
        $(".aa-cartbox-summary").on('click', '.aa-remove-product', function (e){
            e.preventDefault();
            var product_count = parseInt($('.aa-cart-notify').text(),10);
            var id = $(this).attr('ref');
            $.ajax({
                type: 'POST',
                url: 'Ajaxcart.php',
                data: {
                    "remove_id": id
                },
                dataType: 'html'
            });
            if(product_count>0){
                product_count--;
            }
            $('.aa-cart-notify').text(product_count);
            $(this).parent().remove();
            if($(".aa-cartbox-summary ul li").size()<1){
                $('#place_button').hide();
                $('#empty').show();
            }
        });
//
//        $('.add-to-cart').click(function (e) {
//            e.preventDefault();
//            if(add_running == true){
//                var count = parseInt($('.aa-cart-notify').text(),10);
//                var product_count = count;
//                var id = $(this).val();
//                if(!($.cookie('item_on_cart') == null)){
//                    var item = jQuery.parseJSON($.cookie('item_on_cart'));
//                    var i;
//                    product_count++;
//                    $.each( item, function( key, value ) {
//                        $.each(value, function(key1,value1){
//                            if(value1 == id){
//                                product_count = count;
//                            }
//                        });
//		    });
//                }
//                
//                else{
//                    product_count=1;
//                }
//                var quantity = $('.quantity').val();
//                $.ajax({
//                    type: 'POST',
//                    url: 'Ajaxcart.php',
//                    data: {
//                        "id": id,
//                        "quantity": quantity
//                    },
//                    dataType: 'html',
//                    beforeSend: function () {
//                        add_running = false;
//                    },
//                    success: function (data) {
//                        $('.aa-cartbox-summary>ul').append(data);
//                        $('#empty').hide();
//                    },
//                    complete: function(XMLHttpRequest, status){
//                        $('#place_button').show();
//                        $('.aa-cart-notify').text(product_count);
//                        add_running = true;
//                    }
//                });
//            }
//        });

        $(".aa-cartbox-summary").on('click', '.cart-item', function (e){
            e.preventDefault();

        });
        
        $('.aa-cartbox-summary').click(function (e) {
            e.stopPropagation();
        });

        $(".index-default").click(function () {
            $.ajax({
                type: 'POST',
                url: 'index-service.php',
                data: {
                    "index-default": true
                },
                dataType: 'html',
                success: function (data) {
                    $('.right-panel').html(data);
                },
                error: function (XMLHttpRequest, status, error) {
                    $('.right-panel').html(data);
                }
            });
        });
        
        $('.remove').click(function (e){
            e.preventDefault();
            var product_count = parseInt($('.aa-cart-notify').text(),10);
            var id = $(this).attr('href');
            $.ajax({
                type: 'POST',
                url: 'Ajaxcart.php',
                data: {
                    "remove_id": id
                },
                dataType: 'html'
            });
            if(product_count>0){
                product_count--;
            }
            $('.aa-cart-notify').text(product_count);
            $(this).parent().parent().remove();
            $(".aa-cartbox-summary ul").find('#'+id).remove();
            if($(".aa-cartbox-summary ul li").size()<1){
                $('#place_button').hide();
                $('#empty').show();
            }

            if($('.cart-info table tbody tr').size()<3){
                $('.cart-info table tbody').hide();
                $('.gray').hide();
                $('#goback').show();
            }
        });

        $('.quantity').change(function () {
            var quantity = $(this).val();
            var id = $(this).attr('id');
            var totalCost = ($(this).parent().parent().find('#totalCost'));
            var wholeTotal = ($('.whole_total'));
            var price = $(this).parent().parent().find('#price').text();
            var cart= $('.aa-cartbox-summary').find('#'+id);
                $.ajax({
                    type: 'POST',
                    url: 'Ajaxcart.php',
                    data: {
                        "update_id": id,
                        "quantity":quantity,
                        "price":price
                    },
                    dataType: 'json',
                    beforeSend: function(){
                        add_running = false;
                    },
                    success: function (data) {
                        totalCost.text(data.total);
                        wholeTotal.text(data.whole_total);
                    },
                    complete: function(XMLHttpRequest, status){
                        add_running=true;
                    }
                });
        });

        $('.update-button').click(function () {
            $('.update-cart').val($(this).attr('href'));
            var oldAddress = $(this).parent().parent().find('#address').text();
            var oldDate = $(this).parent().parent().find('#date').text();
            var oldTime = $(this).parent().parent().find('#time').text();
            var oldNote= $(this).parent().parent().find('#note').val();

            $('#user-sch-date').val(oldDate);
            $('#users-sch-time').val(oldTime);
            $('#user-sch-addrs').val(oldAddress);
            $('#users-note').val(oldNote);
        });
        
        $('.update-cart').click(function (e) {
            e.preventDefault();
            var id = $(this).val();
            var newAddress = $('#user-sch-addrs').val();
            var newDate = $('#user-sch-date').val();
            var newTime = $('#users-sch-time').val();
            var newNote = $('#users-note').val();

            if(add_running == true){
                $('#cart-table').find('#'+id).find('#address').text(newAddress);
                $('#cart-table').find('#'+id).find('#date').text(newDate);
                $('#cart-table').find('#'+id).find('#time').text(newTime);
                $('#cart-table').find('#'+id).find('#note').val(newNote);

                $.ajax({
                    type: 'POST',
                    url: 'Ajaxcart.php',
                    data: {
                        'update_cart_id': id,
                        'newAddress': newAddress,
                        'newDate': newDate,
                        'newTime': newTime,
                        'newNote' : newNote
                    },
                    dataType: 'html',
                    success: function (data) {
                        console.log(data);
                    }
                });
            }

            $('#editcartModal').modal('hide');
        });

        $('#booknow').click(function (e) {
            var order = true;
            $.ajax({
                type: 'POST',
                url: 'Ajaxcart.php',
                data: {
                    "final_order": order
                },
                success: function (data) {
                    $('#cartModal .modal-body .mobile_number').html(data);
                    console.log(data);
                }
            });
        });
        
        $('.loginmodal').click(function(e){
        	e.preventDefault();
        	$('.login').modal("show");
        });
    });
</script>

<script>
    // initialize Account Kit with CSRF protection
    AccountKit_OnInteractive = function () {
        AccountKit.init(
            {
                appId: 771765302988032,
                state: "abcd123",
                version: "v1.0"
            }
            //If your Account Kit configuration requires app_secret, you have to include ir above
        );
    };
    // login callback
    function loginCallback(response) {
        console.log(response);
        if (response.status === "PARTIALLY_AUTHENTICATED") {
            document.getElementById("code").value = response.code;
            document.getElementById("csrf_nonce").value = response.state;
            document.getElementById("mobile_login").submit();
        }
        else if (response.status === "NOT_AUTHENTICATED") {
            // handle authentication failure
            console.log("Authentication failure");
        }
        else if (response.status === "BAD_PARAMS") {
            // handle bad parameters
            console.log("Bad parameters");
        }
    }
    // phone form submission handler
    function phone_btn_onclick() {
        // you can add countryCode and phoneNumber to set values
        AccountKit.login('PHONE', {}, // will use default values if this is not specified
            loginCallback);
    }
</script>