<?php 
require_once("includes/config.php");
if(!empty($_POST["studentid"])) 
{
  $studentid= strtoupper($_POST["studentid"]);
  
  $sql ="SELECT FullName,Status FROM tblstudents WHERE StudentId=:studentid";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':studentid', $studentid, PDO::PARAM_STR);
  $query-> execute();
  $results = $query -> fetchAll(PDO::FETCH_OBJ);
  $cnt=1;
  if($query -> rowCount() > 0)
  {
    foreach ($results as $result) {
      if($result->Status==0)
      {?>
        <option style='color:red' value="0"><?php echo htmlentities("Student ID Blocked");?></option>
        <?php 
        //echo "<span style='color:red'> Student ID Blocked </span>"."<br />";
        //echo "<b>Student Name-</b>" .$result->FullName;
        echo "<script>$('#submit').prop('disabled',true);</script>"; 
      } 
      else { 
        ?>
        <option value="1"><?php echo htmlentities($result->FullName);?></option>
        <?php 
          echo "<script>$('#submit').prop('disabled',false);</script>";
      }
    }
  }
  else
  {?>
    <option style='color:red' value="2"><?php echo htmlentities("Student ID Invalid");?></option>
    <?php
    //echo "<span style='color:red'> Invalid Student Id. Please Enter Valid Student id .</span>";
    echo "<script>$('#submit').prop('disabled',true);</script>";
  }
}
?>