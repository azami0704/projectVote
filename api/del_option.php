<?php
include_once "../db/base.php";

$directUrl = "index";
if(isset($_GET['admin'])){
    $directUrl = "admin";
}
//刪除選單
if(!isset($_GET['id'])){
    header("location:../$directUrl.php?do=edit_survey&id={$_GET['subject_id']}&status=del_option_fail");
}
$res = del('projectvote_subject_options',$_GET['id']);
if($res){
    header("location:../$directUrl.php?do=edit_survey&id={$_GET['subject_id']}&status=del_option_success");
}
?>