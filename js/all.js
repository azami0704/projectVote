const params = new URLSearchParams(window.location.search);
const pathName = window.location.pathname; 
const animationTime = 1200; //毫秒
//status alert
let getStatus = params.get('status');
let getDo =  params.get('do')
if (getStatus) {
    switch (getStatus) {
        case "add_survey_success":
        case "add_survey_daily_success":
            sweetAlertSuccess("新增成功!");
            clearPageHistory(`?do=${getDo}`);
        break;
        case "add_survey_fail":
        case "add_survey_daily_fail":
            sweetAlertFail("新增失敗",'請確認資料是否正確或稍後再試');
            clearPageHistory(`?do=${getDo}`);
        break;
        case "edit_survey_fail":
        case "edit_survey_daily_fail":
            sweetAlertFail("編輯失敗",'請確認資料是否正確或稍後再試');
            clearPageHistory(`?do=${getDo}`);
        break;
        case "del_option_fail":
        case "del_member_fail":
        case "del_option_daily_fail":
            sweetAlertFail("刪除失敗",'請確認資料是否正確或稍後再試');
            clearPageHistory(`?do=${getDo}&id=${params.get('id')}`);
        break;
        case "del_option_success":
        case "del_member_success":
        case "del_option_daily_success":
            sweetAlertSuccess("刪除成功!");
            clearPageHistory(`?do=${getDo}&id=${params.get('id')}`);
        break;
        case "edit_survey_success":
        case "edit_survey_daily_success":
            sweetAlertSuccess("編輯成功!");
            clearPageHistory(`?do=${getDo}`);
        break;
        case "change_password_fail":
            sweetAlertFail("修改失敗",'請洽客服稍後再試');
            clearPageHistory(`?do=edit_password&id=${params.get('id')}`);
        break;
        case "edit_member_success":
            sweetAlertSuccess("更新成功!");
            clearPageHistory(`?do=member_center`);
        break;
        case "edit_member_fail":
            sweetAlertFail("更新失敗",'請確認資料是否正確或稍後再試');
            clearPageHistory(`?do=member_center`);
        break;
        case "vote_survey_error":
            sweetAlertFail("資料錯誤",'請確認操作是否正確');
            clearPageHistory(`?do=index.php`);
        break;
    }
};

let getAction = params.get('jsact');
let getId=params.get('id');

//同時確認&執行的alert
if(getAction){
    switch(getAction){
        case "del_survey":
            sweetAlertWarning("刪除","刪除後將無法復原");
        break;    
        case "del_survey_daily":
            sweetAlertWarning("刪除","刪除後將無法復原","daily");
        break;    
    }
}


function sweetAlertSuccess(str) {
    Swal.fire({
        icon: 'success',
        iconColor:'var(--main)',
        title: str,
        showConfirmButton: false,
        timer: animationTime,
    });
}
function sweetAlertFail(str,text) {
    Swal.fire({
        icon: 'error',
        text: text,
        title: str,
        showConfirmButton: true,
        confirmButtonColor: 'var(--main)'
    });
}


//後台與前台刪除投票後回的URL不同
//先將path name拆開方便後面搜尋
let pathNameArr = (pathName.split(/\/|\./));
function sweetAlertWarning(str,text,...type) {
    Swal.fire({
        title: `確認${str}?`,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'var(--main)',
        cancelButtonColor: 'var(--gray-heavy)',
        confirmButtonText: `確認${str}`,
    }).then((result) => {
        if (result.isConfirmed) {
            if(type.length>0){
                //第三個參數即為daily survey
                delSurvey(getId,'daily');
                clearPageHistory("?do=daily_survey_list");
            }else{
                delSurvey(getId,'');
                //一般投票刪除後要區分回到前台還是後台
                if(pathNameArr.indexOf('admin')==-1){
                    clearPageHistory("?do=mysurvey");
                }else{
                    clearPageHistory("?do=admin_survey");
                }
            }
        }
    })
}

//跳完錯誤訊息後清除頁面紀錄避免按上一頁再次跳alert
function clearPageHistory($page){
    setTimeout(()=>{
        window.history.go(-window.history.length);
        window.location.replace($page);
    },animationTime);
}

//呼叫del_survey API
//成功結果有綁sweetAlert,若要更動記得移除
function delSurvey(id,table){
    let data={};
    data["id"] = id;
    data["table"] = table;
    axios.post("./api/del_survey.php",data)
    .then(res=>{
        // console.log(res);
        if(res.data=="delete_success"){
            sweetAlertSuccess("刪除成功!");
        }else{
            sweetAlertFail('刪除失敗','請聯絡客服或稍後再試')
        }
    }).catch(error=>{
        console.log(error);
    })
}


const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))