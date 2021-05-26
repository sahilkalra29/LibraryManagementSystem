<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signup']))
{
//code for captach verification
    if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    } 
    else 
    {    
        $fname=$_POST['fullanme'];
        $mobileno=$_POST['mobileno'];
        $address=$_POST['address'];
        $email=$_POST['email']; 
        $password=$_POST['password']; 
        $status=1;
        $sql="INSERT INTO  tblstudents(FullName,MobileNumber,Address, EmailId,Password,Status) VALUES(:fname,:mobileno,:address,:email,:password,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname',$fname,PDO::PARAM_STR);
        $query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
        $query->bindParam(':address',$address,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':password',$password,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            echo '<script>alert("Your Registration successfull")</script>';
            header("Location: userlogin.php", true, 301);
            exit();
        }
        else 
        {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
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
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Online Library Management System | Student Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

<script type="text/javascript">
function valid()
{
    if(document.signup.password.value!= document.signup.confirmpassword.value)
    {
        alert("Password and Confirm Password Field do not match  !!");
        document.signup.confirmpassword.focus();
        return false;
    }
    else if((isNaN(document.signup.mobileno.value)))
    {
        alert("Please Enter a Valid Mobile Number  !!");
        return false;
    }
    return true;
}
</script>

<script>
function checkAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "check_availability.php",
    data:'emailid='+$("#emailid").val(),
    type: "POST",
    success:function(data){
    $("#user-availability-status").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
}

function validateNumber() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "validate_number.php",
    data:'mobileno='+$("#mobileno").val(),
    type: "POST",
    success:function(data){
    $("#mobile-availability-status").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
}
</script>    
</head>

<body>
<!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">User Signup</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                        SINGUP FORM
                        </div>
                        <div class="panel-body">
                        <form name="signup" method="post" onSubmit="return valid();">
                        <div class="form-group">
                            <label>Enter Full Name</label>
                            <input class="form-control" type="text" name="fullanme" autocomplete="off" required />
                        </div>

                        <div class="form-group">
                            <label>Mobile Number :</label>
                            <input class="form-control" type="number" name="mobileno" id="mobileno" maxlength="10" onBlur="validateNumber()" autocomplete="off" required />
                            <span id="mobile-availability-status" style="font-size:12px;"></span> 
                        </div>

                        <div class="form-group">
                            <label>Address :</label>
                            <input class="form-control" type="text" name="address" id="address" autocomplete="off" required />
                        </div>
                                                                
                        <div class="form-group">
                            <label>Enter Email</label>
                            <input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()"  autocomplete="off" required  />
                            <span id="user-availability-status" style="font-size:12px;"></span> 
                        </div>

                        <div class="form-group">
                            <label>Enter Password</label>
                            <input class="form-control" type="password" name="password" autocomplete="off" required  />
                        </div>

                        <div class="form-group">
                            <label>Confirm Password </label>
                            <input class="form-control"  type="password" name="confirmpassword" autocomplete="off" required  />
                        </div>

                        <div class="form-group">
                            <label>Verification code : </label>
                            <input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
                        </div>                                
                        <button type="submit" name="signup" class="btn btn-danger" id="submit">Register Now </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS  -->
<script src="assets/js/bootstrap.js"></script>
<!-- CUSTOM SCRIPTS  -->
<script src="assets/js/custom.js"></script>
</body>
</html>
