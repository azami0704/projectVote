<?php
include_once "../db/base.php";

$directUrl = "index";
if(isset($_GET['admin'])){
    $directUrl = "admin";
}
//刪除私人投票會員清單
if(!isset($_GET['account'])){
    header("location:../$directUrl.php?do=edit_survey&id={$_GET['subject_id']}&status=del_member_fail");
}else if(empty($_GET['account'])){
    header("location:../$directUrl.php?do=edit_survey&id={$_GET['subject_id']}");
}

$res = del('projectvote_subject_users',['subject_id'=>$_GET['subject_id'],'account'=>$_GET['account']]);
if($res){
    header("location:../$directUrl.php?do=edit_survey&id={$_GET['subject_id']}&status=del_member_success");
}
?>