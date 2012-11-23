<?php

include 'database_info.php';

$con = mysql_connect($host, $username, $pass);

if(!$con){
    echo 'Could not connect to database.';
}else{
    
    mysql_select_db('search') or die('Could not');
    
    if(isset($_GET['q'])){
        $q = $_GET['q'];
        if(strlen($q) > 0){
            $query = "SELECT * FROM user WHERE name LIKE '$q%' LIMIT 5";
            $result = mysql_query($query);
            if(!$result){
                echo "Not query";
            }else{
                $count = 0;
                echo "<div class='result-items'>";
                while($row = mysql_fetch_array($result)){
                    echo "<div class='mf_ohd'>";
                    $count++;
                    if($count<4){
                        $res2 = mysql_query("SELECT * FROM photo WHERE user_id='".$row['id']."'"); 
                        if(mysql_num_rows($res2)>0){    
                            while($row2 = mysql_fetch_array($res2)){
                                echo "<a style='position: relative; z-index: 8; background-image: url(".$row2['small_name'].");' class='mf_a90 booster-sc mf_fll mr30' type='booster'></a>";
                            }    
                        }else{
                             echo "<a style='position: relative; z-index: 8;' class='mf_a90 booster-sc mf_fll mr30' type='booster'></a>";
                        }
                        echo "<div style='position: relative; height: 90px;'>";
                        echo "<a class='name' href='#'>".$row['name']."</a><br />";
                        echo "<p>".$row['age']."</p>";
                        echo "<p>".$row['country']."</p>";
                        echo "<p>".$row['sex']."</p>";
                        echo "</div>";    
                    }
                    echo "</div>";
                    echo "<p class='hr_dsh'></p>";
                }
                echo "</div>";
                if($count>3){
                    echo "<div class='more'><a href='more.php?n=".$q."'>All list</a></div>";
                }
            }
            mysql_free_result($result);
        }
    }
}
mysql_close($con);

?>