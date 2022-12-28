<?php
if(isset($_REQUEST['stretchid']))
{
  $stretchid=$_REQUEST["stretchid"];
  print('stretch deleted');
  $conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
  $query=sprintf("DELETE FROM Stretches WHERE ID='%s'",$stretchid);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
}
?>
