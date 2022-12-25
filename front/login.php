<?php

include_once "./db/base.php";

if(isset($_GET['status'])){
    switch($_GET['status']){
        case "password_error";
        $status = "密碼錯誤";
        break;
        case "account_not_found";
        $status = "帳號不存在";
        break;
        case "password_error";
        $status = "帳號資料異常";
        break;
        case "reg_success";
        $status = "註冊成功，請重新登入";
        break;
        case "change_password_success";
        $status = "修改密碼成功，請重新登入";
        break;
        default;
        $status = "登入異常，請洽客服或稍晚再試";
    }
}else{
    $status='';
}
?>

<div class="container-xxl mt-5">
    <form action="./api/login.php" method="post" class="reg-form mx-auto" id="reg-form">
        <h2 class="section-tag">會員登入</h2>
        <div class="input-group my-3">
            <span class="input-group-text">帳號</span>
            <input type="text" class="form-control" name="account" required placeholder="email信箱">
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">密碼</span>
            <input type="password" class="form-control" name="password" maxlength="20" required  autocomplete="off">
            <span class="input-group-text reg-error-info text-danger bg-white"></span>
        </div>
        <div class="mb-3 d-flex">
            <div id="login_error_info" class="text-danger"><?=$status?></div>
            <a href="?do=reg" class="d-block ms-auto me-2 w-fit-content">註冊會員</a>
        </div>
        <footer class="text-center">
            <input type="reset" value="重填" class="btn btn-secondary btn-lg">
            <input type="submit" value="登入" class="btn btn-main btn-lg">
        </footer>
    </form>
</div>