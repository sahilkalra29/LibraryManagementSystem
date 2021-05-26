<?php
    require "conn.php";
    $sid = $_POST['emailId'];
    //$sid = '77@77.com';

    $sql ="SELECT * from tblstudents where emailId=:sid";
    $query = $dbh -> prepare($sql);
    $query->bindParam(':sid',$sid,PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    
    if($query->rowCount() > 0)
    {
        foreach ($results as $result) {
            echo $result->StudentId;
        }
    }
?>