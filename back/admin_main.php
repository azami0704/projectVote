<?php
include_once "./db/base.php";

$todaySurvey = find("projectvote_subject_daily", ['start_time' => date("Y-m-d")]);
$today=date("Y-m-d");
?>
<div class="d-flex">
<div class="nav-space flex-shrink-0"></div>
<div class="admin container-xxl mt-5 pb-5">
    <div class="data">
        <h2 class="section-tag tag-lg mb-4">管理後台</h2>
        <h3>一週流量統計</h3>
        <div id="chart-user" class="chart mx-auto"></div>
    </div>
    <div class="data-cards d-flex justify-content-center">
        <div class="data-card card my-5 mx-2 text-center">
        <div class="card-body">
        <h5 class="card-title fw-bold">總會員</h5>
        <p class="dash-board-text card-text"><?=countSql('projectvote_users')?>
        </p>
        </div>
        </div>
        <div class="data-card card my-5 mx-2 text-center">
        <div class="card-body">
        <h5 class="card-title fw-bold">進行中投票</h5>
        <p class="dash-board-text card-text"><?=countSql('projectvote_subject'," WHERE `start_time`<='$today' AND `end_time`>='$today'")+countSql('projectvote_subject_daily'," WHERE `start_time`<='$today' AND `end_time`>='$today'")?>
        </p>
        </div>
        </div>
    </div>
    <div class="today-survey mt-3 mb-5">
    <h3>今日主題投票</h3>
    <ul class="list-group text-center">
    <li class="list-group-item d-flex align-items-center bg-transparent border-bottom border-3 border-dark p-1" aria-current="true">
    <div class="w-20">主題</div>
    <div class="w-15">人氣</div>
    <div class="w-35">描述</div>
    <div class="w-15">最新投票時間</div>
    <div class="w-15">操作</div>
  </li>
  <?php
if (!empty($todaySurvey)) {
    ?>
  <li class="list-group-item d-flex align-items-center border-bottom border-1 border-dark px-1">
      <div class="w-20 text-collapse"><?=$todaySurvey['title']?></div>
      <div class="w-15"><?=$todaySurvey['vote']?></div>
      <div class="w-35 text-collapse"><?=$todaySurvey['description']?></div>
      <div class="w-15"><?=$todaySurvey['update_at']?></div>
      <div class="w-15">
      <a href='?do=edit_survey_daily&id=<?=$todaySurvey['id']?>' class='btn btn-main me-1'><i class='fa-solid fa-pen'></i></a>
      <a href='?do=survey_result_daily&id=<?=$todaySurvey['id']?>' class='btn btn-main'><i class='fa-solid fa-eye'></i></a>
      <div>
      </li>
      <?php
} else {
    echo "<li class='list-group-item d-flex align-items-center border-bottom border-1 border-dark px-1'>";
    echo "<div class='w-100'>今日無主題投票</div>";
    echo "</li>";
}
?>
    </ul>
    </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js'></script>
<script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
<script>
    axios.get("./api/chart_data_api.php")
        .then(res => {
            // console.log(res.data);
            C3Render(res.data);
        })
        .catch(error => {
            console.log("error" + error);
        })

    function C3Render(data) {
        let date = Object.keys(data.dailyLogin);
        let active = Object.values(data.dailyLogin);
        let voted = Object.values(data.voted);
        let reg = Object.values(data.dailyReg);
        date.unshift('x');
        active.unshift('active user');
        voted.unshift('投票人次');
        reg.unshift('新會員');
        var chart = c3.generate({
            bindto: '#chart-user',
            data: {
                x: 'x',
                columns: [
                    date,
                    active,
                    voted,
                    reg,
                ],
                type: 'line',
                types: {
                    新會員: 'bar',
                }
            },
            axis: {
                x: {
                    type: 'timeseries',
                    tick: {
                        format: '%Y-%m-%d'
                    }
                }
            },
            padding: {
                left: 48,
            },
            grid: {
                y: {
                    show: true
                }
            },
            legend: {
                position: 'right'
            }
        });
    }
</script>