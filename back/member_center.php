<?php
include_once "./db/base.php";

$memberDetail = find('projectvote_users',$_SESSION['user']['id']);
$tel = $memberDetail['tel']==0?'':$memberDetail['tel'];
$password = str_repeat("*",strlen($memberDetail['password']));
$emailError='';
if(isset($_GET['status'])){
    switch($_GET['status']){
        case 'email_used':
            $emailError = '此信箱已有人使用';
         break;   
    }
}
?>
<div class="d-flex">
<div class="nav-space"></div>
<div class="admin container-xxl mt-5 pb-5">
    <form action="./api/edit_member.php" method="post" class="reg-form mx-auto" id="reg-form">
        <input type="hidden" name="admin" value=0>
        <input type="hidden" name="id" value='<?=$memberDetail['id']?>'>
        <h2 class="section-tag">會員資料</h2>
        <div class="input-group my-3">
            <span class="input-group-text">帳號</span>
            <input class="form-control readonly" name="account" value="<?=$memberDetail['account']?>" readonly>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">密碼*</span>
            <input type="password" class="form-control" value='<?=$password?>'>
            <a href="?do=edit_password" class="input-group-text reg-error-info bg-white"><i class="fa-solid fa-pen"></i>修改密碼</a>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">姓名*</span>
            <input type="text" class="form-control" name="name" required placeholder="暱稱" autocomplete="off" value='<?=$memberDetail['name']?>'>
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <div class="input-group my-3">
            <span class="input-group-text">聯絡信箱</span>
            <input type="email" class="form-control" name="email" placeholder="完整email" value="<?=$memberDetail['email']?>" autocomplete="off" required>
            <span class="input-group-text reg-error-info text-danger bg-white"><?=$emailError?></span>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">電話</span>
            <input type="num" class="form-control" name="tel" placeholder="請輸入數字電話號碼" autocomplete="off" value='<?=$tel?>'>
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <footer class="text-center">
            <input type="reset" value="重填" class="btn btn-secondary btn-lg">
            <input type="submit" value="修改" class="btn btn-main btn-lg">
        </footer>
    </form>
</div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script>
    const constraints = {
        email:{
            email: {
                message:"非email格式"
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