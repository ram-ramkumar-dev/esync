 <?php
/* Database credentials.  */

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'material_testing');
define('DB_PASSWORD', 'testing123@');
define('DB_NAME', 'material_testing');
 
/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>