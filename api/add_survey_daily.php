<?php
include_once "../db/base.php";

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// echo "<pre>";
// print_r($_FILES['file-input']);
// echo "</pre>";


//先上傳圖片,再將圖片編號存到subject
if(!empty($_FILES['file-input']['name'])){
    $nameList = explode(".",$_FILES['file-input']['name']);
    $type=array_pop($nameList);
    $fileName = date('YmdHis').".".$type;
    move_uploaded_file($_FILES['file-input']['tmp_name'],"../upload/$fileName");
    
    $fileSql = ['file_name'=>$fileName,
    'size'=>$_FILES['file-input']['size'],
    'type'=>$type
    ];
    // print_r($fileSql);
    insert('projectvote_upload',$fileSql);
    
    $image=find('projectvote_upload',['file_name'=>$fileName]);
}
if(!isset($image)){
    $imageId=1;
}else{
    $imageId = $image['id'];
}
//subject新增資料處理
//字串要處理單引號,雙引號,斜線問題
$title = replaceInput('sql',$_POST['title']);
$description = replaceInput('sql',$_POST['description']);
$endTime = $_POST['end_time'] . " 23:59:59";
$checkNum = randomStr(8); //原設定10碼發現可能會超過數字上限,改8碼
$sql = ['title' => $title,
    'type' => $_POST['type'],
    'description' => $description,
    'start_time' => $_POST['start_time'],
    'end_time' => $endTime,
    'image' => $imageId,
    'check_num' => $checkNum,
];

// print_r($sql);
//新增投票主題到subject
$res_subject = insert('projectvote_subject_daily', $sql);


if ($res_subject) {
    //新增成功先撈subject_id回來,用title跟checkNum指定
    $subjectId = find('projectvote_subject_daily', ['title' => $title, 'check_num' => $checkNum])['id'];
//選項處理options,要存subject_id
    foreach ($_POST['opt'] as $opt) {
        //可能有空欄位,判斷有值再執行
        if ($opt) {
            $option = replaceInput('sql',$opt);
            $sqlOption = ['subject_id' => $subjectId, 'opt' => $option];
            insert('projectvote_subject_daily_options', $sqlOption);
        }
    }
    //處理完成回每日投票
    header("location:../admin.php?do=daily_survey_list&status=add_survey_daily_success");
} else {
    //失敗導回每日投票
    header("location:../admin.php?do=daily_survey_list&status=add_survey_daily_fail");
}
