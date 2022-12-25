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
    $surveyLogList = all('projectvote_log',['user_id'=>$_SESSION['user']['id']]," LIMIT $pageStart,$pageSetting");
    $ownSurveyRows = countSql('projectvote_log',['user_id'=>$_SESSION['user']['id']]);
    if(!empty($surveyLogList)){
    foreach($surveyLogList as $surveyLog){
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
