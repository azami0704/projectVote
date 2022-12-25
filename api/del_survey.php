<?php
include_once "../db/base.php";

$_POST = json_decode(file_get_contents("php://input"),true);

if(isset($_POST['id'])){
    if(!empty($_POST['table'])){
        del('projectvote_subject_daily',$_POST['id']);
        del('projectvote_subject_daily_options',['subject_id'=>$_POST['id']]);
        del('projectvote_log',['daily_subject_id'=>$_POST['id']]);
    }else{
        del('projectvote_subject',$_POST['id']);
        del('projectvote_subject_users',['subject_id'=>$_POST['id']]);
        del('projectvote_subject_options',['subject_id'=>$_POST['id']]);
        del('projectvote_log',['subject_id'=>$_POST['id']]);
    }

    echo 'delete_success';
}else{
    echo 'id_not_found';
}

?>