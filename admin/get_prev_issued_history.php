<?php 
require_once("includes/config.php");
if(!empty($_POST["bookisbn"]) && !empty($_POST["studentid"])) 
{
  $bookisbn=$_POST["bookisbn"];
  $studentid=$_POST["studentid"];
 
  $sql ="SELECT id FROM tblissuedbookdetails WHERE (ISBNNumber=:bookisbn) AND (StudentID=:studentid) AND ReturnStatus=0";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':bookisbn', $bookisbn, PDO::PARAM_STR);
  $query-> bindParam(':studentid', $studentid, PDO::PARAM_STR);
  $query-> execute();
  $results = $query -> fetchAll(PDO::FETCH_OBJ);
  $cnt=1;
  if($query -> rowCount() > 0)
  {
    foreach ($results as $result) {?>
      <!-- <option value="<?php echo htmlentities($studentid);?>"><?php echo htmlentities(Yes);?></option> -->
      <!-- <b>Issued Quantity :</b> -->
      <option value="1"><?php echo htmlentities(Yes);?></option>
      <?php
      //echo htmlentities($result->IssuedQuantity);
      echo "<script>$('#submit').prop('disabled',true);</script>";
    }
  }
  else
  {?> 
    <option value="0" class="others">NO</option>
    <?php
      echo "<script>$('#submit').prop('disabled',false);</script>";
  }
}
else
{
    
}
?>
