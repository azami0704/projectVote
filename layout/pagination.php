  <?php
  if(!empty($surveyList)){
    ?>
<!-- 顯示筆數控制 -->
<div class="page-control mx-auto w-fit-content py-4">
  <div class="page-list mb-3">
    <?php
    $pages = ceil($surveyRows/$pageSetting);
    echo "總共頁{$surveyRows}筆";
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
  let getPageSheet = pageUrl.get('sheet')?`&sheet=${pageUrl.get('sheet')}`:'';
  let getPageCategory = pageUrl.get('category')?`&category=${pageUrl.get('category')}`:'';

  let pathNameForPageArr = (pathNameForPage.split(/\/|\./));
  let directUrlForPage = 'index';
  if(pathNameForPageArr.indexOf('index')==-1){
    directUrlForPage='admin';
  }
  pageSet.addEventListener('change',(e)=>{
    location.href = `./${directUrlForPage}.php?do=${getPageDo}${getPageSheet}${getPageCategory}&pageSet=${e.target.value}`;
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
//配合各種頁面使用增加變數判斷
$sheet=isset($_GET['sheet'])?"&sheet={$_GET['sheet']}":'';
$category=isset($_GET['category'])?"&category={$_GET['category']}":'';
echo "<li class='page-item $preDisable'><a class='page-link text-dark' href='?do={$_GET['do']}$sheet$category&pageSet={$pageSetting}&page={$prevPage}'><</a></li>";
echo $pagiFirstPage;
for($i=$pagiStart;$i<=$pageEnd;$i++){
    if($i==$pageActive){
        echo "<li class='page-item active'><a class='page-link' href='?do={$_GET['do']}$sheet$category&pageSet={$pageSetting}&page={$i}'>{$i}</a></li>";
    }else{
        echo "<li class='page-item'><a class='page-link text-dark' href='?do={$_GET['do']}$sheet$category&pageSet={$pageSetting}&page={$i}'>{$i}</a></li>";
    }
}
echo $pagiLastPage;
echo "<li class='page-item $nextDisable'><a class='page-link text-dark' href='?do={$_GET['do']}$sheet$category&pageSet={$pageSetting}&page={$nextPage}'>></a></li>";
//頁數輸出 END
?>
<!-- pagination END-->
<?php
  }
  ?>
