<?php
include_once "./db/base.php";

?>

<header class="navbar navbar-dark bg-dark">
    <!-- Navbar content -->
    <div class="container-xxl">
      <a href="index.php">
        <h1 class="text-white">JUST VOTE!</h1>
      </a>
      <ul class="nav ms-auto">
          <?php
            if($do!='add_survey' && $do!='edit_survey'){
              ?>
            <!-- 下拉選單 -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              各類投票
            </a>
            <ul class="dropdown-menu">
              <?php
              $categories =all('projectvote_subject_category');
              foreach($categories as $category){
                ?>
                <li><a class="dropdown-item" href="?do=category_list&category=<?=$category['id']?>"><?=$category['category']?></a></li>
                <?php
              }
          }
          ?>
          </ul>
        </li>

        <?php
        if(!isset($_SESSION['user'])){
          ?>
          <li class="nav-item">
            <a class="nav-link" href="?do=reg">註冊</a>
          </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#login">登入</a>
        </li>
          <?php
        }else if($_SESSION['user']['level']==0){
          ?>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-user"></i>
          </a>
          <ul class="dropdown-menu text-center">
            <!-- 下拉選單輸出 -->
            <li class="border-bottom border-1 border-dark fw-bold pb-2 mb-2"><?=$_SESSION['user']['name']?></li>
            <li><a class="dropdown-item" href="?do=mysurvey">我的投票</a></li>
            <li><a class="dropdown-item" href="?do=mysurvey_log">投票紀錄</a></li>
            <li><a class="dropdown-item" href="?do=member_center">個人資料</a></li>
            <li><a class="dropdown-item" href="./api/logout.php">登出</a></li>
            <li><a class="dropdown-item" href="./admin.php">切換至後台</a></li>
            <!-- 下拉選單輸出 -->
          </ul>
        </li>
            <?php
        }else{
          ?>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-solid fa-user"></i>
          </a>
          <ul class="dropdown-menu text-center">
            <!-- 下拉選單輸出 -->
            <li class="border-bottom border-1 border-dark fw-bold pb-2 mb-2"><?=$_SESSION['user']['name']?></li>
            <li><a class="dropdown-item" href="?do=mysurvey">我的投票</a></li>
            <li><a class="dropdown-item" href="?do=mysurvey_log">投票紀錄</a></li>
            <li><a class="dropdown-item" href="?do=member_center">個人資料</a></li>
            <li><a class="dropdown-item" href="./api/logout.php">登出</a></li>
            <!-- 下拉選單輸出 -->
          </ul>
        </li>
            <?php
        }
        ?>
      </ul>
    </div>
      <!-- 登入modal -->
  <div class="modal fade" id="login" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 flex-grow-1 text-center" id="exampleModalLabel">會員登入</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="login-from" name="login-from">
      <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="col-form-label">帳號</label>
            <input type="text" class="form-control" id="name" name="account" required placeholder="請輸入帳號">
          </div>
        <div class="mb-3">
            <label for="password" class="col-form-label">密碼</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="請輸入密碼" autocomplete="off">
          </div>
        <div class="mb-3 d-flex">
            <div id="login_error_info" class="text-danger"></div>
            <a href="?do=reg" class="d-block ms-auto me-2 w-fit-content">註冊會員</a>
          </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-lg btn-secondary login-cancel" data-bs-dismiss="modal">取消</button>
        <input type="submit" class="btn btn-lg btn-main" value="登入"></input>
      </div>
    </form>
    </div>
  </div>
</div>
 <!-- 登入modal END-->

<script>
    const loginFrom = document.forms['login-from'];
    loginFrom.addEventListener('submit',function(e){
        e.preventDefault();
        let data = {};
        data.account = loginFrom.elements.account.value;
        data.password = loginFrom.elements.password.value;
        // console.log(data);
        login(data);
    })
    function login(data){
        axios.post("./api/login.php",data)
        .then(res=>{
            if(res.data=='login_success'){
                location.href="index.php";
            }else if(res.data=='admin_login_success'){
                location.href="admin.php";
            }
            else{
                loginError(res.data);
            }
        }).catch(error=>{
            console.log("錯誤"+error);
        })
    }

    //顯示錯誤訊息
    const loginErrorInfo = document.getElementById('login_error_info');
    function loginError(data){
      let str = '';
        switch(data){
          case "password_error":
              str= "密碼錯誤";
          break;
          case "account_not_found":
              str= "帳號不存在";
          break;
          case "login_fail":
              str= "請確認輸入資料是否正確";
          break;
          default:
              str="登入異常，請洽客服";
        }
        loginErrorInfo.textContent = str;
    }

    //關閉modal時清空帳密&錯誤訊息
    const loginCancel = document.querySelector('.login-cancel');
    loginCancel.addEventListener('click',function(e){
        this.closest('form').reset();
        loginErrorInfo.textContent='';
    })
</script>
  </header>