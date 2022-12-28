<?php
if(isset($_REQUEST['stretchid']))
{
  $stretchid=$_REQUEST["stretchid"];
  print('stretch hidden');
  $conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
  $query=sprintf("UPDATE Stretches SET Hidden=1 WHERE ID='%s'",$stretchid);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
}
?>
