<?php
include_once "./db/base.php";

//私人投票要判斷身份
//判斷投票類型
$survey = find('projectvote_subject_daily',$_GET['id']);
$options = all('projectvote_subject_daily_options',['subject_id'=>$_GET['id']]);
if($survey['type']==0){
    $type='radio';
    $tip='單選';
}else{
    $type='checkbox';
    $tip='複選';
}
// print_r($_COOKIE);
//抓時間,底下判斷投票是否啟用時要用
$now=strtotime('now');
$startTime = strtotime($survey['start_time']);
$endtTime = strtotime($survey['end_time']);

?>
<div class="container-xxl pb-5 mt-3">
    <div class="survey-info w-50 mx-auto">
        <a href="#" class="fw-bold d-block mb-1 back-btn"><i class="fa-solid fa-chevron-left mr-1"></i>回上一頁</a>
        <h2 class="section-tag tag-lg mb-3"><?=replaceInput('html',$survey['title'])?></h2>
        <p class="fs-4 fw-bold mt-2" ><?=replaceInput('html',$survey['description'])?></p>
    </div>
    <form action="./api/vote_survey_daily.php" method="post" class="vote-survey-form w-50 mx-auto position-relative active" id="vote-survey-form">
        <input type="hidden" name="id" value="<?=$survey['id']?>">
        <div class="tip fw-bold text-sub fs-5 my-3"><?=$tip?></div>
    <?php
    foreach($options as $key=>$option){
            ?>
            <div class="option my-2">
            <label class="fs-5 fw-bold me-2 border-bottom border-2 border-sub d-block" for="<?=$option['id']?>"><input type="<?=$type?>" id="<?=$option['id']?>" class="form-check-input fs-5 d-inline-block me-1" name="opt[]" value="<?=$option['id']?>"><?=replaceInput('html',$option['opt'])?></label>
            </div>
        <?php
        }
    ?>
    <div id="error-info" class="text-danger"></div>
    <?php
   //權限判斷,沒SESSION直接請用戶登入
   //code重複性高改成用變數控制最後再印
   $printInfo=false;
    if(isset($_SESSION['user'])){
        //判斷是否維可投票時間
        if($startTime>$now){
            $printInfo = true;
            $infoTitle="投票尚未開始!";
            $btnLeft = "<a href='?do=main' class='btn btn-secondary btn-lg fw-bold'>看看別的</a>";
            $btnRight = "<a href='?do=mysurvey' class='btn btn-main btn-lg fw-bold'>我的清單</a>";
        }
        if($endtTime<$now){
            $printInfo = true;
            $infoTitle="投票已結束!";
            $btnLeft = "<a href='?do=main' class='btn btn-secondary btn-lg fw-bold'>看看別的</a>";
            $btnRight = "<a href='?do=survey_result&id={$_GET['id']}' class='btn btn-main btn-lg fw-bold'>看結果</a>";
        }
        //判斷是否投過票
        $votedLogs = all('projectvote_log',['user_id'=>$_SESSION['user']['id'],'daily_subject_id'=>$_GET['id']]);
        if(!empty($votedLogs)){
            $printInfo = true;
            $infoTitle="已經投過票囉!";
            $btnLeft = "<a href='?do=main' class='btn btn-secondary btn-lg fw-bold'>看看別的</a>";
            $btnRight = "<a href='?do=survey_result_daily&id={$_GET['id']}' class='btn btn-main btn-lg fw-bold'>看結果</a>";
        }
        ?>
    <?php
    }else{
        $printInfo = true;
        $infoTitle="很抱歉!僅開放會員投票";
        $btnLeft = "<a href='?do=login' class='btn btn-secondary btn-lg fw-bold'>登入</a>";
        $btnRight = "<a href='?do=reg&id={$_GET['id']}' class='btn btn-main btn-lg fw-bold'>註冊</a>";
    }
    //判斷是否需要印無投票權限訊息
    if($printInfo){
        ?>
        <div class="info auth-info text-center fs-1 fw-bold position-absolute">
        <div class="auth-info-box w-100">
            <div><?=$infoTitle?></div>
            <?=$btnLeft?>
            <?=$btnRight?>
        </div>
        </div>
        <?php
    }else{
    ?>
    <footer class="text-center my-5">
    <a href="?do=vote_survey&id=<?=$_GET['id']?>" class="btn btn-secondary btn-lg fw-bold">重置</a>
    <input type="submit" value="投票" class="btn btn-main btn-lg fw-bold">
    </footer>
    <?php
    }
    ?>
    </form>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script>
    const backBtn = document.querySelector('.back-btn');
    //上一頁按鈕
    backBtn.addEventListener('click',function(e){
        e.preventDefault();
        let refUrl = document.referrer.split('?')[1];
        //如果上一頁有query string,判斷是否為註冊或登錄頁
        //有的話上一頁直接回首頁並清空紀錄
        if(refUrl){
            refUrl=refUrl.replace(/=|&/g,' ');
            let regex = /login|reg/;
            if(refUrl.search(regex)!=-1){
                window.history.go(-window.history.length);
                window.location.replace("?do=main");
            }else{
                history.back();
            }
        }else{
            history.back();
        }
    })

    const constraints = {
        'opt[]':{
            presence: {
                message:"^請選擇要投的項目"
            }
        }
    }
    const voteForm = document.getElementById('vote-survey-form');
    const errorInfo = document.getElementById('error-info');
    voteForm.addEventListener('submit',function(e){
        e.preventDefault();
        const error = validate(voteForm,constraints);
        // console.log(error);
        if(!error){
            voteForm.submit();
        }else{
            console.log(error);
            errorInfo.textContent=error["opt[]"];
        }
    })

    voteForm.addEventListener('click',function(e){
        if(e.target.classList.contains('form-check-input')){
            errorInfo.textContent='';
        }
    })
</script>