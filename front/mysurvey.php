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
    <div class="section-tag tag-lg">我的投票</div>
        <main class="pt-3">
            <a href="?do=mysurvey&sheet=own_list" class="btn btn-sheet-tag <?=$ownList?>">我發起的投票</a>
            <a href="?do=mysurvey&sheet=private_list" class="btn btn-sheet-tag <?=$privateList?>">私人投票</a>
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
    $ownSurveyList = all('projectvote_subject_users',['account'=>$_SESSION['user']['account'],'auth'=>$identity]," LIMIT $pageStart,$pageSetting");
    $ownSurveyRows = countSql('projectvote_subject_users',['account'=>$_SESSION['user']['account'],'auth'=>$identity]);
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
      <!-- <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover">
  Popover on top
</button> -->
      <li class="list-group-item d-flex align-items-center border-bottom border-1 border-dark px-1">
      <div class="w-5"><?=$categoryName?></div>
      <div class="w-20 text-collapse"><?=$title?></div>
      <div class="w-15"><?=$surveyDetail['vote']?></div>
      <div class="w-30 text-collapse"><?=$description?></div>
      <div class="w-15 <?=$activeClass?>"><?=$active?></div>
      <div class="w-15">
        <?php
        if($identity==0){
          if($active=='未開始'||$active=='已結束'){
            echo "<a href='?do=mysurvey&jsact=del_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-trash-can del-option-btn'></i></a>";
            echo "<a href='?do=edit_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>";
          }else{
            echo "<a class='btn btn-main me-1 disable' data-bs-container='body' data-bs-toggle='popover' data-bs-placement='top' data-bs-trigger='hover' data-bs-content='進行中投票無法刪除'><i class='fa-solid fa-trash-can del-option-btn'></i></a>";
            echo "<a href='?do=edit_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>";
          }
        }
        $logs = all('projectvote_log',['user_id'=>$_SESSION['user']['id']]);
        $votedList = [];
        foreach($logs as $log){
          $votedList[]=$log['subject_id'];
        }
        if(in_array($surveyDetail['id'],$votedList)){
          echo "<a href='?do=survey_result&id={$surveyDetail['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
        }else{
          echo "<a href='?do=vote_survey&id={$surveyDetail['id']}' class='btn btn-main'><i class='fa-solid fa-check-to-slot'></i></a>";
        }
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
</div>
</div>
</main>
</div>

