<?php
include_once "./db/base.php";

$startTime = date("Y-m-d", strtotime('now'));
$endTime = date("Y-m-d", strtotime("+1 months"));
?>
<div class="container-xxl pb-5 mt-3">
    <form action="./api/edit_survey_daily.php" method="post" enctype="multipart/form-data" class="edit-survey-form mx-auto" id="add-survey-form">
    <a href="?do=edit_survey_daily" class="fw-bold d-block mb-1 back-btn"><i class="fa-solid fa-chevron-left mr-1"></i>返回每日主題</a>
    <div class="section-tag tag-lg mb-3">編輯投票</div>
    <div class="tool d-flex align-items-center">
        <!-- 投票設定區(type/date/file upload) -->
    <div class="option-type">
        <!-- 投票類型 -->
        <div class="radio-box d-flex">
            <?php
            $subjectDetail = find('projectvote_subject_daily',$_GET['id']);
            $img = find('projectvote_upload',$subjectDetail['image']);
            $imgURL = "./upload/{$img['file_name']}";
            $options = all('projectvote_subject_daily_options',['subject_id'=>$_GET['id']]);
            $startTime = date("Y-m-d",strtotime($subjectDetail['start_time']));
            $endTime = date("Y-m-d",strtotime($subjectDetail['end_time']));
            // print_r($options);
            if($subjectDetail['type']){
                $radioChecked = '';
                $checkboxChecked = 'checked';
            }else{
                $radioChecked = 'checked';
                $checkboxChecked = '';
            }
            ?>
            <input class="form-check-input fs-5" type="radio" name="type" id="radio" value=0 <?=$radioChecked?>>
            <label class="form-check-label fs-5 fw-bold me-2" for="radio">單選</label>
            <input class="form-check-input fs-5" type="radio" name="type" id="checkbox" value=1 <?=$checkboxChecked?>>
            <label class="form-check-label fs-5 fw-bold" for="checkbox">複選</label>
        </div>
        <!-- 投票類型 END-->
        <!-- 日期選擇區 -->
        <div class="date-selector mt-3">
            <div class="time-error-info text-danger"></div>
            <label class="fs-5 fw-bold" for="start_time">開始時間<input class="fs-5 mx-2" type="date" name="start_time" id="start_time" value="<?=$startTime?>"></label>
            <label class="fs-5 fw-bold" for="end_time">結束時間<input class="fs-5 mx-2" type="date" name="end_time" id="end_time" value="<?=$endTime?>"></label>
        </div>
        <!-- 日期選擇區 END-->
        <!-- 圖片上傳區 -->
        <div class="uploader my-3">
        <div class="fs-6">上傳圖片(僅支援JPG,PNG,GIF)</div>
        <input class="file-input form-control" type="file" name="file-input" accept="image/gif, image/jpeg, image/png">
        <img src=<?=$imgURL?> alt="" id="img-view" width="200px">
        </div>
        <!-- 圖片上傳區 END-->
    </div>
        <a href="#" class="btn btn-main float-right ms-auto add-option-btn align-self-start"><i class="fa-sharp fa-solid fa-plus"></i></a>
    </div>
<div class="my-3">
  <label for="title" class="form-label fs-4 fw-bold">主題<span class="text-danger">*</span></label>
  <input type="hidden" name="id" value=<?=$subjectDetail['id']?>>
  <input type="text" name="title" class="form-control" id="title" placeholder="15字以內投票主題"  value=<?=$subjectDetail['title']?> maxlength="15" required>
</div>
<div class="my-3">
  <label for="description" class="form-label fs-4 fw-bold">描述<span class="text-danger">*</span></label>
  <input type="text" name="description" class="form-control" id="description" placeholder="50字以內描述" value=<?=$subjectDetail['description']?> maxlength="50" required></input>
</div>
<div class="option-error-info text-danger"></div>
<?php
foreach($options as $key =>$opt){
    $star = '*';
    $deleteBtn='';
    if($key>1){
        $star = '';
        $deleteBtn = "<a href='./api/del_option_daily.php?id={$opt['id']}&subject_id={$opt['subject_id']}' class='btn btn-main float-right ms-auto del-exist-option-btn'><i class='fa-solid fa-trash-can del-exist-option-btn'></i></a><div class='clearfix'></div>";
    }
    ?>
    <div class="mb-3">
    <label class="form-label fs-4 fw-bold">選項<span class="text-danger"><?=$star?></span></label>
    <?=$deleteBtn?>
    <input type="hidden" name = "opt_id[]" value="<?=$opt['id']?>">
    <input type="text" name="opt[]" class="form-control"  placeholder="請輸15字以內入文字" maxlength="15" autocomplete="off" value="<?=$opt['opt']?>" required >
    </div>
    <?php
}
?>
<div class="plus-option"></div>
<footer class="text-center">
            <a href="?do=edit_survey_daily&id=<?=$_GET['id']?>" class="btn btn-secondary btn-lg fw-bold">重置</a>
            <input type="submit" value="確認" class="btn btn-main btn-lg fw-bold">
        </footer>
    </form>
</div>

<script>
    const addSurveyForm = document.getElementById('edit-survey-form');
    const plusOption = document.querySelector('.plus-option');
    const addOptionBtn =document.querySelector('.add-option-btn');
    addOptionBtn.addEventListener('click',addOption)

    function addOption(e){
        e.preventDefault();
        const div = document.createElement('div');
        div.setAttribute('class',"mb-3");
        div.innerHTML=`<label class="form-label fs-4 fw-bold">選項</span></label><a href="#" class="btn btn-main float-right ms-auto del-option-btn"><i class="fa-solid fa-trash-can del-option-btn"></i></a><div class="clearfix"></div><input type="text" name="opt_new[]" class="form-control"  placeholder="請輸入15字以內文字" maxlength="15" autocomplete="off">`
        plusOption.appendChild(div);
        const delOptionBtn = document.querySelectorAll('.del-option-btn , .del-exist-option-btn');
        if(delOptionBtn.length>=2){
            addOptionBtn.style.cssText=`background-color:var(--gray-heavy);cursor:auto;`;
            addOptionBtn.innerHTML =`<i class="fa-solid fa-ban"></i>`
            addOptionBtn.removeEventListener('click',addOption);
        }
    }
    addSurveyForm.addEventListener('click',function(e){
        if(e.target.classList.contains('del-option-btn')){
            e.preventDefault();
            e.target.closest('div').remove();
            const delOptionBtn = document.querySelectorAll('.del-option-btn , .del-exist-option-btn');
            if(delOptionBtn.length<2){
            addOptionBtn.style.cssText=`background-color:var(--main);cursor:pointer;`;
            addOptionBtn.innerHTML =`<i class="fa-sharp fa-solid fa-plus">`
            addOptionBtn.addEventListener('click',addOption);
        }
        }
    })

    //輸入資料驗證
    const starTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    const timeErrorInfo = document.querySelector('.time-error-info');
    const optionErrorInfo =document.querySelector('.option-error-info');
    starTime.addEventListener('change',checkDate);
    endTime.addEventListener('change',checkDate);

    function checkDate(){
        const startDate = new Date(starTime.value);
        const endDate = new Date(endTime.value);
        timeErrorInfo.textContent="";
        if(!starTime.value||!endTime.value) {
            timeErrorInfo.textContent = "請選擇日期";
        }
        if(endDate-startDate<0){
            timeErrorInfo.textContent = "結束時間需要大於開始時間"
        }
    }

    //日期區間若不正確終止送出行為
    addSurveyForm.addEventListener('submit',function(e){
        e.preventDefault();
        checkOption()
        if(!timeErrorInfo.textContent && !optionErrorInfo.textContent){
            addSurveyForm.submit();
        }
    })

    //檢查是否有重複的投票選項
    function checkOption(){
        const optionList = document.querySelectorAll('[name="opt[]"],[name="opt_new[]"]');
        // console.log(optionList);
        let result = {};
        let repeat = [];
        optionList.forEach(item=>{
            if(result[item.value]){
                repeat.push(item.value);
            }else{
                result[item.value]=1;
            }
            
        })
        if(repeat.length!=0){
            optionErrorInfo.textContent="選項不能重複!";
        }else{
            optionErrorInfo.textContent="";
        }
    }

    // 由於include了header.php,無法在這頁用PHP的header()轉址
    // 改用js轉
    const editPageParams = new URLSearchParams(window.location.search);
    if(!editPageParams.get('id')){
        location.href="?do=mysurvey&status=edit_error";
    }

    //圖片預覽
    const fileInput = document.querySelector('.file-input');
    const imgView = document.getElementById('img-view');
    fileInput.addEventListener('change',renderImg);
     function renderImg(){
        if(this.files){
            let reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.addEventListener('load',function(e){
                imgView.src = this.result;
            })
        }
     }
</script>