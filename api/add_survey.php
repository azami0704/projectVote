<?php
include_once "../db/base.php";

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
$directUrl = "index";
$page = "mysurvey";
if(isset($_POST['admin'])){
    $directUrl = "admin";
    $page = "admin_survey";
}
//subject新增資料處理
//字串要處理單引號,雙引號,斜線問題
$title = replaceInput('sql',$_POST['title']);
$description = replaceInput('sql',$_POST['description']);
$endTime = $_POST['end_time'] . " 23:59:59";
$checkNum = randomStr(8); //原設定10碼發現可能會超過數字上限,改8碼
$sql = ['title' => $title,
    'type' => $_POST['type'],
    'category_id' => $_POST['category_id'],
    'description' => $description,
    'start_time' => $_POST['start_time'],
    'end_time' => $endTime,
    'private' => $_POST['private'],
    'check_num' => $checkNum,
];

// print_r($sql);
//新增投票主題到subject
$res_subject = insert('projectvote_subject', $sql);
if ($res_subject) {
    //新增成功先撈subject_id回來,用title跟checkNum指定
    $subjectId = find('projectvote_subject', ['title' => $title, 'check_num' => $checkNum])['id'];
    //更新subject_user表單
    $sqlStudentUser = ['subject_id' => $subjectId, 'account' => $_SESSION['user']['account'], 'auth' => 0]; //auth=0為owner
    insert('projectvote_subject_users', $sqlStudentUser);

//私人投票處理,要存subject_id
    if ($_POST['private'] == 2) {
        foreach ($_POST['member'] as $member) {
            //可能有空欄位,判斷有值再執行
            if ($member) {
                $account = replaceInput('sql',$member);
                $sqlMember = ['subject_id' => $subjectId, 'account' => $account, 'auth' => 1]; //auth=1為member
                insert('projectvote_subject_users', $sqlMember);
            }
        }
    }
    ;
//選項處理options,要存subject_id
    foreach ($_POST['opt'] as $opt) {
        //可能有空欄位,判斷有值再執行
        if ($opt) {
            $option = replaceInput('sql',$opt);
            $sqlOption = ['subject_id' => $subjectId, 'opt' => $option];
            insert('projectvote_subject_options', $sqlOption);
        }
    }
    //處理完成回我的投票
    header("location:../$directUrl.php?do=$page&status=add_survey_success");
} else {
    //失敗導回新增投票
    header("location:../$directUrl.php?do=add_survey&status=add_survey_fail");
}
