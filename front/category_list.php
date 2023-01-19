<?php
include_once "./db/base.php";

//換頁用變數
$pageSetting = $_GET['pageSet']??10;
$pageRange = [10,30,50,100];
$pageActive = 1;
$pageStart = $pageActive - 1;
if(isset($_GET['page'])){
  $pageActive=$_GET['page'];
  $pageStart = ($_GET['page']-1)*$pageSetting;
}
//分類搜尋頁
$date=date("Y-m-d H:i:s",strtotime('now'));
$surveyList = all('projectvote_subject',['category_id'=>$_GET['category']]," AND `private`='0' AND `start_time`<='$date' LIMIT $pageStart,$pageSetting");
$categoryName= find('projectvote_subject_category',$_GET['category'])['category'];
$surveyRows = countSql('projectvote_subject',['category_id'=>$_GET['category']]," AND `private`='0' AND `start_time`<='$date'");
?>
<div class="container-xxl mt-4 pb-5">
    <div class="section-tag tag-lg mb-4"><?=$categoryName?>投票</div>
    <ul class="list-group list-group-container text-center ">
  <li class="list-group-item d-flex align-items-center bg-transparent border-bottom border-3 border-dark p-1" aria-current="true">
    <div class="w-20">主題</div>
    <div class="w-15">人氣</div>
    <div class="w-30">描述</div>
    <div class="w-10">狀態</div>
    <div class="w-15">最近一次投票</div>
    <div class="w-10">操作</div>
  </li>
  <!-- 投票輸出區 -->
  
  <?php
    if(!empty($surveyList)){
    foreach($surveyList as $survey){
    $dateStatus = dateCheck($survey['start_time'],$survey['end_time']);
    $title = replaceInput('html',$survey['title']);
    $description = replaceInput('html',$survey['description']);
    ?>
    <li class="list-group-item d-flex align-items-center border-bottom border-1 border-dark px-1">
    <div class="w-20 text-collapse"><?=$title?></div>
    <div class="w-15"><?=$survey['vote']?></div>
    <div class="w-30 text-collapse"><?=$description?></div>
    <div class="w-10"><?=$dateStatus?></div>
    <div class="w-15 fs-6 "><?=$survey['update_at']?></div>
    <div class="w-10">
      <?php
      echo "<a href='?do=survey_result&id={$survey['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
      ?>
    </div>
  </li>
    <?php
    }
  }else{
    echo "<li class='list-group-item d-flex align-items-center border-bottom border-1 border-dark'>";
    echo "<div class='w-100'>此分類尚無投票!</div>";
    echo "</li>";
  }
  ?>
  <!-- 投票輸出區 END-->
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