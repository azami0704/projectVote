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
    $dailySurveyList = all('projectvote_subject_daily'," ORDER BY `start_time` ASC LIMIT $pageStart,$pageSetting");
    $dailySurveyRows = countSql('projectvote_subject_daily');
    if(!empty($dailySurveyList)){
      foreach($dailySurveyList as $dailySurvey){
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
if(!empty($dailySurveyList)){
  ?>
<!-- 顯示筆數控制 -->
<div class="page-control mx-auto w-fit-content py-4">
  <div class="page-list mb-3">
    <?php
    $pages = ceil($dailySurveyRows/$pageSetting);
    echo "總共頁{$dailySurveyRows}筆";
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

  let pathNameForPageArr = (pathNameForPage.split(/\/|\./));
  let directUrlForPage = 'index';
  if(pathNameForPageArr.indexOf('index')==-1){
    directUrlForPage='admin';
  }
  pageSet.addEventListener('change',(e)=>{
    location.href = `./${directUrlForPage}.php?do=${getPageDo}&pageSet=${e.target.value}`;
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
        $pagiFirstPage = "<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}&pageSet={$pageSetting}&page=1'>1</a></li>...";
        $pagiLastPage = "...<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}&pageSet={$pageSetting}&page={$pages}'>{$pages}</a></li>";
    }else if($pageActive > 5){
        $pagiStart=$pages-($pagiRange-2);
        $pagiFirstPage = "<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}&pageSet={$pageSetting}&page=1'>1</a></li>...";
        $pagiLastPage = '';
    }else{
        $pagiStart=1;
        $pagiFirstPage = "";
        $pagiLastPage = "...<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}&pageSet={$pageSetting}&page={$pages}'>{$pages}</a></li>";
    }
    $pageEnd = $pagiStart+($pagiRange-2);
}else{
    $pagiStart=1;
    $pageEnd = $pages;
    $pagiFirstPage = '';
    $pagiLastPage = '';
}
//頁數輸出
echo "<li class='page-item $preDisable'><a class='page-link text-dark' href='?do={$_GET['do']}&pageSet={$pageSetting}&page={$prevPage}'><</a></li>";
echo $pagiFirstPage;
for($i=$pagiStart;$i<=$pageEnd;$i++){
    if($i==$pageActive){
        echo "<li class='page-item active'><a class='page-link' href='?do={$_GET['do']}&pageSet={$pageSetting}&page={$i}'>{$i}</a></li>";
    }else{
        echo "<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}&pageSet={$pageSetting}&page={$i}'>{$i}</a></li>";
    }
}
echo $pagiLastPage;
echo "<li class='page-item $nextDisable'><a class='page-link text-dark' href='?do={$_GET['do']}&pageSet={$pageSetting}&page={$nextPage}'>></a></li>";
//頁數輸出 END
}
?>
<!-- pagination END-->
</div>
</div>
</main>
</div>
