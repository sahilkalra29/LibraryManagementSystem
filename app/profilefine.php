<?php
    $sum=0;
    require "conn.php";
    $sid = $_POST['studentId'];
    //$sid = '1';

    $sql3 ="SELECT fine from tblissuedbookdetails where StudentID=:sid";
    $query3 = $dbh -> prepare($sql3);
    $query3->bindParam(':sid',$sid,PDO::PARAM_STR);
    $query3->execute();
    $results3=$query3->fetchAll(PDO::FETCH_OBJ);
    if($query3 -> rowCount() > 0)
    {
        foreach ($results3 as $result) {
        $sum = $sum + ($result->fine);
        }
    }

    echo $sum;
?>