<?php 
include('includes/config.php');
if(!empty($_POST["studentid"])) 
{
  $studentid= strtoupper($_POST["studentid"]);
  
  $sql ="SELECT id from tblissuedbookdetails where StudentId=:studentid AND ReturnStatus=0";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':studentid', $studentid, PDO::PARAM_STR);
  $query-> execute();
  $results = $query -> fetchAll(PDO::FETCH_OBJ);
  $cnt=1;
  $issuedbooks=$query->rowCount();
?>
  <option value="<?php echo htmlentities($issuedbooks);?>"><?php echo htmlentities($issuedbooks);?></option>
  
<?php
  if($issuedbooks === $maxbooks)
  {
    echo "<script>$('#submit').prop('disabled',true);</script>"; 
  }
}
?>