<?php
include_once "./db/base.php";

$memberDetail = find('projectvote_users',$_SESSION['user']['id']);

?>
<div class="container-xxl mt-4 pb-4">
    <form action="./api/edit_password.php" method="post" class="reg-form mx-auto" id="reg-form">
    <input type="hidden" name="admin">
    <a href="?do=member_center" class="fw-bold d-block mb-1 back-btn"><i class="fa-solid fa-chevron-left mr-1"></i>回個人資料</a>
        <h2 class="section-tag">修改密碼</h2>
        <div class="input-group my-3">
            <span class="input-group-text">舊密碼*</span>
            <input type="password" class="form-control" name="old-password" maxlength="20" placeholder="含一個英文大寫6碼以上英數字" autocomplete="off" id="old-password" required>
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">密碼*</span>
            <input type="password" class="form-control" name="password" maxlength="20" placeholder="含一個英文大寫6碼以上英數字" autocomplete="off" required>
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">密碼確認*</span>
            <input type="password" class="form-control" name="passwordConfirm" required placeholder="再次輸入密碼" autocomplete="off">
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <footer class="text-center">
            <input type="reset" value="重填" class="btn btn-secondary btn-lg">
            <input type="submit" value="修改" class="btn btn-main btn-lg">
        </footer>
    </form>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script>
    const constraints = {
        password:{
            presence: true,
            format: {
            pattern: "[a-zA-Z0-9]*[A-Z]+[a-zA-Z0-9]*",
            message: "^至少要有一個大寫字母"
        },
        length:{
            minimum: 6,
            message:"^密碼過短"
            }
        },
        passwordConfirm:{
            equality: {
                attribute:"password",
                message: "^密碼不符"
            }
        }
    }

    const regForm = document.getElementById('reg-form');

//驗證舊密碼
function confirmPassword(){
    const oldPassword = document.getElementById('old-password');
    axios.get(`./api/edit_password.php?id=<?=$memberDetail['id']?>&check=${oldPassword.value}`)
    .then(res=>{
        if(res.data=='check_password_success'){
            regForm.submit();
        }else{
            oldPassword.nextElementSibling.textContent='密碼不符'
        }
        console.log(res);
    }).catch(error=>{
        console.log("error"+error);
    })
}
//驗證通過再傳到api若未通過印出錯誤
    regForm.addEventListener('submit',function(e){
        e.preventDefault();
        const error = validate(regForm,constraints);
        // console.log(error);
        if(!error){
            confirmPassword();
        }else{
            const errorTxt = document.querySelectorAll('.reg-form .form-control');
            errorTxt.forEach(item=>{
                item.nextElementSibling.textContent='';
                if(error[item.name]){
                    item.nextElementSibling.textContent=error[item.name];
                }
            })
        }
    })

    //reset時清除錯誤訊息
    regForm.addEventListener('reset',function(e){
        const regErrorInfo = document.querySelectorAll('.reg-error-info');
        regErrorInfo.forEach(item=>item.textContent='');
    })
</script>