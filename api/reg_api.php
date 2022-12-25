<?php
include_once "../db/base.php";

$tel = $_POST['tel']??NULL;
$accountCheck = find('projectvote_users',['account'=>$_POST['account']]);
if(empty($accountCheck)){
    insert('projectvote_users',['account'=>$_POST['account'],
                                'password'=>$_POST['password'],
                                'name'=>$_POST['name'],
                                'email'=>$_POST['account'],
                                'tel'=>$tel
    ]);
    header("location:../index.php?do=login&status=reg_success");
}else{
    header("location:../index.php?do=reg&status=account_exist");
}

?>