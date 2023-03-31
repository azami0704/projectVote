<?php
include_once "./db/base.php";

if (isset($_SESSION['user'])) {
    $logs = all('projectvote_log', ['user_id' => $_SESSION['user']['id']]);
    $votedId = [];
    $votedDailyID =[];
    foreach ($logs as $log) {
        $votedId[] = $log['subject_id'];
        $votedDailyID[] = $log['daily_subject_id'];
    }
}
$todaySurvey = find('projectvote_subject_daily', ['start_time' => date("Y-m-d")]);
if(!empty($todaySurvey)){
  $img = find('projectvote_upload', $todaySurvey['image']);
  $options = all('projectvote_subject_daily_options', ['subject_id' => $todaySurvey['id']]);
  $imgURL = "./upload/{$img['file_name']}";
  $active = 0;
}else{
  $todaySurvey['id']=0;
  $imgURL='./upload/daily_default.jpg';
  $todaySurvey['title']="今日無投票";
  $options=[['opt'=>'敬請'],['opt'=>'期待']];
  $todaySurvey['end_time']=0;
  $active= 1;
}
$date = date("Y-m-d H:i:s");
$weekStart = date("Y-m-d",strtotime("-5 days"));
$weekEnd = date("Y-m-d",strtotime("+1 days"));
// print_r($todaySurvey);
?>

<div class="container-xxl mt-4 section-h">
    <div class="row h-100 flex-nowrap">
      <!-- 每日投票 -->
      <div class="col-md-8 h-100">
        <a href="?do=vote_survey_daily&id=<?=$todaySurvey['id']?>" class="card w-100 h-100 border-1 border-dark text-dark">
          <div class="img-block overflow-hidden">
            <img src="<?=$imgURL?>" class="card-img-top obj-fit-cover w-100 h-100" alt="投票主題">
          </div>
          <div class="card-body">
            <h5 class="card-title"><?=$todaySurvey['title']?></h5>
            <p class="card-text fs-1 text-center mb-0"><?=replaceInput('html',$options[0]['opt'])?><span class="fs-5">vs</span><?=replaceInput('html',$options[1]['opt'])?></p>
            <footer class="d-flex align-items-end">
              <div class="timer-info ms-auto me-2">距離結束還剩</div>
              <div id="timer" class="fs-2 lh-1"  data-active="<?=$active?>" data-time="<?=$todaySurvey['end_time']?>">--:--:--</div>
            </footer>
          </div>
        </a>
      </div>
      <!-- 每日投票 END-->
      <div class="daily-list col-md-4 d-flex flex-column ps-0 d-none d-md-flex">
        <div class="daily-list-header">
          <h3 class="section-tag">近期每日投票</h3>
        </div>
          <ul class="daily-list-item list-group flex-grow-1 border border-1 border-dark overflow-auto">
            <!-- 近期每日投票 顯示今天-5day+今天+明天共7天-->
            <?php
            $dailyList = all('projectvote_subject_daily'," WHERE `start_time` BETWEEN '$weekStart' AND '$weekEnd' ORDER BY `start_time` ASC");
            foreach($dailyList as $daily){
              $surveyDate = date("m/d",strtotime($daily['start_time']));
              ?>
              <li class="list-group-item row d-flex align-items-center mx-0 ps-2">
                <div class="daily-list-item-title col-2 fs-5 fw-bold text-main px-0"><?=$surveyDate?></div>
                <div class="daily-list-item-title col-7"><?=$daily['title']?></div>
                <?php
                //針對舉行狀態顯示不同按鈕
                if(strtotime($daily['start_time'])>strtotime('now')){
                  echo "<a class='btn btn-main btn-sm col-3 text-nowrap'>敬請期待</a>";
                }else if(strtotime($daily['end_time'])<strtotime('now')){
                  echo "<a href='?do=survey_result_daily&id={$daily['id']}' class='btn btn-main btn-sm col-3 text-nowrap'>看結果</a>";
                }else{
                  if(!empty($votedDailyID) && in_array($daily['id'],$votedDailyID)){
                    echo "<a href='?do=survey_result_daily&id={$daily['id']}' class='btn btn-main btn-sm col-3 text-nowrap'>看結果</a>";
                  }else{
                    echo "<a href='?do=vote_survey_daily&id={$daily['id']}' class='btn btn-main btn-sm col-3 text-nowrap'>投票</a>";
                  }
                }
                ?>
                
              </li>
              <?php
            }
            ?>
            <!-- 近期每日投票 END-->
          </ul>
      </div>
    </div>
  </div>
  <div class="container-xxl mt-4">
  <h2 class="section-tag">熱門投票</h2>
  <ul class="list-group text-center">
  <li class="list-group-item d-flex align-items-center bg-transparent border-bottom border-3 border-dark p-1" aria-current="true">
    <div class="w-5"></div>
    <div class="w-20">主題</div>
    <div class="w-15">人氣</div>
    <div class="w-30">描述</div>
    <div class="w-15">最近投票時間</div>
    <div class="w-15">操作</div>
  </li>
  <!-- 熱門投票輸出區 -->
  <?php
// echo $date;
$hot = q("SELECT * FROM `projectvote_subject` WHERE `private`='0' AND `start_time`<='$date' AND `end_time`>='$date' ORDER BY `projectvote_subject`.`vote` DESC LIMIT 3");
// print_r($hot);
if (empty($hot)) {
    echo "<div class='w-100'>尚無投票</div>";
} else {
    foreach ($hot as $value) {
        $category = find('projectvote_subject_category', $value['category_id']);
        ?>
      <li class="list-group-item d-flex align-items-center border-bottom border-1 border-dark px-1">
      <div class="w-5"><?=$category['category']?></div>
      <div class="w-20 text-collapse"><?=replaceInput('html',$value['title'])?></div>
      <div class="w-15"><?=$value['vote']?></div>
      <div class="w-30 text-collapse"><?=replaceInput('html',$value['description'])?></div>
      <div class="w-15"><?=$value['update_at']?></div>
      <div class="w-15">
        <?php
if (isset($_SESSION['user'])) {
            if (!empty($votedId) && in_array($value['id'], $votedId)) {
                echo "<a href='?do=survey_result&id={$value['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
            } else {
                echo "<a href='?do=vote_survey&id={$value['id']}' class='btn btn-main'><i class='fa-solid fa-check-to-slot'></i></a>";
            }
        } else {
            echo "<a href='?do=vote_survey&id={$value['id']}' class='btn btn-main'><i class='fa-solid fa-check-to-slot'></i></a>";
        }
        ?>
      </div>
    </li>
      <?php
}
}
?>
  <!-- 熱門投票輸出區 END-->
</ul>
  </div>
  <div class="container-xxl mt-4">
  <h2 class="section-tag">最新投票</h2>
  <ul class="list-group text-center border-1 border-dark">
  <li class="list-group-item d-flex align-items-center bg-transparent border-bottom border-3 border-dark p-1" aria-current="true">
    <div class="w-5"></div>
    <div class="w-20">主題</div>
    <div class="w-15">人氣</div>
    <div class="w-30">描述</div>
    <div class="w-15">最近投票時間</div>
    <div class="w-15">操作</div>
  </li>
  <!-- 最新投票輸出區 -->
  <?php
$newSurveys = q("SELECT * FROM `projectvote_subject` WHERE `private`='0' AND `start_time`<='$date' AND `end_time`>='$date' ORDER BY `projectvote_subject`.`start_time` DESC LIMIT 3");
// print_r($hot);
if (empty($newSurveys)) {
    echo "<div class='w-100'>尚無投票</div>";
} else {
    foreach ($newSurveys as $newSurvey) {
        $category = find('projectvote_subject_category', $newSurvey['category_id']);
        ?>
    <li class="list-group-item d-flex align-items-center border-bottom border-1 border-dark px-1">
    <div class="w-5"><?=$category['category']?></div>
    <div class="w-20 text-collapse"><?=replaceInput('html',$newSurvey['title'])?></div>
    <div class="w-15"><?=$newSurvey['vote']?></div>
    <div class="w-30 text-collapse"><?=replaceInput('html',$newSurvey['description'])?></div>
    <div class="w-15"><?=$newSurvey['update_at']?></div>
    <div class="w-15">
    <?php
if (isset($_SESSION['user'])) {
            if (!empty($votedId) && in_array($newSurvey['id'], $votedId)) {
                echo "<a href='?do=survey_result&id={$newSurvey['id']}' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>";
            } else {
                echo "<a href='?do=vote_survey&id={$newSurvey['id']}' class='btn btn-main'><i class='fa-solid fa-check-to-slot'></i></a>";
            }
        } else {
            echo "<a href='?do=vote_survey&id={$newSurvey['id']}' class='btn btn-main'><i class='fa-solid fa-check-to-slot'></i></a>";
        }
        ?>
    </div>
  </li>
    <?php
}
}
?>
  <!-- 最新投票輸出區 END-->
</ul>
  </div>
  <script>
  //倒數器
  const timer = document.getElementById('timer');
  if(timer.dataset.active=='0'){
    let surveyEnd = timer.dataset.time.split(/:|-|\s/g);
    // console.log(surveyEnd);
    let counter = setInterval(()=>{
      const now = Date.now();
      const endTime = new Date(surveyEnd[0],surveyEnd[1]-1,surveyEnd[2],23,59,59);
      // console.log(endTime);
      const timeToView = new Date(endTime-now)/1000;
      let hours = parseInt(timeToView / 60 / 60);
      let minutes = parseInt(timeToView / 60 % 60);
      let seconds = parseInt(timeToView % 60);
      hours = addZero(hours);
      minutes = addZero(minutes);
      seconds = addZero(seconds);
  
      let timerStr = `${hours}:${minutes}:${seconds}`;
      timer.textContent = timerStr;
      if(timeToView<=0){
        timer.textContent="00:00:00";
        clearInterval(counter);
      }
    },1000)
  }

  function addZero(num){
    return num<10?'0'+num:num;
  }



  </script>
