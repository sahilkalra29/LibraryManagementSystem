<?php
    require "conn.php";
    $name = $_POST['name'];
    $mobileno = $_POST['mobileNo'];
    $address=$_POST['address'];
    $email=$_POST['emailId'];
    $password=$_POST['password'];
    $status=1;


    $sql1 = "SELECT * FROM tblstudents where EmailId=:email";
    $query = $dbh -> prepare($sql1);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0)
    {
        echo "5"; // Email Id Already Exists"
    }
    else
    {
        $sql="INSERT INTO  tblstudents(FullName,MobileNumber,Address, EmailId,Password,Status) VALUES(:name,:mobileno,:address,:email,:password,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name',$name,PDO::PARAM_STR);
        $query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
        $query->bindParam(':address',$address,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':password',$password,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->execute();
        
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            echo "3"; //Registration Successful
        }
        else 
        {
            echo "4"; // Registration Failed
        }
    }
?>

