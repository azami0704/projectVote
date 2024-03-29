<?php
include_once "./db/base.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style/bs-css/bootstrap.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css' integrity='sha512-FA9cIbtlP61W0PRtX36P6CGRy0vZs0C2Uw26Q1cMmj3xwhftftymr0sj8/YeezDnRwL9wtWw8ZwtCiTDXlXGjQ==' crossorigin='anonymous'/>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.css' integrity='sha512-cznfNokevSG7QPA5dZepud8taylLdvgr0lDqw/FEZIhluFsSwyvS81CMnRdrNSKwbsmc43LtRd2/WMQV+Z85AQ==' crossorigin='anonymous'/>
  <link rel="stylesheet" href="./style/all.css">
  <title>JUST VOTE!</title>
   <!-- v1.0.8 -->
</head>

<body>
  <?php
//for resume特殊設定
if(isset($_GET['for_resume'])){
  $userData=find('projectvote_users',['account'=>'admin@gmail.com']);
  $_SESSION['user']=$userData;
  update('projectvote_users',['last_login'=>date("Y-m-d H:i:s",strtotime('now'))],$userData['id']);
  insert('projectvote_login',['user_id'=>$userData['id']]);
}


$do = $_GET['do'] ?? "main";
//因為header layout在頂端的關係後面匯入的頁面不能用header()轉址
//將判斷寫到這邊
//在投票頁沒id導到首頁
if($do=="vote_survey" && !isset($_GET['id'])){
  $do= "main";
};


//擋GUEST去會員頁面
if(!isset($_SESSION['user'])){
  if($do=="mysurvey"||$do=="add_survey"||$do=="edit_survey"||$do=="mysurvey_log"){
    $do = "main";
  }
  //GUEST存投票頁id以便登入後導回
  if($do=="vote_survey"){
    setcookie('last_survey_id',$_GET['id'],time()+3600,"/projectVote");
  }
} 
//編輯頁沒id導回我的投票
if($do=="edit_survey" && !isset($_GET['id'])){
  $do = "mysurvey";
}
// print_r($_COOKIE);
// print_r($_SESSION);
//導覽header
include "./layout/header.php";

$file = "./front/{$do}.php";
if (file_exists($file)) {
    include $file;
} else {
    include "./front/main.php";
}
?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="./js/bs-js/bootstrap.js"></script>
<script src="./js/all.js"></script>
</body>
</html>
