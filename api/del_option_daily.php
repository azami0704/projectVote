<?php
include_once "../db/base.php";


//刪除選單
if(!isset($_GET['id'])){
    header("location:../admin.php?do=edit_survey_daily&id={$_GET['subject_id']}&status=del_option_daily_fail");
}
$res = del('projectvote_subject_daily_options',$_GET['id']);
if($res){
    header("location:../admin.php?do=edit_survey_daily&id={$_GET['subject_id']}&status=del_option_daily_success");
}
?>