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
?>

            <?php

            require_once 'includes/dashboard-header.php';

            ?>

            <div class="right_col" role="main">
                <div class="">

                    <div class="clearfix"></div>



                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12 top-overview">
                            <div class="x_panel">
                                <div class="x_content">
                                    <br />
                                    <div class="col-md-4">
                                        <div class="col-md-4">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-8">
                                            <h2><span>TOTAL ORDERS</span>2038</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-4">
                                            <i class="fa fa-briefcase" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-8">
                                            <h2><span>TOTAL JOBS</span>2038</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-4">
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-8">
                                            <h2><span>TOTAL MEMBERS</span>2038</h2>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="x_panel">
                                <div class="x_content">
                                    <br />

                                    <table class="table table-bordered table-striped overview-details">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Today</th>
                                                <th>This Month</th>
                                                <th>This Year</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="dashboard-category">Total Order</td>
                                                <td>180</td>
                                                <td>3</td>
                                                <td>360</td>
                                                <td>520</td>
                                            </tr>
                                            <tr>
                                                <td class="dashboard-category">Open Order</td>
                                                <td>180</td>
                                                <td>3</td>
                                                <td>360</td>
                                                <td>520</td>
                                            </tr>
                                            <tr>
                                                <td class="dashboard-category">Process Order</td>
                                                <td>180</td>
                                                <td>3</td>
                                                <td>360</td>
                                                <td>520</td>
                                            </tr>
                                            <tr>
                                                <td class="dashboard-category">Closed Order</td>
                                                <td>180</td>
                                                <td>3</td>
                                                <td>360</td>
                                                <td>520</td>
                                            </tr>
                                            <tr>
                                                <td class="dashboard-category">Cancel Order</td>
                                                <td>180</td>
                                                <td>3</td>
                                                <td>360</td>
                                                <td>520</td>
                                            </tr>
                                            <tr>
                                                <td class="dashboard-category">Total Bill</td>
                                                <td>180</td>
                                                <td>3</td>
                                                <td>360</td>
                                                <td>520</td>
                                            </tr>

                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div> 
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="x_panel" id="weather-widget">
                                <div class="time-box">
                                    <div id="date">2 December, 2016</div>
                                    <div id="Time">1:00 PM</div>
                                </div>
                                <div class="weather-box">
                                    <h5 id="location">Dhaka, Bangladesh</h5>
                                    <div id="weathImage"><img src="images/cloudy.png" class="img-responsive" /></div>
                                    <div class="col-md-6">
                                        <h1><span id="temp">23&deg;</span> c</h1>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 id="weathtext">Partly Cloudy</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <?php

                require_once 'includes/dashboard-footer.php';

                ?>

    <script>
        var country = geoplugin_countryName();
        var zone = geoplugin_region();
        var district = geoplugin_city();
        console.log("Your location is: " + country + ", " + zone + ", " + district);
    </script>

    <script>
        var country = geoplugin_countryName();
        loadWeather(district, '');

        function loadWeather(location, woeid) {
            $.simpleWeather({
                location: location,
                woeid: woeid,
                unit: 'c',
                success: function (weather) {
                    if (weather.code == 30 || weather.code == 29 || weather.code == 44) {
                        var img = '<img src="images/cloud.png" class="img-responsive" alt="">';
                    }
                    if (weather.code == 27 || weather.code == 28) {
                        var img = '<img src="images/cloudy.png" class="img-responsive" alt="">';
                    }
                    if (weather.code == 32) {
                        var img = '<img src="images/sun.png" class="img-responsive" alt="">';
                    }
                    if (weather.code == 4) {
                        var img = '<img src="images/thunderstorm-pronostic.png" class="img-responsive" alt="">';
                    }
                    if (weather.code == 11 || weather.code == 12) {
                        var img = '<img src="images/rain.png" class="img-responsive" alt="">';
                    }
                    console.log(weather.code + ',' + weather.temp + ',' + weather.units.temp + ',' + weather.city + ',' + weather.todayCode);
                    $(".weather-box #location").html(weather.city + ', ' + weather.country);
                    $(".weather-box #temp").html(weather.temp + '&deg;');
                    $(".weather-box #weathtext").html(weather.text);
                    $(".weather-box #weathImage").html(img);
                },
                error: function (error) {
                    $("#weather").html('<p>' + error + '</p>');
                }
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            function renderTime() {
                var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
                var month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
                var currentTime = new Date();
                var hour = currentTime.getHours();
                var minutes = currentTime.getMinutes();
                var currentmonth = month[currentTime.getMonth()];
                var currentday = weekday[currentTime.getDay()];
                var currentdate = currentTime.getDate();
                var seconds = currentTime.getSeconds();
                var amOrpm = "AM";

                if (hour > 12) {
                    hour = hour - 12;
                    amOrpm = "PM";
                } else if (hour == 0) {
                    hour = 12;
                }

                if (hour < 10) {
                    hour = "0" + hour;
                }

                if (minutes < 10) {
                    minutes = "0" + minutes;
                }

                var myclock = '<h1>' + hour + ':' + minutes + '<span> ' + amOrpm + '</span></h1>';
                var mycalender = '<h4>'+ currentday + '<br>' + currentdate + ' ' + currentmonth + ', ' + currentTime.getFullYear() + '</h4>';
                $(".time-box #date").html(mycalender);
                $(".time-box #Time").html(myclock);
                setTimeout(renderTime, 1000);
            }
            renderTime();
        });
    </script>


</body>

</html>