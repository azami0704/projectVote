<?php
include_once "../db/base.php";

if(!isset($_POST['id'])){
    header("location:../index.php?status=vote_survey_error");
}
//更新subject票數
$subject = find('projectvote_subject',$_POST['id']);
$subjectVote = $subject['vote']+1;
echo "subject票數:$subjectVote";
update('projectvote_subject',['vote'=>$subjectVote],$_POST['id']);

//更新option票數
foreach($_POST['opt'] as $optId){
    $options = find('projectvote_subject_options',$optId);
    $optionNum=$options['vote']+1;
    // echo "{$options['opt']}選單票數:$optionNum";
    update('projectvote_subject_options',['vote'=>$optionNum],$optId);
}

//抓IP,因CDN問題目前無作用,先寫放著
if (!empty($_SERVER['HTTP_CLIENT_IP']))
    //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    
$userId = $_SESSION['user']['id']??0;
//多選題先都塞在同一個欄位,用','分隔,要的時候再炸開
$opts='';
if(COUNT($_POST['opt'])>1){
    foreach($_POST['opt'] as $key=> $optId){
        if($key==0){
            $opts.="$optId";
        }else{
            $opts.=",$optId";
        }
    }
}else{
    $opts = "{$_POST['opt'][0]}";
}
// echo $opts;
insert('projectvote_log',['user_id'=>$userId,
'subject_id'=>$_POST['id'],
'ip'=>$ip,
'option_id'=>$opts
]);

// print_r(['user_id'=>$userId,
// 'subject_id'=>$_POST['id'],
// 'ip'=>$ip,
// 'option_id'=>$opts
// ]);
header("location:../index.php?do=survey_result&id={$_POST['id']}");

?>