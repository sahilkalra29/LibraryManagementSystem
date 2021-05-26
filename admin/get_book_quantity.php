<?php 
require_once("includes/config.php");
if(!empty($_POST["bookisbn"])) 
{
  $bookisbn=$_POST["bookisbn"];
 
  $sql ="SELECT BookQuantity,id FROM tblbooks WHERE (ISBNNumber=:bookisbn)";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':bookisbn', $bookisbn, PDO::PARAM_STR);
  $query-> execute();
  $results = $query -> fetchAll(PDO::FETCH_OBJ);
  $cnt=1;
  if($query -> rowCount() > 0)
  {
    foreach ($results as $result) {?>
      <option value="<?php echo htmlentities($result->BookQuantity);?>"><?php echo htmlentities($result->BookQuantity);?></option>
      <!--<b>Available Quantity :</b> -->
      <?php  
      //echo htmlentities($result->BookQuantity);
      echo "<script>$('#submit').prop('disabled',false);</script>";
    }
  }
  else
  {?> 
    <option class="others"> Invalid ISBN Number</option>
    <?php
      echo "<script>$('#submit').prop('disabled',true);</script>";
  }
}
?>
