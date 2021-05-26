<?php 
require_once("includes/config.php");
// code user mobile availablity

if(!empty($_POST["mobileno"])) {
	
	$mobileno= $_POST["mobileno"];
	
	if (is_numeric($mobileno))
	{
		$sql ="SELECT MobileNumber FROM tblstudents WHERE MobileNumber=:mobileno";
		$query= $dbh -> prepare($sql);
		$query-> bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
		$query-> execute();
		$results = $query -> fetchAll(PDO::FETCH_OBJ);
		$cnt=1;
		if($query -> rowCount() > 0)
		{
			echo "<span style='color:red'> Mobile Number already registered .</span>";
			echo "<script>$('#submit').prop('disabled',true);</script>";
		} 
		
	}
	else 
	{
		echo "<span style='color:red'> Please Enter a Valid Number .</span>";
		echo "<script>$('#submit').prop('disabled',true);</script>";
	}
}
?>
