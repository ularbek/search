<?php 

include 'database_info.php';
mysql_connect($host, $username, $pass) or die('Could not connect');
mysql_select_db('search') or die("Database could not connect");

$query = mysql_query("SELECT * FROM user");
$result = array();
while($row = mysql_fetch_array($query)){
    array_push($result, $row);
}

?>
<html>
<head>
<script type="text/javascript" src="jquery.js"></script>
<script>
function showResult(str)
{
    if(str.length > 0){
        $('#search').show();
    }
    if (str.length==0)
    {
        document.getElementById("autosearchList").innerHTML="";
        document.getElementById("autosearchList").style.border="0px";
        return;
    }
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("autosearchList").innerHTML=xmlhttp.responseText;
            document.getElementById("autosearchList").style.border="1px solid #A5ACB2";
        }
    }
    xmlhttp.open("GET","search.php?q="+str,true);
    xmlhttp.send();
}

function showList(str){
    var firstname = document.getElementById("firstname").value;
    var age = document.getElementById("age").value;
    var country = document.getElementById("country").value;
    var sex = document.getElementById("sex").value;
        
    if (str.length==0)
    {
        document.getElementById("list").innerHTML="";
        document.getElementById("list").style.border="0px";
        return;
    }
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("list").innerHTML=xmlhttp.responseText;
            //document.getElementById("list").style.border="1px solid #A5ACB2";
        }
    }
    xmlhttp.open("GET","list.php?n="+firstname+"&age="+age+"&country="+country+"&sex="+sex,true);
    xmlhttp.send();
}
</script>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div id="wrapper">
<div class="header">
    <div class="head_left">
        <form>
            <div>
                <input type="text" id="inputString" size="30" onkeyup="showResult(this.value)" />    
            </div>
            <div class="searchbox" id="search" style="display: none;">
                <div class="searchList" id="autosearchList">
                    
                </div>
            </div>
        </form>

    </div>
    <div class="head_main">
         
    </div>
    
</div>
<div class="main">
    <div class="filter">
        Name: <input type="text" id="firstname" name="firstname" onkeyup="showList(this.value)" /><br />
        Sex: <select id="sex" name="sex" onchange="showList(this.value)">
                <option value="m">male</option>
                <option value="f">female</option>
            </select><br />
        Age: <input type="text" id="age" name="age" onkeyup="showList(this.value)" /><br />
        Country: <input type="text" id="country" name="country" onkeyup="showList(this.value)" /><br />
        <input type="button" value="Query" />
    </div>
    <div class="content_list" id="list">
    <?php foreach($result as $r): ?>
        <div class="mf_ohd">
            <?php
                $res2 = mysql_query("SELECT small_name FROM photo WHERE user_id='".$r['id']."'");
                if(mysql_num_rows($res2) > 0){
                    while($row2 = mysql_fetch_array($res2)){
                    
            ?>
                    <a style="position: relative; z-index: 8; background-image: url('<?php echo $row2['small_name'] ?>');" class="mf_a90 booster-sc mf_fll mr30" type="booster"></a>
                <?php
                    }
                }else{
                ?>
                    <a style="position: relative; z-index: 8;" class="mf_a90 booster-sc mf_fll mr30" type="booster"></a>
                <?php
                }
                ?>   
                
            <div style="position: relative; height: 90px;">
                <a class="name" href="#"><?php echo $r['name']; ?></a><br />
                <p><?php echo $r['age']; ?></p>
                <p><?php echo $r['country']; ?></p>
                <p><?php echo $r['sex']; ?></p>
            </div>
            </div>
        <p class="hr_dsh"></p>
    <?php endforeach; ?>
    </div>
</div>
<div class="footer">

</div>
</div>
</body>
</html>
<?php mysql_close(); ?>