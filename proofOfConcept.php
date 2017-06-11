<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Presentation Page for Chris Gish'd prjProcess.">
    <meta name="robots" content="noindex, nofollow">

    <title>Chris Gish's Proof Of Concept Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- proofOfConcept.php - Week 4 Individual Project Proof of concept page
    Written by: Chris Gish 06/06/2017       gishc@csp.edu
    Revised:

    -->
    <style>

        #proofResult  {
            text-align: center;
            padding: 1em;
        }
    </style>

    <?php

    /* Server Sniffer Snippet
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
<br />
    <!--____________________________________Start of Row1____-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <br /><br /><br/>
            <h1>Proof of Concept</h1>
        </div>
    </div><!--_______________________________/Row1____________-->


    <!--  ______________________________  Start of Row2_______    -->
    <div class="row">
        <!--___________________________________Start Col1______-->
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-">
            <div class="well"><h2><small>Build Test Database</small></h2>

                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>"
                      method="post"
                      name="frmCreateDB"
                      id="frmCreateDB"
                      <fieldset id="proofCreateDB">
                            <label for="create">Create/Reset Database</label>
                            <input type="radio"
                                   title="Create Database"
                                   name="optRadio"
                                   id="optCreate"
                                   value="create" checked><br>

                            <label for="display">Display Current Schedule</label>
                            <input type="radio"
                                   title="Display Tables"
                                   name="optRadio"
                                   id="optDisplay"
                                   value="display"
                                   checked="checked" ><br><br>

                            <input type="submit"
                                   name="btnSubmit"
                                   class="btn btn-primary"
                                   value="Start!">
                            </fieldset>
             <!--   <button type="button" class="btn btn-default">Create Database</button><br />  -->
                </form>


            </div>
        </div><!--____________________________/Col1____________-->

        <!--___________________________________Start Co#2______-->
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-9">
            <div class="well" id="proofResult"><h2><small>Database Results:</small></h2><br />
            <?php

            switch($_POST['optRadio']) {

                case 'create':
                    // Create connection object
                    createConnection();

                    //Check connection
                    if ($conn->connect_error) {
                        die("Connection Failed: " . $conn->connect_error);
                    }

                    //start with a new database to start primary key at 1
                    $sql = "DROP DATABASE " . DBF_NAME;
                    runQuery($sql, "DROP " . DBF_NAME, false);

                    //Create database if it dosn't exist
                    $sql = "CREATE DATABASE IF NOT EXISTS " . DBF_NAME;

                    runQuery($sql, "Creating " . DBF_NAME, true);

                    //Select the database
                    $conn->select_db(DBF_NAME);

                    /******************************************************************
                     *              create the tables
                     *****************************************************************/
                    //create Table:eeStatus
                    $sql = "CREATE TABLE IF NOT EXISTS eeSchedule (
                                id_eeSchedule         INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                fName                      INT(6) NOT NULL,
                                lName                      INT(6) NOT NULL,
                                eeNumber                INT(6) NOT NULL,
                                scheduledDate         DATE NOT NULL,
                                scheduledStart        TIME NOT NULL,
                                scheduledEnd          TIME NOT NULL
                                
                                )";
                    runQuery($sql, "Creating Employee table", TRUE);


                    //create Table:eeStatus
                    $sql = "CREATE TABLE IF NOT EXISTS eeStatus (
                                id_eeStatus     int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                eeStatus         VARCHAR(10) NOT NULL
                                )";
                    runQuery($sql, "Creating Employee Status Table", TRUE);

                    //create Table:eeName
                    $sql = "CREATE TABLE IF NOT EXISTS eeName (
                                id_eeName         int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                fName                VARCHAR(20) NOT NULL,
                                lName                 VARCHAR(20) NOT NULL,
                                eeNumber          SMALLINT,
                                eeStatus            SMALLINT
                                )";
                    runQuery($sql, "Creating Employee Status Table", TRUE);


                    /******************************************************************
                     *          Populate tables using sample data
                     * ****************************************************************/
                    //populate Table:employee

                    $eeArray = array(
                        array(' ', '1', '1', "55", '2017-06-15', '08:00:00', '16:00:00'),
                        array(' ', '2', '2', "183", '2017-06-15', '10:00:00', '16:00:00'),
                    );

                    //print_r($eeArray);

                    foreach ($eeArray as $ee) {
                        //echo $ee[0] . " " . $ee[1] . "<br />";
                        $sql = "INSERT INTO eeSchedule (id_eeSchedule, fName, Lname, eeNumber, scheduledDate, 
                                                                                scheduledStart, scheduledEnd) "
                            . "VALUES ('" . $ee[0] . "','"
                            . $ee[1] . "', '"
                            . $ee[2] . "', '"
                            . $ee[3] . "', '"
                            . $ee[4] . "', '"
                            . $ee[5] . "', '"
                            . $ee[6] . "')";

                        runQuery($sql, "Record Inserted for: $ee[1]", true);
                    }

                    //populate Table:eeStatus
                    $statusArray = array(
                        array(' ', 'Active'),
                        array(' ', 'LOA-Paid'),
                        array(' ', 'LOA-Unpaid'),
                        array(' ', 'Layoff'),
                        array(' ', 'Term'),
                        array(' ', 'FMLA')
                    );
                    //print_r($statusArray);

                    foreach ($statusArray as $statusEE) {
                        //echo $statusEE[0] . " " . $statusEE[1] . "<br />";
                        $sql = "INSERT INTO eeStatus (id_eeStatus, eeStatus) "
                            . "VALUES ('" . $statusEE[0] . "','" . $statusEE[1] . "')";

                        runQuery($sql, "Record Inserted for: $statusEE[1]", true);
                    }

                    //populate Table:eeName
                    $nameArray = array(
                        array('Jimmy', 'Vaughn', 55),
                        array('Jane', 'Doe', 183),
                    );
                    //print_r($nameArray);

                    foreach ($nameArray as $nameEE) {
                        //echo $statusEE[0] . " " . $statusEE[1] . "<br />";
                        $sql = "INSERT INTO eeName (fName, lName, eeNumber) "
                            . "VALUES ('" . $nameEE[0] . "','" . $nameEE[1] . "','" . $nameEE[2] . "')";

                        runQuery($sql, "Record Inserted for: $nameEE[1]", true);
                    }
                    break;

                case 'display':
                    global $sql;
                    global $tableFormat;

                    $db = new mysqli(DBF_SERVER, DBF_USER, DBF_PASSWORD, DBF_NAME);
                    if ($db->connect_errno > 0) {
                        die('unable to connect to database [' . $db->connect_error . ']');
                    }

                    $sql = "SELECT eeName.fName, eeName.lName, eeName.eeNumber, eeSchedule.scheduledDate,
                                               eeSchedule.scheduledStart, eeSchedule.scheduledEnd
                                              FROM eeSchedule
                   
                                               LEFT OUTER JOIN eeName ON eeSchedule.eeNumber = eeName.eeNumber
                   
                                               ORDER BY lName
                                                                             
                                                                                            
                                            ";
                   // $sql = "SELECT * FROM eeName";
                    $result = $db->query($sql);

                    //get data from the database using sql
                    //if ($result = $db->query($sql)) {
                     //   die('There was an error running the query [' . $db->connect_error . ']');
                    //}

                        echo '<h2>Employee Schedule</h2>';
                        echo '<table class="table">';
                        echo '<tr>';
                        echo '<th colspan="2">Name</th>';
                        echo '<th>Employee #</th>';
                        echo '<th>Date</th>';
                        echo '<th>Start Time</th>';
                        echo '<th>End Time</th>';


                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['fName'] . '</td>';
                            echo '<td>' . $row['lName'] . '</td>';
                            echo '<td>' . $row['eeNumber'] . '</td>';
                            echo '<td>' . $row['scheduledDate'] . '</td>';
                            echo '<td>' . $row['scheduledStart'] . '</td>';
                            echo '<td>' . $row['scheduledEnd'] . '</td>';
                            echo '<td>' . $row['eeStatus'] . '</td>';
                        }
                        echo '</table>';
                        break;
                    }


            ?>
        </div>  <!--    /well  -->
        </div><!--________________________________/Col2_________-->
    </div><!--________________________________/Row2_________-->


    <!--  ________________________________  Start of Row3_______    -->

    <!--<div class="row">
        <!--___________________________________Start Col1______-->
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
            <div class="well"><h2><small>Add a New Employee</small></h2>
            <form action="newEE.php" method="post">
                <div class="form-group">
                    <label for="fName">First Name</label>
                    <input type="text"
                               class="form-control"
                               id="fName"
                               value="Jonny"
                               placeholder="First Name"
                               name="fName">
                </div>

                <div class="form-group">
                    <label for="lName">Last Name</label>
                    <input type="text"
                           class="form-control"
                           id="lName"
                           value="Lang"
                           placeholder="Last Name"
                           name="lName">
                </div>

                <div class="form-group">
                    <label for="eeNum">Employee Number</label>
                    <input type="text"
                           class="form-control"
                           id="eeNum"
                           value="456"
                           placeholder="Employee Number"
                           name="eeNum">
                </div>

                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
        </div><!--____________________________/Col1____________-->

        <!--___________________________________Start Col2______-->
        <!--<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="well"><h2><small>Change EE Status</small></h2>
            <form action="eeStatusProof.php" method="post">

                <div class="form-group">
                    <label for="currentEEStatus">Select Employee</label>
                    <select class="form-control" id="currentEEnumber" name="currentEEnumber">
                        <?PHP
                        //global $sql;

                        //$db = new mysqli(DBF_SERVER, DBF_USER, DBF_PASSWORD, DBF_NAME);
                        //if ($db->connect_errno > 0) {
                        //    die('unable to connect to database [' . $db->connect_error . ']');
                        //}
                        // Loop through the table to build the <option> list
                        //$sql = "SELECT eeNumber, fName, lName  FROM eeName ORDER BY lName";
                        //$result = $db->query($sql);
                        //while($row = $result->fetch_assoc()) {
                        //   echo "<option value=" . $row[eeNumber] . ">" . $row["eeNumber"] . " "
                        //     . $row["fName"] . " " . $row["lName"]
                        //     . "</option>";
                        //}
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="eeStatus">Change Employee Status To : </label>
                    <select class="form-control" id="eeStatus" name="eeStatus">
                        <option value="1">Active</option>
                        <option value="2">LOA-Paid</option>
                        <option value="3">LOA-Unpaid</option>
                        <option value="4">Layoff</option>
                        <option value="5">Term</option>
                        <option value="6">FMLA</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning">Change</button>
            </form>
            </div>
        </div><!--______________________________/Col2_________-->

        <!--___________________________________Start Col3______-->
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6">
            <div class="well"><h2><small>Create/Modify Schedule</small></h2>

            <form action="scheduleProof.php" method="post">

                <div class="form-group">
                    <label for="currentEESchedule">Select Employee</label>
                    <select class="form-control" id="currentEESchedule" name="currentEESchedule">
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
                    </select>

                </div>

                <div class="form-group">
                    <label for="workDate">Select Day</label>
                    <input type="date"
                           class="form-control"
                           id="workDate"
                           name="workDate"
                           value="2017-07-14" >
                </div>

                <div class="form-group">
                    <label for="startTime">Start Time</label>
                    <input type="time"
                           class="form-control"
                           id="startTime"
                           name="startTime"
                           value="09:30:00" >
                </div>

                <div class="form-group">
                    <label for="endTime">End Time</label>
                    <input type="time"
                           class="form-control"
                           id="endTime"
                           name="endTime"
                           value="18:30:00" >
                </div>

                <button type="submit" class="btn btn-success">Add</button>
            </form>
            </div>
        </div><!--____________________________/Col3____________-->

        <!--___________________________________Start Col4______-->
     <!--   <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <div class="well">View Schedules by date range
            <form action=""><!--FIXME-->
<!--                <div class="form-group">
                    <div class="form-group">
                        <label for="workdate">From</label><!-- FIXME Date Picker-->
<!--                        <input type="date"
                               class="form-control"
                               id="workDate"
                               name="WorkDate">
                    </div>
                    <div class="form-group">
                        <label for="workdate">To</label><!-- FIXME Date Picker-->
<!--                        <input type="date"
                               class="form-control"
                               id="workDate"
                               name="WorkDate">
                    </div>
                    <button type="submit" class="btn btn-success">View</button>
            </form>
            </div>-->
        </div><!--____________________________/Col4____________-->

    </div><!--  _____________________________/Row3_____________-->
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
</body>
</html>