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

?>

<div class="container-xxl mt-4 pb-5">
    <div class="section-tag tag-lg">每日主題投票</div>
        <main class="pt-3">
            <a href="?do=add_survey_daily"class="btn btn-main float-right mb-3"><i class="fa-sharp fa-solid fa-plus"></i></a>
            <div class="clearfix"></div>
    <ul class="list-group list-group-container text-center">
  <li class="list-group-item d-flex align-items-center bg-transparent border-bottom border-3 border-dark p-1" aria-current="true">
    <div class="w-10">日期</div>
    <div class="w-20">主題</div>
    <div class="w-15">人氣</div>
    <div class="w-30">描述</div>
    <div class="w-10">狀態</div>
    <div class="w-15">操作</div>
  </li>
  <!-- 我的投票輸出區 -->
  
  <?php
    $surveyList = all('projectvote_subject_daily'," ORDER BY `start_time` ASC LIMIT $pageStart,$pageSetting");
    $dailySurveyRows = countSql('projectvote_subject_daily');
    if(!empty($surveyList)){
      foreach($surveyList as $dailySurvey){
      // $surveyDetail =  all('projectvote_subject',['id'=>$ownSurvey['subject_id']]);
      // $surveyDetail=$surveyDetail[0];
      // $categoryName= find('projectvote_subject_category',$surveyDetail['category_id'])['category'];
      $title = replaceInput('html',$dailySurvey['title']);
      $description = replaceInput('html',$dailySurvey['description']);
      $now = strtotime("now");
      $startTime = strtotime($dailySurvey['start_time']);
      $date = date("Y-m-d",strtotime($dailySurvey['start_time']));
      $endTime = strtotime($dailySurvey['end_time']);
      if($now>$startTime&&$now<$endTime){
        $active = '進行中';
        $activeClass='text-danger';
      }else if($now<$startTime){
        $active = '未開始';
        $activeClass='text-sub';
      }else if($now>$endTime){
        $active = '已結束';
        $activeClass='text-sub';
      }
      ?>
      <li class="list-group-item d-flex align-items-center border-bottom border-1 border-dark px-1">
      <div class="w-10"><?=$date?></div>
      <div class="w-20 text-collapse"><?=$title?></div>
      <div class="w-15"><?=$dailySurvey['vote']?></div>
      <div class="w-30 text-collapse"><?=$description?></div>
      <div class="w-10 <?=$activeClass?>"><?=$active?></div>
      <div class="w-15">
      <?php
          if($active=='未開始'||$active=='已結束'){
            echo "<a href='?do=daily_survey_list&jsact=del_survey_daily&id={$dailySurvey['id']}' class='btn btn-main me-1'><i class='fa-solid fa-trash-can del-option-btn'></i></a>";
            echo "<a href='?do=edit_survey_daily&id={$dailySurvey['id']}' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>";
          }else{
            echo "<a class='btn btn-main me-1 disable' data-bs-container='body' data-bs-toggle='popover' data-bs-placement='top' data-bs-trigger='hover' data-bs-content='進行中投票無法刪除'><i class='fa-solid fa-trash-can del-option-btn'></i></a>";
            echo "<a href='?do=edit_survey_daily&id={$dailySurvey['id']}' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>";
          }
          echo "<a href='?do=survey_result_daily&id={$dailySurvey['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
      }
        ?>
    </div>
  </li>
    <?php
  }else{
    echo "<li class='list-group-item d-flex align-items-center border-bottom border-1 border-dark'>";
    echo "<div class='w-100'>尚無投票</div>";
    echo "</li>";
  }
  ?>
  <!-- 我的投票輸出區 END-->
</ul>
<?php
  include "./layout/pagination.php";
?>
<!-- pagination END-->
</div>
</div>
</main>
</div>
