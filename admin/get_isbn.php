<?php 
require_once("includes/config.php");
if(!empty($_POST["isbn"])) {

    $isbn= ($_POST["isbn"]);
    
    $sql ="SELECT BookName FROM tblbooks WHERE ISBNNumber=:isbn";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':isbn', $isbn, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    $cnt=1;
    if($query -> rowCount() > 0)
    {
      foreach ($results as $result) { 
        echo htmlentities($result->FullName);
        echo "<span style='color:red'> This ISBN Number is already in use </span>"."<br />";
        echo "<b>Book Name-</b>" .$result->FullName;
        echo "<script>$('#submit').prop('disabled',false);</script>";
      }
    }
    else{
      echo "<span style='color:green'> This ISBN Number is free to use .</span>";
      echo "<script>$('#submit').prop('disabled',true);</script>";
    }
}
?>
