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
  <title>JUST VOTE!管理後台</title>
</head>

<body>
  <?php
//非管理員導回首頁
if(!isset($_SESSION['user'])||$_SESSION['user']['level']!=0){
  header("location:./index.php");
  }
 

$do = $_GET['do'] ?? "admin_main";

//導覽header
include "./layout/header_admin.php";

$file = "./back/{$do}.php";
if (file_exists($file)) {
    include $file;
} else {
    include "./back/admin_main.php";
}
?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="./js/bs-js/bootstrap.js"></script>
<script src="./js/all.js"></script>
</body>
</html>