<?php 
define('DB_SERVER','127.0.0.1:3307');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
//define('DB_NAME','LOGIN');

$conn=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);

//check connection

if (!$conn) {
     
     echo"Error! while connecting  to the database";
}
else {
     // echo"WOOHO! while connecting  to the database";
     $dbName = "login_1";

     $createDbQuery = "CREATE DATABASE IF NOT EXISTS $dbName";
     if ($conn->query($createDbQuery) === false) {
         die("Error creating database: " . $conn->error);
     }
     
     $conn->select_db($dbName);

$tableName = "user_login_1";


$createTableQuery = "CREATE TABLE IF NOT EXISTS $tableName (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL
);";

if ($conn->query($createTableQuery) === false) {
    die("Error creating table: " . $conn->error);
}


}

?>