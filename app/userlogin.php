<?php
    require "conn.php";
    $email=$_POST['emailId'];
    $password=$_POST['password'];
    $sql ="SELECT EmailId,Password,StudentId,Status FROM tblstudents WHERE EmailId=:email and Password=:password";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0)
    {
        foreach ($results as $result) {
            $_SESSION['stdid']=$result->StudentId;
            if($result->Status==1)
            {
                echo "1"; // Login Successful
            }	
            else {
                echo "2"; // Student ID Blocked
            }
        }
    }
    else
    {
        echo "0"; // Login Failed
    }
?>
