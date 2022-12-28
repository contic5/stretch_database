<?php
require("sessionstart.php");
if(isset($_REQUEST['difficulty']))
{
  $resulttext='';
  $selecteddifficulty=$_REQUEST['difficulty'];
  $selectedcategory=$_REQUEST['category'];
  $conn = mysqli_connect("localhost","cjcuser","computing","Exercises");
  $query=sprintf("SELECT * FROM Stretches WHERE Difficulty LIKE '%s' AND Category LIKE '%s' AND Hidden=False ORDER BY DifficultyID,Category,Name",$selecteddifficulty,$selectedcategory);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  $totalrows=mysqli_num_rows($result);
  $lastdifficulty='';
  $lastcategory='';
  $resulttext.='<div class="mdc-data-table">';
  $resulttext.='<div class="mdc-data-table__table-container">';
  $resulttext.='<table class="mdc-data-table__table"><tbody class="mdc-data-table__body">';

  $disabledtext="disabled";
  if(isset($_SESSION['username']))
  {
    $disabledtext='';
  }
  while($row=mysqli_fetch_assoc($result))
  {
    $stretchname=$row['Name'];
    $difficulty=$row['Difficulty'];
    $category=$row['Category'];
    if($lastdifficulty!=$difficulty)
    {
      $lastdifficulty=$difficulty;
      $resulttext.="<tr class='mdc-data-table__row'><td class='mdc-data-table__header-cell' style='font-size:24px;' colspan='5'>$difficulty</td></tr>";
    }
    if($lastcategory!=$category)
    {
      $lastcategory=$category;
      $resulttext.="<tr class='mdc-data-table__row'><td class='mdc-data-table__header-cell' style='font-size:18px;' colspan='5'>$category</td></tr>";
    }
    $resulttext.="<tr class='mdc-data-table__row'>";
    $resulttext.="<td class='mdc-data-table__cell'>".$stretchname."</td><td class='mdc-data-table__cell'>".$category."</td><td class='mdc-data-table__cell'>".$difficulty."</td>";

    $ID=$row['ID'];
    $buttontext='hidestretch('.$ID.')';
    $mybutton='<button onclick='.$buttontext.'>Hide stretch</button>';
    $resulttext.="<td class='mdc-data-table__cell'>".$mybutton."</td>";

    $buttontext='deletestretch('.$ID.')';
    $mybutton='<button onclick='.$buttontext.' '.$disabledtext.'>Delete stretch</button>';
    $resulttext.="<td class='mdc-data-table__cell'>".$mybutton."</td>";

    $resulttext.="</tr>";
  }
  $resulttext.='</tbody></table>';
  $resulttext.="</div></div>";
  $resulttext.='<h3>Total stretches: '.$totalrows.'</h3>';
  print($resulttext);
}
?>
