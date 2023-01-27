<?php
include_once "./db/base.php";

$startTime = date("Y-m-d", strtotime('now'));
// $endTime = date("Y-m-d", strtotime("+1 months"));
?>
<div class="d-flex">
<div class="nav-space"></div>
<div class="admin container-xxl mt-5 pb-5">
    <form action="./api/add_survey_daily.php" method="post" enctype="multipart/form-data" class="add-survey-form mx-auto" id="add-survey-form">
    <a href="?do=admin_main" class="fw-bold d-block mb-1 back-btn"><i class="fa-solid fa-chevron-left mr-1"></i>管理中心</a>
    <div class="section-tag tag-lg mb-3">發起每日投票</div>
    <div class="tool d-flex align-items-center ">
    <div class="option-type">
        <div class="radio-box d-flex">
            <input class="form-check-input fs-5" type="radio" name="type" id="radio" value=0 checked>
            <label class="form-check-label fs-5 fw-bold me-2" for="radio">單選</label>
            <input class="form-check-input fs-5" type="radio" name="type" id="checkbox" value=1>
            <label class="form-check-label fs-5 fw-bold" for="checkbox">複選</label>
        </div>
        <div class="date-selector mt-3">
            <div class="time-error-info text-danger"></div>
            <label class="fs-5 fw-bold" for="start_time">開始時間<input class="fs-5 mx-2" type="date" name="start_time" id="start_time" value="<?=$startTime?>"></label>
            <label class="fs-5 fw-bold" for="end_time">結束時間<input class="fs-5 mx-2" type="date" name="end_time" id="end_time" value="<?=$startTime?>"></label>
        </div>
    </div>
        <a href="#" class="btn btn-main float-right ms-auto add-option-btn align-self-start"><i class="fa-sharp fa-solid fa-plus"></i></a>
    </div>
    <div class="uploader my-3">
    <div class="fs-6">上傳圖片(僅支援JPG,PNG,GIF)</div>
    <input class="file-input form-control" type="file" name="file-input" accept="image/gif, image/jpeg, image/png">
    <img src="" alt="" id="img-view" width="200px">
    </div>
<div class="mb-3 mt-1">
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
</div>
<script>
    //新增選項上限
    //因為按鈕有兩層,所以設定的數量為按鈕n*2
    const optionLimit=2; 
</script>
<script src="./js/addPage.js"></script>

