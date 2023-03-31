<?php
//這頁放PDO & PHP functions
session_start();
date_default_timezone_set("Asia/Taipei");
$db = "mysql:local=localhost;charset=utf8;dbname=vote;";
$pdo = new PDO($db,"root","");
// $db = "mysql:local=localhost;charset=utf8;dbname=s1110420;";
// $pdo = new PDO($db,"s1110420","s1110420");


//撈取資料表指定條件全部欄位(多筆)
function all($table,...$args){
    global $pdo;
    $sql = "SELECT * FROM `$table`";

    if(isset($args[0])){
        if(is_array($args[0])){
            $input = [];
            foreach ($args[0] as $key => $value){
                $input[]="`$key`='$value'";
            }
            $sql = $sql." WHERE ".join(' && ',$input);
        }else{
            $sql = $sql . $args[0];
        }

        if(isset($args[1])){
            $sql = $sql . $args[1];
        }
    }
    // echo $sql;
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// 撈取指定條件全部欄位(單筆)
function find($table,$id){
    global $pdo;
    $sql = "SELECT * FROM  `$table`";
    if(is_array($id)){
        $input = [];
        foreach($id as $key => $value){
            $input[]="`$key`='$value'";
        }
        $sql = $sql ." WHERE ". join(" && ",$input);
    }else {
        $sql = $sql . "WHERE `id`='$id'";
    }
    // echo $sql;
    return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}


/*更新指定欄位
*$col為要更新的欄位與值,若不輸入陣列則要輸入完整字串(ex:"`name`='王小明'")
*自行輸入字串若要改多個欄位請自行輸入","
*$col後的參數指定WHERE,僅輸入字串則為id
*/
function update($table,$col,...$args){
    global $pdo;
    $sql = "UPDATE `$table` SET ";
    if(is_array($col)){
        $column = [];
        foreach($col as $key => $value){
            $column[]="`$key`='$value'";
        }
        $sql = $sql . join(" , ",$column);
    }else {
        $sql = $sql.$col;
    }

    if(isset($args[0])){
        if(is_array($args[0])){
            $input = [];
            foreach($args[0] as $key => $value){
                $input[]= "`$key`='$value'";
            }
            $sql = $sql . " WHERE " . join(" && ",$input);
        }else {
            $sql = $sql . " WHERE `id`='".$args[0]."'";
        }
    }
    // echo $sql;
    return $pdo->exec($sql);
}

/*新增資料
*$cols為陣列,會抓出key跟value輸入
*/ 
function insert($table,$cols){
    global $pdo;
    $keys=[];
    $values=[];
    foreach($cols as $key => $value){
        $keys[]="`$key`";
        $values[]="'$value'";
    }
    // print_r($keys);
    $sqlKey = join(',',$keys);
    $sqlValue = join(',',$values);
    $sql = "INSERT INTO `$table`($sqlKey) VALUES ($sqlValue)";
    // echo $sql;
    return $pdo->exec($sql);
}

/*刪除指定資料
*參數二只輸入字串則為id
*/ 
function del($table,$id){
    global $pdo;
    $sql = "DELETE FROM `$table` ";
    if(is_array($id)){
        $input = [];
        foreach($id as $key => $value){
            $input[]="`$key`='$value'";
        }
        $sql = $sql . " WHERE " . join(" && ",$input);
    }else {
        $sql = $sql . " WHERE `id`='$id'";
    }
    // echo $sql;
    return $pdo->exec($sql);
}

/*萬用
*SQL字串要完整的
*/ 
function q($sql){
    global $pdo;
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

/*統計指定條件筆數
*指定條件僅限陣列或沒有條件
*/
function countSql($table,...$arg){
    global $pdo;
    $sql = "SELECT COUNT(*) FROM `$table`";
    $input=[];
    if(isset($arg[0])){
        if(is_array($arg[0])){
            foreach($arg[0] as $key => $value){
                $input[]="`$key` = '$value'";
            }
            $sql.=" WHERE ".join(" AND ",$input);
        }else{
            $sql.=$arg[0];
        }
    }
    if(isset($arg[1])){
        $sql .= $arg[1];
    }
    // echo $sql;
    return $pdo->query($sql)->fetchColumn();
} 

//將撈出的二維陣列轉一維陣列
function myReduce($arr,$keys,$val){
    $result = [];
    foreach($arr as $value){
        $result[$value[$keys]]=$value[$val];
    }
    return $result;
}

//新增主題亂數checkNum的函式,10碼有機率超過int上限,長度最多9碼
function randomStr($length){
    $str="";
    for ($i=1; $i <=$length ; $i++) { 
        $str=$str.random_int(0,9);
    }
    return $str;
}

/*輸入&輸出用dataWash
*分成洗sql或html,以第一個參數帶字串設定
*回傳replace過的字串
*/ 
function replaceInput($action,$str){
    $action=strtolower($action);
    switch($action){
        case 'sql':
            return preg_replace('/([\'"]|\\\\|[--])/', '\\\\$1',$str);
        break;
        case 'html':
            return preg_replace(['/</','/>/'], ['&lt;','&gt;'],$str);
        break;
        default:
        echo '請確認參數1字串否正確';
    }
}

/*計算是否為活動區間*/
function dateCheck($startTime,$endTime){
    $now = strtotime('now');
    $startDate = strtotime($startTime);
    $endDate = strtotime($endTime);
    if($now>$startDate && $now<$endDate){
        return '進行中';
      }else if($now<$startDate){
        return '未開始';
      }else if($now>$endDate){
        return '已結束';
      }
} 

?>