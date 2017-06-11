<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Presentation Page for Chris Gish'd prjProcess.">
    <meta name="robots" content="noindex, nofollow">

    <title>Chris Gish's Index Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- index.php - Week 4 Individual Project Index page
    Written by: Chris Gish 06/06/2017       gishc@csp.edu
    Revised:

    -->

    <!--Bootstrap Screen Resolutions:
lg - Large width      retina    1200px+
md - medium width     desktop    992px+
sm - small width      tablets    768px+
xs - xtra small       mobile       0px+  -->
    <?php

    /* Server Sniffer Snippet -
               Is this page running on the localhost or the remote server?
      http://stackoverflow.com/questions/2053245/
               how-can-i-detect-if-the-user-is-on-localhost-in-php
     */
    $whitelist = array('127.0.0.1','::1');
    //echo "DEBUG \$_SERVER['REMOTE_ADDR'] is: "
    //   . $_SERVER['REMOTE_ADDR'] . '<br>';
    //echo  print_r($_POST);//DEBUG

    if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
        // Credentials for localhost (Using AMPPS)
        define('DBF_SERVER', 'localhost');
        define('DBF_NAME', 'employeeScheduleApp');
        define('DBF_USER', 'root');
        define('DBF_PASSWORD', 'mysql');
    }
    else
    {
        // credentials for BYET server
        // Fill in your server information
        define('DBF_SERVER', 'sql105.byethost7.com');
        define('DBF_NAME', 'b7_19791672_awesomeStuff');
        define('DBF_USER', 'b7_19791672');
        define('DBF_PASSWORD', 'Leerockwell81610!');
    }

    //Links external PHP library file
    require_once("libPHP.php");

    ?>
</head>
<body>
<!--_________________________________________NavBar________-->
<div class='navbar navbar-default navbar-fixed-top '>
    <div class='container'>
        <span class='sr-only'><a href="#skip">Skip Navigation</a></span>
        <div class='navbar-header'>
            <img src="graphic/myPortait.jpg" alt="A portrait of Christopher Gish" id="CGPic" class="img-responsive"/>
            <a href="/" class='navbar-brand'>Employee Scheduling Application<br></a>
            <!-- create button for hamburger icon -->
            <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
                <!-- Add the hamburger icon -->
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
            </button>
        </div>            <!-- .navbar-header -->
        <ul class='nav navbar-nav navbar-right collapse navbar-collapse'>
            <?PHP include 'nav.php' ?>
        </ul>
    </div>      <!-- /container -->
</div><!-- ________________________________________/NavBar__ -->


<!--  __________________________________  ContentContainer  __  -->
<div class="container">

    <!--____________________________________Start of Row1____-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <br /><br /><br/>
            <h1>Home Page</h1>
            <p>
                <?php
                //print_r($_POST);
                //print_r($_SERVER)
                ?>
            </p>
        </div>
    </div><!--_______________________________/Row1____________-->


    <!--  ______________________________  Start of Row2_______    -->
    <div class="row">
        <!--___________________________________Start Col1______-->
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-12">
             <div class="well">
                 <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>"
                            method="post"
                            id="eeScheduleSelection"
                            name="eeScheduleSelection">
                 <div class="form-group">
                     <label for="eeSelection">Select Employee</label>
                     <select class="form-control"
                                  id="rdoSelectEE"
                                  name="rdoSelectEE">
                         <?PHP
                         global $sql;

                         $db = new mysqli(DBF_SERVER, DBF_USER, DBF_PASSWORD, DBF_NAME);
                         if ($db->connect_errno > 0) {
                             die('unable to connect to database [' . $db->connect_error . ']');
                         }
                         // Loop through the table to build the <option> list
                         $sql = "SELECT eeNumber, fName, lName  FROM eeName ORDER BY lName";
                         $result = $db->query($sql);
                         while($row = $result->fetch_assoc()) {
                             echo "<option value=" . $row[eeNumber] . ">" . $row["eeNumber"] . " "
                                 . $row["fName"] . " " . $row["lName"]
                                 . "</option>";
                         }
                         ?>
                     </select><br />
                     <label for="mthSelect">Select Month/Year</label><br />
                     <input type="month"
                            name="mthSelect"
                            id="mthSelect"
                            value="">
                     <button type="submit" class="btn btn-info" id="btnViewSchedule">View My
                         Schedule</button>
                 </div>
                 </form>
             </div>
        </div><!--____________________________/Col1____________-->


    </div><!--________________________________/Row2_________-->


<!--  ________________________________  Start of Row3_______    -->

    <div class="row">
        <!--___________________________________Start Col1______-->
     <div class="col-xs-12 col-sm-12 col-md-3 col-lg-12">
         <div class="well">
             <?php
                displaySchedule();
             ?>


         </div>
     </div><!--____________________________/Col1____________-->




    <!--  ________________________________  Start of Row4_______    -->

    <div class="row">
        <!--___________________________________Start Col1______-->
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        </div><!--____________________________/Col1____________-->
        <!--___________________________________Start Col2______-->
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        </div><!--______________________________/Col2_________-->
        <!--___________________________________Start Col3______-->
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        </div><!--____________________________/Col3____________-->
        <!--___________________________________Start Col4______-->
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <button type="button" class="btn btn-default" onclick="printPage()">Print This Page</button>
        </div><!--____________________________/Col4____________-->
    </div><!--  _____________________________/Row4_____________-->

</div><!--______________________________/ContentContainer____-->
<!--_____________________________________________________________________________PAGE-FOOTER_____________________________________-->
<div class="container">
    <footer class="footer">
        <div class="container text-left navbar-bottom">
            <cite>Created by Chris Gish,  gishc@csp.edu</cite>
        </div>
    </footer>
</div>


<!--____________________________________________________________________________________________Load-CDN-Libraries________________________________-->
<!-- (1) jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<!-- (2) Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- (3) Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<!-- (4) Bring in local JavaScript functions -->
<!--<script src="script.js"></script>-->
<script>
    function printPage ( ) {
        window.print();
    }
</script>
<!-- (5) Connect to local CSS for this site -->
<link rel="stylesheet" type="text/css" href="style.css">

</body>
</html>
