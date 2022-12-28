<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel='stylesheet' href="material-components-web.min.css">
  <link rel='stylesheet' href="mystyle.css">
</head>
<body>
<?php
require("sessionstart.php");
?>
<h1>Stretch Database</h1>
<?php
$username="";
if(isset($_SESSION['username']))
{
  $username=$_SESSION['username'];
  print("<h2>Hello ".$_SESSION["username"]."</h2>");
  print("<p><a href='logout.php'>Log Out</a></p>");
}
else
{
  print("<h2>Hello Guest</h2>");
  print("<p><a href='login.php'>Log In</a></p>");
}
?>
<h2>View Stretches</h2>
<div id='stretches' style='max-width:800px !important'></div>
<br>
<h3>Filter</h3>
<p>Difficulty:
<select name='selecteddifficulty' id='selecteddifficulty'>
<option value='%'>Any</option>
<option value='Easy'>Easy</option>
<option value='Medium'>Medium</option>
<option value='Hard'>Hard</option>
</select>
</p>

<p>
Category:
<select name='selectedcategory' id='selectedcategory'>
<option value='%'>Any</option>
<option value='Upper Body'>Upper Body</option>
<option value='Legs'>Legs</option>
<option value='Hips'>Hips</option>
<option value='Dynamic'>Dynamic</option>
<option value='Other'>Other</option>
</select>
</p>

<h3>Action Result</h3>
<div id='result'></div>
<?php
if(isset($_SESSION['username']))
{
?>
<form method='post' action='index.php'>
<h2>Add Stretches</h2>
<p>Enter Stretch Name:<br>
<input name='stretchname' id='stretchname' size=32></input>
</p>
Difficulty:
<select name='difficulty' id='difficulty'>
<option value='Easy'>Easy</option>
<option value='Medium'>Medium</option>
<option value='Hard'>Hard</option>
</select>

Category:
<select name='category' id='category'>
  <option value='Upper Body'>Upper Body</option>
  <option value='Legs'>Legs</option>
  <option value='Hips'>Hips</option>
  <option value='Dynamic'>Dynamic</option>
  <option value='Other'>Other</option>
</select>




</form>
<p><button onclick='addstretch()'>Add Stretch</button></p>
<?php
}
?>
<p><button onclick='showallstretches()'>Show All Stretches</button></p>

<script>
function displaystretches()
{

  let lastdifficulty="";
  let lastcategory="";

  let result=document.getElementById("result");
  if(result.childNodes[0])
  {
    result.removeChild(result.childNodes[0]); 
  }

  let outerdiv=document.createElement("div");
  outerdiv.classList.add("mdc-data-table");

  let innerdiv=document.createElement("div");
  innerdiv.classList.add("mdc-data-table__table-container");
  outerdiv.appendChild(innerdiv);

  let table=document.createElement("table");
  table.classList.add("mdc-data-table__table");
  innerdiv.appendChild(table);

  let tbody=document.createElement("tbody");
  tbody.id="tbody";
  tbody.classList.add("mdc-data-table_content");
  table.appendChild(tbody);
  for(let i=0;i<stretches.length;i++)
  {
    let stretch=stretches[i];
    let difficulty=dr_difficulties[i];
    let category=dr_categories[i];
    let id=ids[i];
    let hidden=hidden_arr[i];

    if(!hidden)
    {
    
      if(lastdifficulty!=difficulty)
      {
        //"<tr class='mdc-data-table__row'><td class='mdc-data-table__header-cell' style='font-size:24px;' colspan='5'>$difficulty</td></tr>";
        let difficultyrow=document.createElement("tr");
        tbody.classList.add('mdc-data-table__row');
        tbody.appendChild(difficultyrow);

        let difficultytd=document.createElement("td");
        difficultytd.classList.add("mdc-data-table__cell");
        difficultytd.classList.add("difficultyrowcell");
        difficultytd.innerHTML=difficulty;
        difficultyrow.appendChild(difficultytd);
      }
      if(lastcategory!=category)
      {
        let categoryrow=document.createElement("tr");
        tbody.classList.add('mdc-data-table__row');
        tbody.appendChild(categoryrow);

        let categorytd=document.createElement("td");
        categorytd.classList.add("mdc-data-table__cell");
        categorytd.classList.add("categoryrowcell");
        categorytd.innerHTML=category;
        categoryrow.appendChild(categorytd);
      }

      let row=document.createElement("tr");
      row.classList.add("mdc-data-table__row");
      row.id=id;

      let stretch_td=document.createElement("td");
      stretch_td.innerHTML=stretch;
      stretch_td.classList.add("mdc-data-table__cell");
      row.appendChild(stretch_td);

      let difficulty_td=document.createElement("td");
      difficulty_td.innerHTML=difficulty;
      difficulty_td.classList.add("mdc-data-table__cell");
      row.appendChild(difficulty_td);

      let category_td=document.createElement("td");
      category_td.innerHTML=category;
      category_td.classList.add("mdc-data-table__cell");
      row.appendChild(category_td);

      let hide_td=document.createElement("td");
      hide_td.classList.add("mdc-data-table__cell");
      row.appendChild(hide_td);

      let hidebutton=document.createElement("button");
      hidebutton.innerHTML="Hide";
      hidebutton.onclick=function()
      {
        console.log("Hide row "+i);
        hidden_arr[i]=true;
        displaystretches();
      }
      hide_td.appendChild(hidebutton);

      if(username!="")
      {
        let delete_td=document.createElement("td");
        delete_td.classList.add("mdc-data-table__cell");
        row.appendChild(delete_td);

        let deletebutton=document.createElement("button");
        deletebutton.innerHTML="Delete";
        deletebutton.onclick=function()
        {
          deletestretch(id);
        }
        delete_td.appendChild(deletebutton);
      }

      tbody.appendChild(row);

      lastcategory=category;
      lastdifficulty=difficulty;
    }
  }
  result.appendChild(outerdiv);
}

function addstretchtotable(id,stretch,difficulty,category)
{
  let tbody=document.getElementById("tbody");
  console.log(tbody!=null);

  let row=document.createElement("tr");
  row.classList.add("mdc-data-table__row");
  row.id=id;

  let stretch_td=document.createElement("td");
  stretch_td.innerHTML=stretch;
  stretch_td.classList.add("mdc-data-table__cell");
  row.appendChild(stretch_td);

  let difficulty_td=document.createElement("td");
  difficulty_td.innerHTML=difficulty;
  difficulty_td.classList.add("mdc-data-table__cell");
  row.appendChild(difficulty_td);

  let category_td=document.createElement("td");
  category_td.innerHTML=category;
  category_td.classList.add("mdc-data-table__cell");
  row.appendChild(category_td);

  let hide_td=document.createElement("td");
  hide_td.classList.add("mdc-data-table__cell");
  row.appendChild(hide_td);

  let hidebutton=document.createElement("button");
  hidebutton.innerHTML="Hide";
  hidebutton.onclick=function()
  {
    console.log("Hide row "+i);
    hidden_arr[i]=true;
    displaystretches();
  }
  hide_td.appendChild(hidebutton);

  if(username!="")
  {
    let delete_td=document.createElement("td");
    delete_td.classList.add("mdc-data-table__cell");
    row.appendChild(delete_td);

    let deletebutton=document.createElement("button");
    deletebutton.innerHTML="Delete";
    deletebutton.onclick=function()
    {
      deletestretch(id);
    }
    delete_td.appendChild(deletebutton);
  }
  tbody.appendChild(row);
}

function hiderow(i)
{
  console.log("Hide row "+i);
  hidden_arr[i]=true;
  displaystretches();
}

function getupdatedstretches()
{
  var xmlhttp = new XMLHttpRequest();
  var selecteddifficulty=document.getElementById('selecteddifficulty').value;
  var selectedcategory=document.getElementById('selectedcategory').value;

  //alert(selecteddifficulty);
  xmlhttp.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
          console.log("Ready response changed");
          //alert(this.responseText);
          let res=JSON.parse(this.responseText)
          stretches=res.stretches;
          dr_difficulties=res.difficulties;
          dr_categories=res.categories;
          ids=res.ids;
          
          hidden_arr=[];
          for(let i=0;i<stretches.length;i++)
          {
            hidden_arr.push(false);
          }

          console.log("Getting updated stretches");
          displaystretches();
      }
  };
  xmlhttp.open("GET", "getstretchesv2.php?difficulty="+selecteddifficulty+'&category='+selectedcategory, true);
  xmlhttp.send();
}

function addstretch()
{
  var stretchname=document.getElementById('stretchname').value;
  var difficulty=document.getElementById('difficulty').value;
  var category=document.getElementById('category').value;
  var xmlhttp2 = new XMLHttpRequest();
  xmlhttp2.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
        //document.getElementById("result").innerHTML = this.responseText;
        //getupdatedstretches();
        maxid+=1;
        addstretchtotable(maxid,stretchname,difficulty,category);
      }
  };
  xmlhttp2.open("POST", "addstretch.php?stretchname=" + stretchname+'&difficulty='+difficulty+'&category='+category, true);
  xmlhttp2.send();
}
function deletestretch(stretchid)
{
  var xmlhttp2 = new XMLHttpRequest();
  xmlhttp2.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
        //document.getElementById("result").innerHTML = this.responseText;
        //getupdatedstretches();

        let row = document.getElementById(stretchid);
        row.parentNode.removeChild(row);
      }
  };
  xmlhttp2.open("POST", "deletestretch.php?stretchid=" + stretchid, true);
  xmlhttp2.send();
}

function hidestretch(stretchid)
{
  var xmlhttp2 = new XMLHttpRequest();
  xmlhttp2.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
        document.getElementById("result").innerHTML = this.responseText;
        getupdatedstretches();
      }
  };
  xmlhttp2.open("POST", "hidestretch.php?stretchid=" + stretchid, true);
  xmlhttp2.send();
}

function showallstretches()
{
  for(let i=0;i<hidden_arr.length;i++)
  {
    hidden_arr[i]=false;
  }
  displaystretches();
}

function checkstretchcount()
{
  var xmlhttp3 = new XMLHttpRequest();
  xmlhttp3.onreadystatechange = function()
  {
      if (this.readyState == 4 && this.status == 200)
      {
        curstretchcount=this.responseText;
        if(curstretchcount!=newstretchcount)
        {
          getupdatedstretches();
        }
        newstretchcount=curstretchcount;
      }
  };
  xmlhttp3.open("POST", "getstretchcount.php", true);
  xmlhttp3.send();
}

$(document).ready(function()
{
  $('#selecteddifficulty').change(function()
  {
       getupdatedstretches();
   });
   $('#selectedcategory').change(function()
   {
     getupdatedstretches();
   });
});

//var myVar = setInterval(getupdatedstretches, 1000);
var stretch_div_new='';
var curstretchcount=0;
var newstretchcount=0;

let stretches=[];
let dr_difficulties=[];
let dr_categories=[];
let hidden_arr=[];
let ids=[];
let maxid=0;

let username="<?php echo $username;?>";
console.log("Username= "+username);
getupdatedstretches();
</script>
</form>
</body>
</html>
