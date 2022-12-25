<?php
include_once "./db/base.php";

$survey = find('projectvote_subject',$_GET['id']);
$categoryName = find('projectvote_subject_category',$survey['category_id']);
//開放未投過票的用戶看已經結束的投票
//有投票log再讓圖表動畫鎖定已選的項目
$optionId='';
//登入的狀態再撈log
if(isset($_SESSION['user'])){
  $userLog = find('projectvote_log',['subject_id'=>$_GET['id'],'user_id'=>$_SESSION['user']['id']]);
}
//如果有投票log再把頭過項目的選項字串拆開
if(!empty($userLog)){
  $optionId=explode(',',$userLog['option_id']);
}

switch($survey['private']){
    case 0:
        $private = '公開';
    break;    
    case 1:
    case 2:
        $private = '私人';
    break;    
}
?>
<div class="container-xxl pb-5 mt-3">
    <div class="survey-info w-50 mx-auto">
      <a href="#" class="fw-bold d-block mb-1 back-btn"><i class="fa-solid fa-chevron-left mr-1"></i>回清單</a>
      <h2 class="section-tag tag-lg mb-2"><?=$survey['title']?></h2>
      <p class="fs-4 fw-bold mt-2 mb-0" ><?=$survey['description']?></p>
      <div class="tag">
          <span class="survey-tag btn btn-sm"><?=$categoryName['category']?></span>
          <span class="survey-tag btn btn-sm"><?=$private?></span>
      </div>
    </div>
    <div id="chart" class="w-50 mx-auto"></div>
    <div class="survey-date text-sub mb-2 w-50 mx-auto">
      <span class="pe-3">開始時間: <time><?=$survey['start_time']?></time></span><span>結束時間: <time><?=$survey['end_time']?></time></span>
      <div>投票人次:<span class="subject_vote"><?=$survey['vote']?>人</span></div>
    </div>
    <div class="result-info-box w-50 mx-auto fw-bold fs-5">
      <div>您的選擇為 :</div>
      <ul class="result-option-list">
        <?php
        if(!empty($optionId)){
          $votedOpt=[];
          foreach($optionId as $value){
            $vote=find('projectvote_subject_options',['id'=>$value])['opt'];
            $votedOpt[]="'{$vote}'";
            echo "<li class='result-option-item border-bottom border-1 border-sub text-center fs-3'>";
            echo "<i class='fa-sharp fa-solid fa-check text-main'></i>$vote</li>";
          }
          //C3用的字串,不想重複foreach所以移到這
          $votedOpt=join(',',$votedOpt);
        }else{
          $votedOpt='';
          echo "<li class='result-option-item border-bottom border-1 border-sub text-center fs-3'>未參加投票</li>";
        }
        ?>
      </ul>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js'></script>
<script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
<script>
    const backBtn = document.querySelector('.back-btn');
    //返回上一頁按鈕
    backBtn.addEventListener('click',function(e){
        e.preventDefault();
        let refUrl = document.referrer.split('?')[1];
        //如果上一頁有query string,判斷是否為註冊或登錄頁
        //有的話上一頁直接回首頁並清空紀錄
        if(refUrl){
          refUrl=refUrl.replace(/=|&/g,' ');
            let regex = /login|reg|vote/;
            if(refUrl.search(regex)!=-1){
                window.history.go(-window.history.length);
                window.location.replace("?do=mysurvey");
            }else{
                history.back();
            }
        }else{
            history.back();
        }
    })

    //撈圖表用資料
    axios.get("./api/result_api.php?id=<?=$_GET['id']?>")
    .then(res=>{
      // console.log(res);
      renderC3(res.data)
    })
    .catch(error=>{
      console.log(res);
    });

    //選染圖表
    function renderC3(data){
      let chart = c3.generate({
      bindto:'#chart',
      data: {
          json: data,
          type: 'pie'
      },
      padding: {
        top: 0,
        bottom: 0,
      },
      legend: {
        position: 'bottom'
      },
      axis: {
      rotated: true,
      inner: true
      },
      tooltip: {
      format: {
          value: function (value, ratio, id) {
                  return value+"票";
          }
      }
  }})

    setTimeout(function () {
        chart.transform('pie');
        setTimeout(function () {
        chart.focus([<?=$votedOpt?>]);
        }, 800)
      }, 0);
    }
</script>