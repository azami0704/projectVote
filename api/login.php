<?php
include_once "../db/base.php";

//JS送上來$_POST是空的,以此判斷是PHP登入頁登入還是JS呼叫
if(!empty($_POST)){
    if(isset($_POST['account'])){
        $userData=find('projectvote_users',['account'=>$_POST['account']]);
        if(!empty($userData)){
            if($userData['password']==$_POST['password']){
                $_SESSION['user']=$userData;
                update('projectvote_users',['last_login'=>date("Y-m-d H:i:s",strtotime('now'))],$userData['id']);
                insert('projectvote_login',['user_id'=>$userData['id']]);
                // echo "login_success";
                if($userData['level']==0){
                    header("location:../admin.php");
                }else{
                    if(!empty($_COOKIE['last_survey_id'])){
                        $id = $_COOKIE['last_survey_id'];
                        setcookie('last_survey_id','',time()-3600,"/projectVote");
                        header("location:../index.php?do=vote_survey&id=$id");
                    }else{
                        header("location:../index.php");
                    }
                }
            }else{
                // echo "password_error";
                header("location:../index.php?do=login&status=password_error");
            }
        }else{
            // echo "account_not_found";
            header("location:../index.php?do=login&status=account_not_found");
        }
        
    }else{
        // echo "login_fail";
        header("location:../index.php?do=login&status=login_fail");
    }
}else{
    // JS API
    // PHP不支援JSON,要轉譯
    $_POST = json_decode(file_get_contents("php://input"),true);
    
    if(isset($_POST['account'])){
        $userData=find('projectvote_users',['account'=>$_POST['account']]);
        if(!empty($userData)){
            if($userData['password']==$_POST['password']){
                $_SESSION['user']=$userData;
                update('projectvote_users',['last_login'=>date("Y-m-d H:i:s",strtotime('now'))],$userData['id']);
                insert('projectvote_login',['user_id'=>$userData['id']]);
                if($userData['level']==0){
                    setcookie('last_survey_id','',time()-3600,"/projectVote");
                    echo "admin_login_success";
                }else{
                    setcookie('last_survey_id','',time()-3600,"/projectVote");
                    echo "login_success";
                }
                // header("location:../index.php?status=login_success");
            }else{
                echo "password_error";
            }
        }else{
            echo "account_not_found";
            // header("location:../index.php?status=account_not_found");
        }
        
    }else{
        echo "login_fail";
        // header("location:../index.php?status=login_fail");
    }
}



?>