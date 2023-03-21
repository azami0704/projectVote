<?php
include_once "./db/base.php";

// 新增投票按鈕
// 我的投票清單(點擊編輯)
// 私人投票
// 用頁籤分

if (!isset($_GET['sheet'])) {
  $_GET['sheet'] = "own_list";
}
$listSet = $_GET['sheet'];
if ($listSet == "own_list") {
  $ownList = "active";
  $privateList = '';
  $identity = 0;
} else {
  $ownList = '';
  $privateList = "active";
  $identity = 1;
}

//換頁用變數
$pageSetting = $_GET['pageSet'] ?? 10;
$pageRange = [10, 30, 50, 100];
$pageActive = 1;
$pageStart = $pageActive - 1;
if (isset($_GET['page'])) {
  $pageActive = $_GET['page'];
  $pageStart = ($_GET['page'] - 1) * $pageSetting;
}
?>

<div class="container-xxl mt-4 pb-5">
  <div class="section-tag tag-lg">我的投票</div>
  <main class="pt-3">
    <a href="?do=mysurvey&sheet=own_list" class="btn btn-sheet-tag <?= $ownList ?>">我發起的投票</a>
    <a href="?do=mysurvey&sheet=private_list" class="btn btn-sheet-tag <?= $privateList ?>">私人投票</a>
    <a href="?do=add_survey" class="btn btn-main float-right ms-auto"><i class="fa-sharp fa-solid fa-plus"></i></a>
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
      $surveyList = q("SELECT projectvote_subject.* FROM `projectvote_subject` LEFT JOIN `projectvote_subject_users` ON `projectvote_subject_users`.`subject_id`= `projectvote_subject`.`id` WHERE `projectvote_subject_users`.`account`='{$_SESSION['user']['account']}' AND `projectvote_subject_users`.`auth`='$identity' ORDER BY `end_time` DESC LIMIT $pageStart,$pageSetting");
      $surveyRows = countSql('projectvote_subject_users', ['account' => $_SESSION['user']['account'], 'auth' => $identity]);
      if (!empty($surveyList)) {
        foreach ($surveyList as $surveyDetail) {
          $categoryName = find('projectvote_subject_category', $surveyDetail['category_id'])['category'];
          $title = replaceInput('html', $surveyDetail['title']);
          $description = replaceInput('html', $surveyDetail['description']);
          $now = strtotime("now");
          $startTime = strtotime($surveyDetail['start_time']);
          $endTime = strtotime($surveyDetail['end_time']);
          if ($now > $startTime && $now < $endTime) {
            $active = '進行中';
            $activeClass = 'text-danger';
          } else if ($now < $startTime) {
            $active = '未開始';
            $activeClass = 'text-sub';
          } else if ($now > $endTime) {
            $active = '已結束';
            $activeClass = 'text-sub';
          }
      ?>
          <li class="list-group-item d-flex align-items-center border-bottom border-1 border-dark px-1">
            <div class="w-5"><?= $categoryName ?></div>
            <div class="w-20 text-collapse"><?= $title ?></div>
            <div class="w-15"><?= $surveyDetail['vote'] ?></div>
            <div class="w-30 text-collapse"><?= $description ?></div>
            <div class="w-15 <?= $activeClass ?>"><?= $active ?></div>
            <div class="w-15">
            <?php
            if ($identity == 0) {
              if ($active == '未開始' || $active == '已結束') {
                echo "<a href='?do=mysurvey&jsact=del_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-trash-can del-option-btn'></i></a>";
                echo "<a href='?do=edit_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>";
              } else {
                echo "<a class='btn btn-main me-1 disable' data-bs-container='body' data-bs-toggle='popover' data-bs-placement='top' data-bs-trigger='hover' data-bs-content='進行中投票無法刪除'><i class='fa-solid fa-trash-can del-option-btn'></i></a>";
                echo "<a href='?do=edit_survey&id={$surveyDetail['id']}' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>";
              }
            }
            $logs = all('projectvote_log', ['user_id' => $_SESSION['user']['id']]);
            $votedList = [];
            foreach ($logs as $log) {
              $votedList[] = $log['subject_id'];
            }
            if (in_array($surveyDetail['id'], $votedList)) {
              echo "<a href='?do=survey_result&id={$surveyDetail['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
            } else {
              echo "<a href='?do=vote_survey&id={$surveyDetail['id']}' class='btn btn-main'><i class='fa-solid fa-check-to-slot'></i></a>";
            }
          }
            ?>
            </div>
          </li>
        <?php
      } else {
        echo "<li class='list-group-item d-flex align-items-center border-bottom border-1 border-dark'>";
        echo "<div class='w-100'>尚無投票</div>";
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