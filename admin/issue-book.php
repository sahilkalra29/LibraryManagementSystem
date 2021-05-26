<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}

else{ 
    if(isset($_POST['issuebutton']))
    {
        $studentid=strtoupper($_POST['studentid']);
        $bookisbn=$_POST['bookisbn'];
        $bookid=$_POST['bookdetails'];
        $sql="INSERT INTO  tblissuedbookdetails(StudentID,BookId,ISBNNumber) VALUES(:studentid,:bookid,:bookisbn)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
        $query->bindParam(':bookisbn',$bookisbn,PDO::PARAM_STR);
        $query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if($lastInsertId)
        {
            $_SESSION['msg']="Book issued successfully";
            header('location:manage-issued-books.php');
            /*  CODE SHIFTED TO SQL PHPMYADMIN TRIGGERS */
            /*$sql1="update tblbooks set IssuedQuantity=IssuedQuantity+1 where id=:bookisbn";
            $query = $dbh->prepare($sql1);
            //$query->bindParam(':bookisbn',$bookisbn,PDO::PARAM_STR);
            $query->execute();
            $lastInsertId1 = $dbh->lastInsertId();
            console.log("\nKALRA- --> $lastInsertId1");
            if($lastInsertId1)
            {*/
                
            /*}
            else
            {
                $sql2="DELETE from tblissuedbookdetails order by id desc limit 1";
                $query = $dbh->prepare($sql2);
                $query->execute();
                $_SESSION['msg']="Error in updating issued quantity !!!";
                header('location:manage-issued-books.php');
            }*/
        }
        else 
        {
            $_SESSION['error']="Error !! Please Try Again.";
            header('location:manage-issued-books.php');
        }
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Issue a new Book</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<script>

// function for get student name
function getstudent() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "get_student.php",
    data:'studentid='+$("#studentid").val(),
    type: "POST",
    success:function(data){
    $("#get_student_name").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
}

// function for get already books issued
function getbooksalreadyissued() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "get_books_already_issued.php",
    data:'studentid='+$("#studentid").val(),
    type: "POST",
    success:function(data){
    $("#get_books_already_issued").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
}

//function for book name and id
function getbook() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "get_book.php",
    data:'bookisbn='+$("#bookisbn").val(),
    type: "POST",
    success:function(data){
    $("#get_book_name").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
}

//function for book total quantity
function getbookquantity() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "get_book_quantity.php",
    data:'bookisbn='+$("#bookisbn").val(),
    type: "POST",
    success:function(data){
    $("#get_book_quantity").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
}

//function for book issued quantity
function getbookissuedquantity() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "get_book_issued_quantity.php",
    data:'bookisbn='+$("#bookisbn").val(),
    type: "POST",
    success:function(data){
    $("#get_book_issued_quantity").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
}

//function for previous issued books history
function getbookprevhistory() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "get_prev_issued_history.php",
    //data:'bookisbn='+$("#bookisbn").val(),
    data: {bookisbn: $("#bookisbn").val(), studentid: $("#studentid").val()},
    type: "POST",
    success:function(data){
    $("#get_prev_issued_history").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
}

</script> 
<style type="text/css">
    .others{
    color:red;
    }
</style>
</head>

<script type="text/javascript">
function checkQuantity()
{
    /* Check Student is Blocked or Invalid */
    if(document.issue.get_student_name.value === "0")
    {
        alert("Student Id is Blocked !!");
        document.issue.get_student_name.focus();
        return false;
    }
    if(document.issue.get_student_name.value === "2")
    {
        alert("Student Id is Invalid !!");
        document.issue.get_student_name.focus();
        return false;
    }

    /* Check if book already issued or not */
    if(document.issue.get_prev_issued_history.value === "1")
    {
        alert("Book is already issued to this Student !!");
        document.issue.get_prev_issued_history.focus();
        return false;
    }

    /*Check for Invalid ISBN */
    if(document.issue.get_book_name.value === "Invalid ISBN Number")
    {
        alert("ERROR :: Invalid ISBN Number !!");
        document.issue.bookisbn.focus();
        return false;
    }

    /* Check if Max number of books already issued to Student or not */
    var allowed_maxbooks = "<?php echo $maxbooks; ?>";
    if(document.issue.bookquantitydetails.value === document.issue.bookissuedquantitydetails.value)
    {
        alert("All Books with this ISBN Number are issued !!");
        document.issue.get_book_issued_quantity.focus();
        return false;
    }

    /* Check if book already issued to Student or not */
    if(document.issue.booksalreadyissued.value === allowed_maxbooks)
    {
        alert("Maximum Number of Books are already issued to this Student !!");
        document.issue.get_books_already_issued.focus();
        return false;
    }
return true;
}
</script>

<body>

<!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->

<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Issue a New Book</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Issue a New Book
                    </div>
                    
                    <div class="panel-body">
                        <form role="form" method="post" onSubmit="return checkQuantity();" name="issue">

                        <div class="form-group">
                            <label>Student ID<span style="color:red;">*</span></label>
                            <input class="form-control" type="text" name="studentid" id="studentid" onBlur="getstudent();getbooksalreadyissued();" autocomplete="off"  required />
                        </div>

                        <div class="form-group">
                            <label> Student Name</label> 
                            <select  class="form-control" name="studentdetails" id="get_student_name" readonly></select>
                        </div>

                        <div class="form-group">
                            <label> No. of Books Already Issued</label> 
                            <select  class="form-control" name="booksalreadyissued" id="get_books_already_issued" readonly></select>
                        </div>

                        <div class="form-group">
                            <label>ISBN Number<span style="color:red;">*</span></label>
                            <input class="form-control" type="text" name="bookisbn" id="bookisbn" onBlur="getbook();getbookquantity();getbookissuedquantity();getbookprevhistory();" required="required" />
                        </div>

                        <div class="form-group">
                            <label> Book Name</label> 
                            <select class="form-control" name="bookdetails" id="get_book_name" readonly></select>
                        </div>

                        <div class="form-group">
                            <label> Total Quantity</label> 
                            <select class="form-control" name="bookquantitydetails" id="get_book_quantity" readonly></select>
                        </div>

                        <div class="form-group">
                            <label> Issued Quantity</label> 
                            <select class="form-control" name="bookissuedquantitydetails" id="get_book_issued_quantity" readonly></select>
                        </div>

                        <div class="form-group">
                            <label> Already Issued?</label> 
                            <select class="form-control" name="alreadyissued" id="get_prev_issued_history" readonly></select>
                        </div>

                        <button type="submit" name="issuebutton" id="submit" class="btn btn-info">Issue Book </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CONTENT-WRAPPER SECTION END-->

<?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php } ?>
