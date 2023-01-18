<?php
include_once "./db/base.php";

$startTime = date("Y-m-d", strtotime('now'));
$endTime = date("Y-m-d", strtotime("+1 months"));
?>
<div class="container-xxl mt-3 pb-5">
    <form action="./api/add_survey.php" method="post" class="add-survey-form mx-auto" id="add-survey-form">
    <a href="?do=mysurvey" class="fw-bold d-block mb-1 back-btn"><i class="fa-solid fa-chevron-left mr-1"></i>回我的投票</a>
    <div class="section-tag tag-lg mb-3">發起投票</div>
    <div class="tool d-flex align-items-center ">
    <div class="option-type">
        <div class="radio-box d-flex">
            <input class="form-check-input fs-5" type="radio" name="type" id="radio" value=0 checked>
            <label class="form-check-label fs-5 fw-bold me-2" for="radio">單選</label>
            <input class="form-check-input fs-5" type="radio" name="type" id="checkbox" value=1>
            <label class="form-check-label fs-5 fw-bold" for="checkbox">複選</label>
            <div class="category ms-auto">
                <label class="form-check-label fs-5 fw-bold">分類</label>
                <!--category select -->
                <select name="category_id">
                <?php
                $categorys =all('projectvote_subject_category');
                foreach($categorys as $category){
                ?>
                <option value="<?=$category['id']?>"><?=$category['category']?></option>
                <?php
                }
                ?>
                </select>
                <!--category select -->
            </div>
        </div>
        <div class="date-selector mt-3">
            <div class="time-error-info text-danger"></div>
            <label class="fs-5 fw-bold" for="start_time">開始時間<input class="fs-5 mx-2" type="date" name="start_time" id="start_time" value="<?=$startTime?>"></label>
            <label class="fs-5 fw-bold" for="end_time">結束時間<input class="fs-5 mx-2" type="date" name="end_time" id="end_time" value="<?=$endTime?>"></label>
        </div>
        <div class="private my-3">
        <div class="fs-5 fw-bold">投票權限</div>
        <label class="fs-5 fw-bold me-2" for="public"><input type="radio" id="public" class="form-check-input fs-5" name="private" value=0 checked>公開</label>
        <label class="fs-5 fw-bold me-2" for="private"><input type="radio" id="private" class="form-check-input fs-5" name="private" value=1>知道連結的所有會員</label>
        <label class="fs-5 fw-bold me-2" for="all_member"><input type="radio" name="private" id="all_member" class="form-check-input fs-5" value=2>指定會員</label><a href="#" class="member-add-btn fs-5"><i class="fa-regular fa-square-plus"></i></a>
        </div>
    </div>
        <a href="#" class="btn btn-main float-right ms-auto add-option-btn align-self-start"><i class="fa-sharp fa-solid fa-plus"></i></a>
    </div>
    <div class="member-input d-flex flex-wrap">
        <div class="input-group mb-1">
        <input type="email" name="member[]" placeholder="請輸入會員帳號" class="form-control w-50">
        <input type="email" name="member[]" placeholder="請輸入會員帳號" class="form-control w-50">
        </div>
    </div>
<div class="my-3">
  <label for="title" class="form-label fs-4 fw-bold">主題<span class="text-danger">*</span></label>
  <input type="text" name="title" class="form-control" id="title" placeholder="15字以內投票主題" maxlength="15" required>
</div>
<div class="my-3">
  <label for="description" class="form-label fs-4 fw-bold">描述<span class="text-danger">*</span></label>
  <input type="text" name="description" class="form-control" id="description" placeholder="50字以內描述" maxlength="50" required></input>
</div>
<div class="option-error-info text-danger"></div>
<div class="mb-3">
  <label class="form-label fs-4 fw-bold">選項<span class="text-danger">*</span></label>
  <input type="text" name="opt[]" class="form-control"  placeholder="請輸入15字以內文字" maxlength="15" autocomplete="off" required>
</div>
<div class="mb-3">
  <label  class="form-label fs-4 fw-bold">選項<span class="text-danger">*</span></label>
  <input type="text" name="opt[]" class="form-control" placeholder="請輸入15字以內文字" maxlength="15" autocomplete="off" required>
</div>
<div class="plus-option"></div>
<footer class="text-center">
            <input type="reset" value="重填" class="btn btn-secondary btn-lg fw-bold">
            <input type="submit" value="建立" class="btn btn-main btn-lg fw-bold">
        </footer>
    </form>
</div>

<script>
    const addSurveyForm = document.getElementById('add-survey-form');
    const plusOption = document.querySelector('.plus-option');
    const addOptionBtn =document.querySelector('.add-option-btn');
    //新增選項按鈕綁監聽
    addOptionBtn.addEventListener('click',addOption)
    
    //新增按鈕的動作,因為需要removeEventListener所以寫成function
    function addOption(e){
        e.preventDefault();
        const div = document.createElement('div');
        div.setAttribute('class',"mb-3");
        div.innerHTML=`<label class="form-label fs-4 fw-bold">選項</span></label><a href="#" class="btn btn-main float-right ms-auto del-option-btn"><i class="fa-solid fa-trash-can del-option-btn"></i></a>
        <div class="clearfix"></div>
        <input type="text" name="opt[]" class="form-control"  placeholder="請輸入文字" maxlength="15" autocomplete="off">`
        plusOption.appendChild(div);
        const delOptionBtn = document.querySelectorAll('.del-option-btn');
        if(delOptionBtn.length>=20){
            addOptionBtn.style.cssText=`background-color:var(--gray-heavy);cursor:auto;`;
            addOptionBtn.innerHTML =`<i class="fa-solid fa-ban"></i>`
            addOptionBtn.removeEventListener('click',addOption);
        }
    }
    //監聽整張表單的點擊事件
    addSurveyForm.addEventListener('click',function(e){
        if(e.target.classList.contains('del-option-btn')){
            e.target.closest('div').remove();
            const delOptionBtn = document.querySelectorAll('.del-option-btn');
            if(delOptionBtn.length<20){
            addOptionBtn.style.cssText=`background-color:var(--main);cursor:pointer;`;
            addOptionBtn.innerHTML =`<i class="fa-sharp fa-solid fa-plus">`
            addOptionBtn.addEventListener('click',addOption);
        }
        }
    })

    const private = document.querySelector('.private');
    const memberAddBtn = document.querySelector('.member-add-btn');
    const memberInput = document.querySelector('.member-input');

    //監聽投票權限區塊的點擊事件
    private.addEventListener('click',function(e){
        const inputGroup = document.querySelectorAll('.input-group');
        if(e.target.id=="all_member"){
            console.log();
            inputGroup[0].firstElementChild.setAttribute("required","");
            memberInput.style.cssText=`height: ${inputGroup.length*(2.375+0.25)}rem;overflow: hidden;`;
            memberAddBtn.style.cssText=`transform: translateX(0);opacity:1;max-width:2rem;`;
        }else if(e.target.id=="public"||e.target.id=="private"){
            inputGroup[0].firstElementChild.removeAttribute("required","");
            memberInput.style.cssText="height: 0;overflow: hidden;transition: 0.25s;";
            memberAddBtn.style.cssText=`transform: translateX(-2rem);opacity:0;max-width:0px;`;
        }
    })
    //新增私人會員按鈕註冊監聽
    memberAddBtn.addEventListener('click',addMemberList);

    //新增私人投票名單動作,因為需要removeEventListener所以寫成function
    function addMemberList(e){
        e.preventDefault();
        const div = document.createElement('div');
        div.setAttribute("class","input-group mb-1")
        div.innerHTML=`<input type="email" name="member[]" placeholder="請輸入會員帳號" class="form-control w-50">
        <input type="email" name="member[]" placeholder="請輸入會員帳號" class="form-control w-50">`;
        memberInput.appendChild(div);
        memberInput.style.cssText=`height: auto;`;
        const inputGroup = document.querySelectorAll('.input-group');
        if(inputGroup.length>=5){
            this.removeEventListener('click',addMemberList);
            this.removeAttribute('href');
            this.querySelector('i').style.cssText=`color:var(--gray-heavy);`;
        }
    }

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
        if(endDate-startDate<=0){
            timeErrorInfo.textContent = "結束時間需要大於開始時間"
        }
    }

    //日期區間若不正確,選項重複時終止送出行為
    addSurveyForm.addEventListener('submit',function(e){
        e.preventDefault();
        checkOption();
        if(!timeErrorInfo.textContent&&!optionErrorInfo.textContent){
            addSurveyForm.submit();
        }
    })

    //檢查是否有重複的投票選項
    function checkOption(){
        const optionList = document.querySelectorAll('[name="opt[]"]');
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
</script>

