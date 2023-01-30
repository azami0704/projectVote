<?php
include_once "./db/base.php";

// 新增投票按鈕
// 我的投票清單(點擊編輯)
// 私人投票
// 用頁籤分

$listSet = $_GET['sheet']??"own_list";
if($listSet=="own_list"){
  $ownList = "active";
  $privateList = '';
  $identity=0;
}else{
  $ownList = '';
  $privateList = "active";
  $identity=1;
}
//換頁用變數
$pageSetting = $_GET['pageSet']??10;
$pageRange = [10,30,50,100];
$pageActive = 1;
$pageStart = $pageActive - 1;
if(isset($_GET['page'])){
  $pageActive=$_GET['page'];
  $pageStart = ($_GET['page']-1)*$pageSetting;
}

?>

<div class="container-xxl mt-4 pb-5">
    <div class="section-tag tag-lg mb-4">投票紀錄</div>
    <ul class="list-group list-group-container text-center">
  <li class="list-group-item d-flex align-items-center bg-transparent border-bottom border-3 border-dark p-1" aria-current="true">
    <div class="w-5"></div>
    <div class="w-20">主題</div>
    <div class="w-15">人氣</div>
    <div class="w-30">描述</div>
    <div class="w-15">投票時間</div>
    <div class="w-15">操作</div>
  </li>
  <!-- 我的投票輸出區 -->
  
  <?php
    $surveyList = all('projectvote_log',['user_id'=>$_SESSION['user']['id']]," LIMIT $pageStart,$pageSetting");
    $surveyRows = countSql('projectvote_log',['user_id'=>$_SESSION['user']['id']]);
    if(!empty($surveyList)){
    foreach($surveyList as $surveyLog){
      if(!empty($surveyLog['subject_id'])){
    $surveyDetail =  all('projectvote_subject',['id'=>$surveyLog['subject_id']]);
    $surveyDetail=$surveyDetail[0];
    $categoryName= find('projectvote_subject_category',$surveyDetail['category_id'])['category'];
    $title = replaceInput('html',$surveyDetail['title']);
    $description = replaceInput('html',$surveyDetail['description']);
    ?>
    <li class="list-group-item d-flex align-items-center border-bottom border-1 border-dark px-1">
    <div class="w-5"><?=$categoryName?></div>
    <div class="w-20 text-collapse"><?=$title?></div>
    <div class="w-15"><?=$surveyDetail['vote']?></div>
    <div class="w-30 text-collapse"><?=$description?></div>
    <div class="w-15 fs-6 "><?=$surveyLog['created_at']?></div>
    <div class="w-15">
    <?php
      echo "<a href='?do=survey_result&id={$surveyDetail['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
      ?>
      <?php
    }else if(!empty($surveyLog['daily_subject_id'])){
      $surveyDetail =  all('projectvote_subject_daily',['id'=>$surveyLog['daily_subject_id']]);
      $surveyDetail=$surveyDetail[0];
      $title = replaceInput('html',$surveyDetail['title']);
      $description = replaceInput('html',$surveyDetail['description']);
    ?>
    <li class="list-group-item d-flex align-items-center border-bottom border-1 border-dark px-1">
    <div class="w-5">每日</div>
    <div class="w-20 text-collapse"><?=$title?></div>
    <div class="w-15"><?=$surveyDetail['vote']?></div>
    <div class="w-30 text-collapse"><?=$description?></div>
    <div class="w-15 fs-6 "><?=$surveyLog['created_at']?></div>
    <div class="w-15">
      <?php
      echo "<a href='?do=survey_result&id={$surveyDetail['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
      ?>
    </div>
  </li>
    <?php
      }
    }
  }else{
    echo "<li class='list-group-item d-flex align-items-center border-bottom border-1 border-dark'>";
    echo "<div class='w-100'>還沒投過票喔!</div>";
    echo "</li>";
  }
  ?>
  <!-- 我的投票輸出區 END-->
</ul>
    <!-- 換頁元件 -->
    <?php
    include "./layout/pagination.php";
    ?>
    <!-- 換頁元件 END-->
</div>
</div>
</main>
</div>
