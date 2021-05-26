<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    require "conn.php";
   

    $sql="SELECT tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.BookQuantity,tblbooks.IssuedQuantity,tblbooks.id as bookid from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId";
    $query = $dbh -> prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);

    $response = array();
    
    if($query->rowCount() > 0)
    {
        foreach($results as $result)
        {
        array_push($response, array($result->BookName,
                                    $result->CategoryName,
                                    $result->AuthorName,
                                    $result->ISBNNumber,
                                    $result->BookQuantity,
                                    $result->IssuedQuantity,
                                ));
        }
    }
    echo json_encode(array("server_response"=>$response));
?>