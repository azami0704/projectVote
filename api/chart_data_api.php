<?php
include_once "../db/base.php";

//last_login==今天user數
//總會員人數
////昨天為止七天內log

//昨天為止七天內登入會員人數
$statDate = date("Y-m-d",strtotime("-7 days"));
$now = date("Y-m-d");
//原用user表單的last_login計算,但發現保存完整的登陸時間紀錄
//開另外一張表單更新用戶每次成功登入時間並使用該表單連表查詢同一天只計算一次登入次數
$lastLogin =  q("SELECT `G1`.`date` ,COUNT(*)AS 'count' FROM (SELECT DATE(`login_time`)AS 'date' ,COUNT(*)AS 'count' FROM `projectvote_login` WHERE `login_time` BETWEEN '$statDate' AND '$now' GROUP BY `user_id`,DATE(`login_time`))AS G1 GROUP BY `G1`.`date`");
$weekDate = [];
for($i=1;$i<=7;$i++){
    array_unshift($weekDate,date("Y-m-d",strtotime("-$i days")));
}


$dailyLogin = myReduce($lastLogin,'date','count');

$allUsers = q("SELECT COUNT(*)AS 'users' FROM `projectvote_users`")[0];
$newUsers = q("SELECT DATE(`created_at`)AS 'reg_date' ,COUNT(*)AS 'count' FROM `projectvote_users` WHERE `created_at` BETWEEN '$statDate' AND '$now' GROUP BY DATE(`created_at`)");

$newReg = myReduce($newUsers,'reg_date','count');
// print_r($allUsers);
// print_r($newUsers);

$votedLogs = q("SELECT DATE(`created_at`)AS 'vote_date', COUNT(*)AS 'voted' FROM `projectvote_log` WHERE `created_at` BETWEEN '$statDate' AND '$now' GROUP BY DATE(`created_at`)");

$voted = myReduce($votedLogs,'vote_date','voted');

foreach($weekDate as $value){
    if(!isset($dailyLogin[$value])){
        $dailyLogin[$value]=0;
    }
    if(!isset($voted[$value])){
        $voted[$value]=0;
    }
    if(!isset($newReg[$value])){
        $newReg[$value]=0;
    }
}
ksort($dailyLogin);
ksort($voted);
ksort($newReg);
// print_r($dailyLogin);
// print_r($voted);
// print_r($newReg);

//報表抓最近七天,將各資料分開存
$date=[
    'dailyLogin' => $dailyLogin,
    'allUsers' => $allUsers,
    'voted'=>$voted,
    'dailyReg' => $newReg
];

// print_r($date);
$response = json_encode($date);
echo $response;
?>