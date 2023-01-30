<?php
include_once "./db/base.php";

?>

<header class="admin-nav navbar navbar-dark bg-dark position-fixed px-5 text-center flex-column">
    <!-- Navbar content -->
    <h1 class="text-white my-5">JUST VOTE!</h1>

<ul class="ps-0 mt-5 mb-auto">
  <!-- 下拉選單輸出 -->
  <li class="mb-3"><a class="text-white" href="./admin.php">Dashboard</a></li>
  <li class="mb-3"><a class="text-white" href="./admin.php?do=daily_survey_list">每日投票</a></li>
  <li class="mb-3"><a class="text-white" href="./admin.php?do=admin_survey">投票管理</a></li>
  <li class="mb-3"><a class="text-white" href="./admin.php?do=member_center">個人資料</a></li>
  <li class="mb-3"><a class="text-white" href="./index.php">切換至前台</a></li>
  <!-- 下拉選單輸出 -->
</ul>
<div class="border-bottom border-1 border-dark fw-bold pb-2 mb-2 text-white">
  <span class="me-3">Hi! <?=$_SESSION['user']['name']?></span>
  <a class="text-white" href="./api/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
</div>
</header>
