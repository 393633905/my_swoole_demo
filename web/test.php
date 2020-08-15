<?php
for($i=1;$i<=4;$i++){
    echo $i."&nbsp;";
    for($j=2;$j<=8;$j++){
        echo $j."&nbsp;";
    }
    echo "<br>";
}
unset($i);
unset($j);
?>

<table>
    <?php
        for($i=1;$i<=4;$i++){
            echo "<tr>";
            for($j=1;$j<=6;$j++){
                echo "<td>{$i}*{$j}</td>";
            }
            echo "</tr>";
        }
        unset($i);
        unset($j);
    ?>
</table>


<?php
	/*
		案例4：公鸡5元一只，母鸡3元一只，小鸡1元3只，100元买了100只鸡，问各多少只？
		穷举思想:买了100只公鸡，100只母鸡，100只小鸡
    */
    
    $jisuan=function(){
        static $count=0;
        for($i=1;$i<=100/5;$i++){//公鸡最多买20只
            for($j=1;$j<=floor(100/3);$j++){//母鸡最多买100/3=30只
                $k=100-$i-$j;
                if($k % 3!=0){
                    continue;
                }
                $count++;
                if(5*$i+3*$j+1/3*$k==100){
                    echo "公鸡：{$i},母鸡：{$j},小鸡：{$k}"."<br>";
                }
            }
        }
        echo "执行的次数：{$count}";
    };

    $jisuan();
 


    $str3='abcdefg';
    var_dump(strpos($str3,'x'))."<br>";

    function fun(){
        static $n=1;
        return $n=$n+1;
    }

 
    
    
    $arrs = array(11, 18, 21, 14, 8);
    $max=$arrs[0];
    $max_index=0;
    foreach($arrs as $key=>$arr){
        if($arr>$max){
            $max=$arr;
            $max_index=$key;
        }
    }

    //echo $max_index;


    for($i=0;$i<count($arrs);$i++){
        echo 'key：'.key($arrs).',value：'.current($arrs)."<br>";
        next($arrs);
    }
 

    reset($arrs);//重置指针


    $data=[
        'name'=>[1,2,3],
        'age'=>[4,5,6]
    ];

    $arrs = array('a'=>11, 18, 21, 14, 8);
    asort($arrs);
    for($i=0;$i<count($arrs);$i++){
        echo 'key：'.key($arrs).',value：'.current($arrs)."<br>";
        next($arrs);
    }
 
?>

