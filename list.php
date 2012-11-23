<?php

include 'database_info.php';

$con = mysql_connect($host, $username, $pass);

if(!$con){
    echo 'Could not connect to database.';
}else{    
    mysql_select_db('search') or die('Could not');
    
    if(isset($_GET['n']) || isset($_GET['age']) || isset($_GET['country']) || isset($_GET['sex'])){
        $firstname = $_GET['n'];
        $age = $_GET['age'];
        $country = $_GET['country'];
        $sex = $_GET['sex'];
        
        if(strlen($firstname)>0 || strlen($age)>0 || strlen($country)>0){
            $result = mysql_query("SELECT * FROM user where name LIKE '$firstname%' AND age LIKE '$age%' AND country LIKE '$country%' AND sex LIKE '$sex%'");
            if(!$result){
                echo "Not query";
            }else{
                while($row = mysql_fetch_array($result)){
                    echo "<div class='mf_ohd'>";  
                    $res2 = mysql_query("SELECT small_name FROM photo WHERE user_id='".$row['id']."'");
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
                    echo "</div>";
                    echo "<p class='hr_dsh'></p>";
                }
                
            }
            mysql_free_result($result);
        }
    }
}
mysql_close($con);

?>