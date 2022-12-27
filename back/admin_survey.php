<?php
include_once "./db/base.php";

// 新增投票按鈕
// 我的投票清單(點擊編輯)
// 私人投票
// 用頁籤分

if(!isset($_GET['sheet'])){
  $_GET['sheet']="own_list";
}
$listSet = $_GET['sheet'];
if($listSet=="own_list"){
  $ownList = "active";
  $privateList = '';
  $allList = '';
  $identity=0;
}else if($listSet=="private_list"){
  $ownList = '';
  $privateList = "active";
  $allList = '';
  $identity=1;
}else{
  $ownList = '';
  $privateList = '';
  $allList = "active";
  $identity='';
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
    <div class="section-tag tag-lg">投票管理</div>
      <main class="pt-3">
            <a href="?do=admin_survey&sheet=own_list" class="btn btn-sheet-tag <?=$ownList?>">我發起的投票</a>
            <a href="?do=admin_survey&sheet=private_list" class="btn btn-sheet-tag <?=$privateList?>">私人投票</a>
            <a href="?do=admin_survey&sheet=all_list" class="btn btn-sheet-tag <?=$allList?>">全站投票</a>
            <a href="?do=add_survey"class="btn btn-main float-right ms-auto"><i class="fa-sharp fa-solid fa-plus"></i></a>
            <div class="clearfix"></div>
  <ul class="list-group list-group-container text-center">
  <li class="list-group-item d-flex align-items-center bg-transparent border-bottom border-3 border-dark p-1" aria-current="true">
    <div class="w-5"></div>
    <div class="w-20">主題</div>
    <div class="w-15">人氣</div>
    <div class="w-30">描述</div>
    <div class="w-15">狀態</div>
    <div class="w-15">操作</div>
  </li>
  <!-- 我的投票輸出區 -->
  <?php
  //若為全站投票管理就撈全部
  if($identity!=''){
    $ownSurveyList = all('projectvote_subject_users',['account'=>$_SESSION['user']['account'],'auth'=>$identity]," LIMIT $pageStart,$pageSetting");
    $ownSurveyRows = countSql('projectvote_subject_users',['account'=>$_SESSION['user']['account'],'auth'=>$identity]);
  }else{
    $ownSurveyList = all('projectvote_subject_users'," LIMIT $pageStart,$pageSetting");
    $ownSurveyRows = countSql('projectvote_subject_users');
  }
  //清單不是空的就開始印
    if(!empty($ownSurveyList)){
      foreach($ownSurveyList as $ownSurvey){
      $surveyDetail =  find('projectvote_subject',['id'=>$ownSurvey['subject_id']]);
      $categoryName= find('projectvote_subject_category',$surveyDetail['category_id'])['category'];
      $title = replaceInput('html',$surveyDetail['title']);
      $description = replaceInput('html',$surveyDetail['description']);
      $now = strtotime("now");
      $startTime = strtotime($surveyDetail['start_time']);
      $endTime = strtotime($surveyDetail['end_time']);
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
      <div class="w-5"><?=$categoryName?></div>
      <div class="w-20 text-collapse"><?=$title?></div>
      <div class="w-15"><?=$surveyDetail['vote']?></div>
      <div class="w-30 text-collapse"><?=$description?></div>
      <div class="w-15 <?=$activeClass?>"><?=$active?></div>
      <div class="w-15">
        <?php
        //撈取個人投過的投票
        $logs = all('projectvote_log',['user_id'=>$_SESSION['user']['id']]);
        $votedList = [];
        if(!empty($logs[0])){
          foreach($logs as $log){ 
            $votedList[]=$log['subject_id'];
          }
        }
        if($identity==0){
          //個人發起的投票有印刪除及編輯鈕
          if($active=='未開始'||$active=='已結束'){
            //未開始及已結束的投票才能進行刪除
            echo "<a href='?do=admin_survey&jsact=del_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-trash-can del-option-btn'></i></a>";
            echo "<a href='?do=edit_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>";
          }else{
            //進行中的投票鎖刪除鈕並顯示提示
            echo "<a class='btn btn-main me-1 disable' data-bs-container='body' data-bs-toggle='popover' data-bs-placement='top' data-bs-trigger='hover' data-bs-content='進行中投票無法刪除'><i class='fa-solid fa-trash-can del-option-btn'></i></a>";
            echo "<a href='?do=edit_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>";
          }
          //管理員只能看結果,要投票只能去前台
          echo "<a href='index.php?do=vote_survey&id={$surveyDetail['id']}' class='btn btn-main me-1' data-bs-container='body' data-bs-toggle='popover' data-bs-placement='top' data-bs-trigger='hover' data-bs-content='至前台投票'><i class='fa-solid fa-check-to-slot'></i></a>";
          echo "<a href='?do=survey_result&id={$surveyDetail['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
        }else if($identity==''){
          if($active=='未開始'||$active=='已結束'){
            echo "<a href='?do=admin_survey&jsact=del_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-trash-can del-option-btn'></i></a>";
            echo "<a href='?do=edit_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>";
            echo "<a href='?do=survey_result&id={$surveyDetail['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
          }else{
            echo "<a class='btn btn-main me-1 disable' data-bs-container='body' data-bs-toggle='popover' data-bs-placement='top' data-bs-trigger='hover' data-bs-content='進行中投票無法刪除'><i class='fa-solid fa-trash-can del-option-btn'></i></a>";
            echo "<a href='?do=edit_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>";
            echo "<a href='?do=survey_result&id={$surveyDetail['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
          }
        }else{
          echo "<a href='index.php?do=vote_survey&id={$surveyDetail['id']}' class='btn btn-main me-1' data-bs-container='body' data-bs-toggle='popover' data-bs-placement='top' data-bs-trigger='hover' data-bs-content='至前台投票'><i class='fa-solid fa-check-to-slot'></i></a>";
          echo "<a href='?do=survey_result&id={$surveyDetail['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
        }
      }
        ?>
    </div>
  </li>
    <?php
  }else{
    //清單如果是空的就顯示無投票
    echo "<li class='list-group-item d-flex align-items-center border-bottom border-1 border-dark'>";
    echo "<div class='w-100'>尚無投票</div>";
    echo "</li>";
  }
  ?>
    </ul>
    <!-- 投票輸出區 END -->
  <?php
  if(!empty($ownSurveyList)){
    ?>
<!-- 顯示筆數控制 -->
<div class="page-control mx-auto w-fit-content py-4">
  <div class="page-list mb-3">
    <?php
    $pages = ceil($ownSurveyRows/$pageSetting);
    echo "總共頁{$ownSurveyRows}筆";
    echo "每頁";
    echo "<select name='pageSet' id='pageSet'>";
    foreach($pageRange as $range){
      if($range==$pageSetting){
        echo "<option value='$range' selected>$range</option>";
      }else{
        echo "<option value='$range'>$range</option>";
      }
    }
    echo "</select>筆，";
    echo "共{$pages}頁";
    ?>
<script>
  const pageUrl = new URLSearchParams(window.location.search);
  const pathNameForPage = window.location.pathname; 
  const pageSet = document.getElementById('pageSet');
  let getPageDo = pageUrl.get('do');
  let getPageSheet = pageUrl.get('sheet');

  let pathNameForPageArr = (pathNameForPage.split(/\/|\./));
  let directUrlForPage = 'index';
  if(pathNameForPageArr.indexOf('index')==-1){
    directUrlForPage='admin';
  }
  pageSet.addEventListener('change',(e)=>{
    location.href = `./${directUrlForPage}.php?do=${getPageDo}&sheet=${getPageSheet}&pageSet=${e.target.value}`;
  })
</script>
<!-- 顯示筆數控制 END-->
</div>
<div class="pagination w-fit-content mx-auto border border-1 border-dark text-black">
<!-- pagination -->
<?php
//上一頁下一頁
$prevPage = $pageActive-1;
$nextPage = $pageActive+1;
$preDisable = '';
$nextDisable = '';
if($pages==1){
    $nextPage = $pages;
    $prevPage = $pages;
    $nextDisable = "disable";
    $preDisable = "disable";
}else if($pageActive==1){
    $prevPage = 1;
    $preDisable = "disable";
}else if($pageActive==$pages){
    $nextPage = $pages;
    $nextDisable = "disable";
}
//一次顯示幾頁
$pagiRange =10;
if($pages>$pagiRange){
    if($pageActive > 5 && $pages-$pageActive>4){
        $pagiStart=$pageActive-4;
        $pagiFirstPage = "<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}&sheet={$_GET['sheet']}&pageSet={$pageSetting}&page=1'>1</a></li>...";
        $pagiLastPage = "...<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}&sheet={$_GET['sheet']}&pageSet={$pageSetting}&page={$pages}'>{$pages}</a></li>";
    }else if($pageActive > 5){
        $pagiStart=$pages-($pagiRange-2);
        $pagiFirstPage = "<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}&sheet={$_GET['sheet']}&pageSet={$pageSetting}&page=1'>1</a></li>...";
        $pagiLastPage = '';
    }else{
        $pagiStart=1;
        $pagiFirstPage = "";
        $pagiLastPage = "...<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}&sheet={$_GET['sheet']}&pageSet={$pageSetting}&page={$pages}'>{$pages}</a></li>";
    }
    $pageEnd = $pagiStart+($pagiRange-2);
}else{
    $pagiStart=1;
    $pageEnd = $pages;
    $pagiFirstPage = '';
    $pagiLastPage = '';
}
//頁數輸出
$_GET['sheet'] = $_GET['sheet']??'';
echo "<li class='page-item $preDisable'><a class='page-link text-dark' href='?do={$_GET['do']}&sheet={$_GET['sheet']}&pageSet={$pageSetting}&page={$prevPage}'><</a></li>";
echo $pagiFirstPage;
for($i=$pagiStart;$i<=$pageEnd;$i++){
    if($i==$pageActive){
        echo "<li class='page-item active'><a class='page-link' href='?do={$_GET['do']}&sheet={$_GET['sheet']}&pageSet={$pageSetting}&page={$i}'>{$i}</a></li>";
    }else{
        echo "<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}&sheet={$_GET['sheet']}&pageSet={$pageSetting}&page={$i}'>{$i}</a></li>";
    }
}
echo $pagiLastPage;
echo "<li class='page-item $nextDisable'><a class='page-link text-dark' href='?do={$_GET['do']}&sheet={$_GET['sheet']}&pageSet={$pageSetting}&page={$nextPage}'>></a></li>";
//頁數輸出 END
?>
<!-- pagination END-->
<?php
  }
  ?>
</div>
</div>
</main>
</div>

