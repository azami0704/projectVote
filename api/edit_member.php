<?php
include_once "../db/base.php";


$directUrl = "index";
if(isset($_GET['admin'])){
    $directUrl = "admin";
}
if(isset($_POST['id'])){
    $mailCheck=all('projectvote_users',['email'=>$_POST['email']]);
    // print_r($mailCheck);
    // print_r($_POST);
    if(count($mailCheck)>1||!empty($mailCheck) && $mailCheck[0]['account']!=$_POST['account']){
        header("location:../$directUrl.php?do=member_center&status=email_used");
    }else{
        $name= replaceInput('sql',$_POST['name']);
        $tel= $_POST['tel']??0;
        $res = update('projectvote_users',['name'=>$name,'tel'=>$tel],$_POST['id']);
        header("location:../$directUrl.php?do=member_center&status=edit_member_success");
    }
}
?>