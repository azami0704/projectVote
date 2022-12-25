<?php
include_once "../db/base.php";

$directUrl = "index.php?do=mysurvey&status=edit_survey_success";
if(isset($_POST['admin'])){
    $directUrl = "admin.php?do=admin_survey&status=edit_survey_success";
}
if(!isset($_POST['id'])){
    header("location:../$directUrl");
}
//data wash
$title = replaceInput('sql',$_POST['title']);
$description = replaceInput('sql',$_POST['description']);
$startTime =date("Y-m-d",strtotime($_POST['start_time']));
$endTime =date("Y-m-d",strtotime($_POST['end_time'])). " 23:59:59";
//將資料更新到subject table
update('projectvote_subject',['title'=>$title,
'description'=>$description,
'type'=>$_POST['type'],
'private'=>$_POST['private'],
'category_id'=>$_POST['category_id'],
'start_time'=>$startTime,
'end_time'=>$endTime
],$_POST['id']);

// print_r(['title'=>$title,
// 'description'=>$description,
// 'type'=>$_POST['type'],
// 'private'=>$_POST['private'],
// 'category_id'=>$_POST['category_id'],
// 'start_time'=>$startTime,
// 'end_time'=>$endTime
// ]);

//如果是指定會員私人投票
if($_POST['private']==2){
    //更新私人會員
    if(isset($_POST['member'])){
        foreach($_POST['member'] as $key=>$value){
            // echo "id=".$_POST['member_id'][$key];
            // echo "account=$value";
            update('projectvote_subject_users',['account'=>$value],$_POST['member_id'][$key]);
        }
    }
    //新增私人會員
    if(isset($_POST['member_new'])){
        foreach($_POST['member_new'] as $value){
            if($value){
                // echo "sunject_id=".$_POST['id'];
                // echo "account=$value";
                insert('projectvote_subject_users',['subject_id'=>$_POST['id'],'account'=>$value,'auth'=>1]);
            }
        }
    }
}




//修改舊選項
foreach($_POST['opt'] as $key=>$value){
    // echo "id=".$_POST['opt_id'][$key];
    // echo "opt=$value";
    update('projectvote_subject_options',['opt'=>$value],$_POST['opt_id'][$key]);
}

//新增新選項
if(isset($_POST['opt_new'])){
    foreach($_POST['opt_new'] as $value){
        if($value){
            // echo "opt=$value";
            insert('projectvote_subject_options',['subject_id'=>$_POST['id'],'opt'=>$value]);
        }
    }
}

header("location:../$directUrl");



?>

