<?php
    require "conn.php";
    $sid = $_POST['emailId'];
    //$sid = '33@33.com';

    $sql="SELECT * from  tblstudents where EmailId=:sid";
    //$sql = "SELECT * from tblstudents;";
    $query = $dbh -> prepare($sql);
    $query-> bindParam(':sid', $sid, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);

    $response = array();
    
    if($query->rowCount() > 0)
    {
        foreach($results as $result)
        {
        array_push($response, array($result->StudentId, 
                                    $result->FullName,
                                    $result->MobileNumber,
                                    $result->Address,
                                    $result->Status,
                                    $result->RegDate,
                                    $result->UpdationDate
                                ));
        }
    }
    echo json_encode(array("server_response"=>$response));
?>