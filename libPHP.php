<?PHP
/* libPHP.php - library of common PHP functions for prjProcess
   used with prjCRUD Website
   Chris Gish           gishc@csp.edu
   Written: 06/02/2017
*/

/* = = = = = = = = = = = = = = = = = = =
Functions are in alphabetical order
= = = = = = = = = = = = = = = = = = = = */

//  _____________________________________________createConnection()
function createConnection( ) {
    global $conn;
    // Create connection object
    $conn = new mysqli(DBF_SERVER, DBF_USER,
        DBF_PASSWORD);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Select the database
    $conn->select_db(DBF_NAME);
} // end of createConnection( )



//______________________________________displayResult($result, $sql)
function displayResult($result, $sql)
{
    if ($result->num_rows > 0) {
        echo "<table border='1'>\n";
        // print headings (field names)
        $heading = $result->fetch_assoc();
        echo "<tr>\n";
        // print field names
        foreach ($heading as $key => $value) {
            echo "<th>" . $key . "</th>\n";
        }
        echo "</tr>\n";

        // Print values for the first row
        echo "<tr>\n";
        foreach ($heading as $key => $value) {
            echo "<td>" . $value . "</td>\n";
        }

        // output rest of the records
        while ($row = $result->fetch_assoc()) {
            //print_r($row);
            //echo "<br />";
            echo "<tr>\n";
            // print data
            foreach ($row as $key => $value) {
                echo "<td>" . $value . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    } else {
        echo "<strong>zero results using SQL: </strong>" . $sql;
    }
}  //end of displayResult ($result, $sql)


//______________________________________displaySchedule()
function displaySchedule ( )  {
    global $sql;

    $db = new mysqli(DBF_SERVER, DBF_USER, DBF_PASSWORD, DBF_NAME);
    if ($db->connect_errno > 0) {
        die('unable to connect to database [' . $db->connect_error . ']');
    }

    $sql = "SELECT eeName.fName, eeName.lName, eeName.eeNumber, eeSchedule.scheduledDate,
                                               eeSchedule.scheduledStart, eeSchedule.scheduledEnd                                             
                                            
                                              FROM eeSchedule                                             
                  
                                               LEFT OUTER JOIN eeName ON eeSchedule.eeNumber = eeName.eeNumber
                                               
                                               WHERE eeName.eeNumber = '" . $_POST[rdoSelectEE] . "'
                   
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
}

//______________________________runQuery($sql, $msg, $echoSuccess)
function runQuery($sql, $msg, $echoSuccess)
{
    global $conn;

    // run the query
    if ($conn->query($sql) === TRUE) {
        if ($echoSuccess) {
            echo $msg . " successful.<br />";
        }
    } else {
        echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql
            . "<br />" . $conn->error;
    }
} // end of runQuery( )

?>