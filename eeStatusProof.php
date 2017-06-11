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

global $sql;
global $conn;

//connect to db
$db = mysqli_connect(DBF_SERVER, DBF_USER, DBF_PASSWORD, DBF_NAME);
if ($db->connect_errno > 0) {
    die('unable to connect to database [' . $db->connect_error . ']');
}

//Send form data to db
mysqli_query($db, "UPDATE employee 
                                                Set eeStatus = '$_POST[eeStatus]'
                                                WHERE eeNumber = '$_POST[currentEEStatus]'");



//mysqli_query($db, "INSERT INTO employee (fName, lName, eeNumber)
//                        VALUES ('$_POST[fName]', '$_POST[lName]', '$_POST[eeNum]')");

ECHO "<h2>Record Modified For: " .  $_POST[fName] . " " .  $_POST[lName] . "</h2>";
print_r($_POST);

echo "<br /> <br /> <br />";
echo "<h2><a href=\"proofOfConcept.php\">Return to Proof of concept page</a></h2>";
echo "<br /> <br /> <br />";
echo "<h2>Rebuild employee table without rebuilding database to see changes</h2>";

?>