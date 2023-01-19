const addSurveyForm = document.getElementById('add-survey-form');
const plusOption = document.querySelector('.plus-option');
const addOptionBtn = document.querySelector('.add-option-btn');
//新增選項按鈕綁監聽
addOptionBtn.addEventListener('click', addOption)

//新增按鈕的動作,因為需要removeEventListener所以寫成function
function addOption(e) {
    e.preventDefault();
    const div = document.createElement('div');
    div.setAttribute('class', "mb-3");
    div.innerHTML = `<label class="form-label fs-4 fw-bold">選項</span></label><a href="#" class="btn btn-main float-right ms-auto del-option-btn"><i class="fa-solid fa-trash-can del-option-btn"></i></a>
        <div class="clearfix"></div>
        <input type="text" name="opt[]" class="form-control"  placeholder="請輸入文字" maxlength="15" autocomplete="off">`
    plusOption.appendChild(div);
    const delOptionBtn = document.querySelectorAll('.del-option-btn');
    optionLimitControl(delOptionBtn, optionLimit);
}
//監聽整張表單的點擊事件
addSurveyForm.addEventListener('click', function (e) {
    //如果點擊的是刪除選項按鈕,刪除按鈕並檢查選項是否在規定內
    if (e.target.classList.contains('del-option-btn')) {
        e.preventDefault();
        e.target.closest('div').remove();
        const delOptionBtn = document.querySelectorAll('.del-option-btn');
        optionLimitControl(delOptionBtn, optionLimit);
    }
})

//新增選項按鈕上限,啟用&關閉控制
function optionLimitControl(targetBtn, limit) {
    if (targetBtn.length >= limit) {
        addOptionBtn.style.cssText = `background-color:var(--gray-heavy);cursor:auto;`;
        addOptionBtn.innerHTML = `<i class="fa-solid fa-ban"></i>`
        addOptionBtn.removeEventListener('click', addOption);
    } else if (targetBtn.length < limit) {
        addOptionBtn.style.cssText = `background-color:var(--main);cursor:pointer;`;
        addOptionBtn.innerHTML = `<i class="fa-sharp fa-solid fa-plus">`
        addOptionBtn.addEventListener('click', addOption);
    }
}

const private = document.querySelector('.private');
const memberAddBtn = document.querySelector('.member-add-btn');
const memberInput = document.querySelector('.member-input');
//監聽投票權限區塊的點擊事件
//此區為一般投票的私人投票區塊監控,加上判斷避免daily無private會報錯
if (private) {
    private.addEventListener('click', function (e) {
        const inputGroup = document.querySelectorAll('.input-group');
        if (e.target.id == "all_member") {
            //點選私人投票時將第一個輸入input加上required以防止空值
            if(inputGroup.length>0) {
                inputGroup[0].firstElementChild.setAttribute("required", "");
                memberInput.style.cssText = `height: ${inputGroup.length * (2.375 + 0.25)}rem;overflow: hidden;`;
            }else{
                //若原始設定非私人投票會沒有input,新增後加上required
                const div = document.createElement('div');
                div.setAttribute("class","input-group mb-1")
                div.innerHTML=`<input type="email" name="member_new[]" placeholder="請輸入會員帳號" class="form-control w-50"><input type="email" name="member_new[]" placeholder="請輸入會員帳號" class="form-control w-50">`;
                memberInput.appendChild(div);
                const inputGroup = document.querySelectorAll('.input-group');
                inputGroup[0].firstElementChild.setAttribute("required","");
                memberInput.style.cssText=`height: ${inputGroup.length*(2.375+0.25)}rem;overflow: hidden;`;
            }
            memberAddBtn.style.cssText = `transform: translateX(0);opacity:1;max-width:2rem;`;
        } else if (e.target.id == "public" || e.target.id == "private") {
            //選擇"公開"或"知道連結的所有會員"移除required屬性
            if(inputGroup.length>0){
                inputGroup[0].firstElementChild.removeAttribute("required","");
                memberInput.style.cssText="height: 0;overflow: hidden;transition: 0.25s;";
                memberAddBtn.style.cssText=`transform: translateX(-2rem);opacity:0;max-width:0px;`;
            }
        }
    })

    //新增私人會員按鈕註冊監聽
    memberAddBtn.addEventListener('click', addMemberList);

    //頁面載入時先判斷指定會員&人數修改按鈕狀態
    const allMemberCheckbox = document.getElementById('all_member');
    if (allMemberCheckbox.checked) {
        const inputGroup = document.querySelectorAll('.input-group');
        if (inputGroup.length > 0) {
            inputGroup[0].firstElementChild.setAttribute("required", "");
            memberInput.style.cssText = `height: ${inputGroup.length * (2.375 + 0.25)}rem;overflow: hidden;`;
            memberAddBtn.style.cssText = `transform: translateX(0);opacity:1;max-width:2rem;`;
            if (inputGroup.length >= 5) {
                memberAddBtn.removeEventListener('click', addMemberList);
                memberAddBtn.removeAttribute('href');
                memberAddBtn.querySelector('i').style.cssText = `color:var(--gray-heavy);`;
            }
        }
    }

    //新增私人投票名單動作,因為需要removeEventListener所以寫成function
    function addMemberList(e) {
        e.preventDefault();
        const div = document.createElement('div');
        div.setAttribute("class", "input-group mb-1")
        div.innerHTML = `<input type="email" name="member[]" placeholder="請輸入會員帳號" class="form-control w-50">
        <input type="email" name="member[]" placeholder="請輸入會員帳號" class="form-control w-50">`;
        memberInput.appendChild(div);
        memberInput.style.cssText = `height: auto;`;
        const inputGroup = document.querySelectorAll('.input-group');
        if (inputGroup.length >= 5) {
            this.removeEventListener('click', addMemberList);
            this.removeAttribute('href');
            this.querySelector('i').style.cssText = `color:var(--gray-heavy);`;
        }
    }
}


//輸入資料驗證
const starTime = document.getElementById('start_time');
const endTime = document.getElementById('end_time');
const timeErrorInfo = document.querySelector('.time-error-info');
const optionErrorInfo = document.querySelector('.option-error-info');
starTime.addEventListener('change', checkDate);
endTime.addEventListener('change', checkDate);

function checkDate() {
    const startDate = new Date(starTime.value);
    const endDate = new Date(endTime.value);
    timeErrorInfo.textContent = "";
    if (!starTime.value || !endTime.value) {
        timeErrorInfo.textContent = "請選擇日期";
    }
    if (endDate - startDate < 0) {
        timeErrorInfo.textContent = "結束時間需要大於開始時間"
    }
}

//日期區間若不正確,選項重複時終止送出行為
addSurveyForm.addEventListener('submit', function (e) {
    e.preventDefault();
    checkOption();
    if (!timeErrorInfo.textContent && !optionErrorInfo.textContent) {
        addSurveyForm.submit();
    }
})

//檢查是否有重複的投票選項
function checkOption() {
    const optionList = document.querySelectorAll('[name="opt[]"]');
    // console.log(optionList);
    let result = {};
    let repeat = [];
    optionList.forEach(item => {
        if (result[item.value]) {
            repeat.push(item.value);
        } else {
            result[item.value] = 1;
        }

    })
    if (repeat.length != 0) {
        optionErrorInfo.textContent = "選項不能重複!";
    } else {
        optionErrorInfo.textContent = "";
    }
}

//圖片預覽
const fileInput = document.querySelector('.file-input');
const imgView = document.getElementById('img-view');
//只有daily有圖片預覽,加上判斷避免其他頁面使用時報錯
if (fileInput) {
    fileInput.addEventListener('change', renderImg);
    function renderImg() {
        if (this.files) {
            let reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            // console.log(reader);
            reader.addEventListener('load', function (e) {
                imgView.src = this.result;
            })
        }
    }
}