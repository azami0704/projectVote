<?php
include_once "../db/base.php";

$memberDetail = find('projectvote_users',$_SESSION['user']['id']);


//驗證舊密碼(JS)
if(isset($_GET['check'])){
    if($memberDetail['password']==$_GET['check']){
        echo "check_password_success";
    }else{
        echo "check_password_fail";
    }
}
$directUrl = "index";
if(isset($_POST['admin'])){
    $directUrl = "admin";
}
//修改密碼
if(isset($_POST['password'])){
    $res= update('projectvote_users',['password'=>$_POST['password']],$memberDetail['id']);
    if($res){
        unset($_SESSION['user']);
        setcookie('last_survey_id','',time()-3600,"/projectVote");
        header("location:../index.php?do=login&status=change_password_success");
    }else{
        header("location:../$directUrl.php?do=edit_password&id={$memberDetail['id']}status=change_password_fail");
    }
}
?>