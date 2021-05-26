<?php
    require "conn.php";
    $sid = $_POST['studentId'];
    //$sid = '1';
    $rsts=0;

    $sql1 ="SELECT id from tblissuedbookdetails where StudentID=:sid and ReturnStatus=:rsts";
    $query1 = $dbh -> prepare($sql1);
    $query1->bindParam(':sid',$sid,PDO::PARAM_STR);
    $query1->bindParam(':rsts',$rsts,PDO::PARAM_STR);
    $query1->execute();
    $results1=$query1->fetchAll(PDO::FETCH_OBJ);
    $issuedbooks=$query1->rowCount();
    
    echo $issuedbooks;
?>