<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','ngo');
define('DB_PASS','ngo@123');
define('DB_NAME','ngoLibrarySystem');
define('no_of_max_books_tobe_issued','3');
define('no_of_max_days_tobe_issued','15');
define('no_of_max_renew_count','2');

// Establish database connection.
try
{
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
    exit("Error: " . $e->getMessage());
}

$maxbooks = no_of_max_books_tobe_issued;
$maxdays = no_of_max_days_tobe_issued;
$maxrenewcount = no_of_max_renew_count;
?>
