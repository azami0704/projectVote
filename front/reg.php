<?php

include_once "./db/base.php";
$status = '';
if(isset($_GET['status'])){
    switch($_GET['status']){
        case 'account_exist':
            $status = "帳號已存在";
        break;
        default:
            $status = '';
    }
}
?>

<div class="container-xxl mt-5 pb-5">
    <form action="./api/reg_api.php" method="post" class="reg-form mx-auto" id="reg-form">
        <h2 class="section-tag">註冊會員</h2>
        <div class="input-group my-3">
            <span class="input-group-text">帳號*</span>
            <input type="email" class="form-control" name="account" required placeholder="完整email" autocomplete="off">
            <span class="input-group-text reg-error-info text-danger bg-white"><?=$status?></span>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">密碼*</span>
            <input type="password" class="form-control" name="password" maxlength="20" required placeholder="含一個英文大寫6碼以上英數字" autocomplete="off">
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">密碼確認*</span>
            <input type="password" class="form-control" name="passwordConfirm" required placeholder="再次輸入密碼" autocomplete="off">
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">姓名*</span>
            <input type="text" class="form-control" name="name" required placeholder="暱稱" autocomplete="off">
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">電話</span>
            <input type="num" class="form-control" name="tel" placeholder="0212345678" autocomplete="off">
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <footer class="text-center">
            <input type="reset" value="重填" class="btn btn-secondary btn-lg">
            <input type="submit" value="註冊" class="btn btn-main btn-lg">
        </footer>
    </form>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script>
    const constraints = {
        account:{
            presence: true,
            email: {
                message:"非email格式"
            }
        },
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
        },
        name:{
            presence: true,
        },
        tel:{
           length:{
            minimum: 8,
            message:"^請輸入8碼以上電話號碼"
           } 
        }
    }

    const regForm = document.getElementById('reg-form');
//驗證通過再傳到api若未通過印出錯誤
    regForm.addEventListener('submit',function(e){
        e.preventDefault();
        const error = validate(regForm,constraints);
        // console.log(error);
        if(!error){
            regForm.submit();
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