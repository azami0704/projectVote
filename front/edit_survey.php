<?php
include_once "./db/base.php";

$startTime = date("Y-m-d", strtotime('now'));
$endTime = date("Y-m-d", strtotime("+1 months"));
?>
<div class="container-xxl pb-5 mt-3">
    <form action="./api/edit_survey.php" method="post" class="edit-survey-form mx-auto" id="add-survey-form">
    <a href="?do=mysurvey" class="fw-bold d-block mb-1 back-btn"><i class="fa-solid fa-chevron-left mr-1"></i>回我的投票</a>
    <div class="section-tag tag-lg mb-3">編輯投票</div>
    <div class="tool d-flex align-items-center ">
    <div class="option-type">
        <div class="radio-box d-flex">
            <?php
            $subjectDetail = find('projectvote_subject',$_GET['id']);
            $options = all('projectvote_subject_options',['subject_id'=>$_GET['id']]);
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
            switch($subjectDetail['private']){
                case 0:
                    $public='checked';
                    $privateLink='';
                    $privateMember='';
                break;
                case 1:
                    $public='';
                    $privateLink='checked';
                    $privateMember='';
                break;
                case 2:
                    $public='';
                    $privateLink='';
                    $privateMember='checked';
                break;   
            }
            ?>
            <input class="form-check-input fs-5" type="radio" name="type" id="radio" value=0 <?=$radioChecked?>>
            <label class="form-check-label fs-5 fw-bold me-2" for="radio">單選</label>
            <input class="form-check-input fs-5" type="radio" name="type" id="checkbox" value=1 <?=$checkboxChecked?>>
            <label class="form-check-label fs-5 fw-bold" for="checkbox">複選</label>
            <div class="category ms-auto">
                <label class="form-check-label fs-5 fw-bold">分類</label>
                <!--category select -->
                <select name="category_id">
                <?php
                $categorys =all('projectvote_subject_category');
                foreach($categorys as $category){
                    if($category['id']==$subjectDetail['category_id']){
                        $select = 'selected';
                    }else{
                        $select='';
                    }
                ?>
                <option value="<?=$category['id']?>" <?=$select?>><?=$category['category']?></option>
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
        <?php
        if($subjectDetail['private']==2){
            $members = all('projectvote_subject_users',['subject_id'=>$subjectDetail['id'],'auth'=>1]);
            if(empty($members)){
                $public='';
                $privateLink='checked';
                $privateMember='';
            }
        }
        ?>
        <label class="fs-5 fw-bold me-2" for="public"><input type="radio" id="public" class="form-check-input fs-5" name="private" value=0 <?=$public?>>公開</label>
        <label class="fs-5 fw-bold me-2" for="private"><input type="radio" id="private" class="form-check-input fs-5" name="private" value=1 <?=$privateLink?>>知道連結的所有會員</label>
        <label class="fs-5 fw-bold me-2" for="all_member"><input type="radio" name="private" id="all_member" class="form-check-input fs-5" value=2 <?=$privateMember?>>指定會員</label><a href="#" class="member-add-btn fs-5"><i class="fa-regular fa-square-plus"></i></a>
        </div>
    </div>
        <a href="#" class="btn btn-main float-right ms-auto add-option-btn align-self-start"><i class="fa-sharp fa-solid fa-plus"></i></a>
    </div>
    <div class="member-input d-flex flex-wrap">
        <?php
        if($subjectDetail['private']==2){
        if(count($members)%2){
            $members[]=['account'=>""];
        }
        foreach($members as $key => $member){
            if($member['account']==''){
                $memberCheck = 'member_new[]';
                $memberIdCheck = '';
                $memberIdValueCheck = '';
            }else{
                $memberCheck = 'member[]';
                $memberIdCheck = 'member_id[]';
                $memberIdValueCheck = $member['id'];
            }
            if($key%2==0){
                echo "<div class='input-group mb-1'>";
                echo "<label class='w-50 position-relative'><a href='./api/del_member.php?subject_id={$subjectDetail['id']}&account={$member['account']}' class='position-absolute end-0 z-index-1 del-member-btn'><i class='fa-sharp fa-solid fa-xmark del-member-btn'></i></a><input type='hidden' name='member_id[]' value='{$member['id']}'><input type='email' name='member[]' placeholder='請輸入會員帳號' value='{$member['account']}' class='form-control'></label>";
            }else{
                echo "<label class='w-50 position-relative'><a href='./api/del_member.php?subject_id={$subjectDetail['id']}&account={$member['account']}' class='position-absolute end-0 z-index-1 del-member-btn'><i class='fa-sharp fa-solid fa-xmark del-member-btn'></i></a><input type='hidden' name='$memberIdCheck' value='$memberIdValueCheck'><input type='email' name='$memberCheck' placeholder='請輸入會員帳號' value='{$member['account']}' class='form-control'></label>";
                echo "</div>";
            }
        }
    }
        ?>
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
        $deleteBtn = "<a href='./api/del_option.php?id={$opt['id']}&subject_id={$opt['subject_id']}' class='btn btn-main float-right ms-auto del-exist-option-btn'><i class='fa-solid fa-trash-can del-exist-option-btn'></i></a><div class='clearfix'></div>";
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
            <a href="?do=edit_survey&id=<?=$_GET['id']?>" class="btn btn-secondary btn-lg fw-bold">重置</a>
            <input type="submit" value="確認" class="btn btn-main btn-lg fw-bold">
        </footer>
    </form>
</div>

<script src="./js/localHref.js"></script>
<script>
    checkIdAndHref('mysurvey');
    //新增選項上限
    //因為按鈕有兩層,所以設定的數量為按鈕n*2
    const optionLimit=20; 
</script>
<script src="./js/addPage.js"></script>