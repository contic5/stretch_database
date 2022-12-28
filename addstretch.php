<?php
if(isset($_REQUEST['stretchname']))
{
  $stretchname=$_REQUEST["stretchname"];
  $difficulty=$_REQUEST['difficulty'];
  $category=$_REQUEST['category'];
  $difficultyid=0;
  if($difficulty=='Easy')
  {
    $difficultyid=0;
  }
  if($difficulty=='Medium')
  {
    $difficultyid=1;
  }
  if($difficulty=='Hard')
  {
    $difficultyid=2;
  }

  print('Added '.$stretchname." | ".$category." | ".$difficulty);
  $resulttext='';
  $conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
  $query=sprintf("INSERT INTO Stretches(Name,Difficulty,Category,Hidden,DifficultyID)
  VALUES('%s','%s','%s','%s','%s')",
  $stretchname,$difficulty,$category,0,$difficultyid);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
}
?>
