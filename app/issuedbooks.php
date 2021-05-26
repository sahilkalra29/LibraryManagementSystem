<?php 
require "conn.php";
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    $sid=$_POST['studentId'];
    //$sid = '1';

    $sql="SELECT tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid,tblissuedbookdetails.fine from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId where tblstudents.StudentId=:sid order by tblissuedbookdetails.id desc";
    $query = $dbh -> prepare($sql);
    $query-> bindParam(':sid', $sid, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    
    $response = array();
    
    if($query->rowCount() > 0)
    {
        foreach($results as $result)
        {  
            if($result->fine=="")
            {
                $result->fine = "0";
            }
            if($result->ReturnDate == "")
            {
                $result->ReturnDate = "Not Returned Yet";
            }
            array_push($response, array($result->BookName,
                                    $result->ISBNNumber,
                                    $result->IssuesDate,
                                    $result->ReturnDate,
                                    $result->fine
                                ));
        }
    }
    echo json_encode(array("server_response"=>$response));    
?>     