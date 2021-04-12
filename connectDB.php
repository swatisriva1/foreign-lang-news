<?php

/******************************/
// connecting to GCP cloud SQL instance

// $username = 'root';
// $password = 'your-root-password';

// $dbname = 'your-database-name';

// if PHP is on GCP standard App Engine, use instance name to connect
// $host = 'instance-connection-name';

// if PHP is hosted somewhere else (non-GCP), use public IP address to connect
// $host = "public-IP-address-to-cloud-instance";


/******************************/
// connecting to DB on XAMPP (local)

// $username = 'web4640';
// $password = 'webpl4640fln';
// $host = 'localhost:3306';
// $dbname = 'ss3ck_foreign_lang_news_db';

require_once('env.php');

$username = getenv('db_username');
$password = getenv('db_pwd');
$host = getenv('db_host');
$dbname = getenv('db_name');


/******************************/
// connecting to DB on CS server

// $username = 'ss3ck';
// $password = 'F4ll2020!!';
// $host = 'usersrv01.cs.virginia.edu';
// // $dbname = 'ss3ck_foreign_lang_news_db';
// $dbname = 'ss3ck';
//  // z3TNabqvJXGiMEOM

/******************************/

$dsn = "mysql:host=$host;dbname=$dbname";
$db = "";

// echo phpinfo(INFO_ENVIRONMENT);

/** connect to the database **/
try 
{
   $db = new PDO($dsn, $username, $password);   
   // echo "<p>You are connected to the database</p>";
}
catch (PDOException $e)     // handle a PDO exception (errors thrown by the PDO library)
{
   // Call a method from any object, 
   // use the object's name followed by -> and then method's name
   // All exception objects provide a getMessage() method that returns the error message 
   $error_message = $e->getMessage();        
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e)       // handle any type of exception
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

?>