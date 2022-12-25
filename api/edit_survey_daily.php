<?php
include_once "../db/base.php";

if(!isset($_POST['id'])){
    header("location:../admin.php?do=daily_survey_list&status=edit_survey_daily_fail");
}
//先上傳圖片,再將圖片編號存到subject
print_r($_FILES);
if(!empty($_FILES['file-input']['name'])){
    $nameList = explode(".",$_FILES['file-input']['name']);
    $type=array_pop($nameList);
    $fileName = date('YmdHis').".".$type;
    move_uploaded_file($_FILES['file-input']['tmp_name'],"../upload/$fileName");
    
    $fileSql = ['file_name'=>$fileName,
    'size'=>$_FILES['file-input']['size'],
    'type'=>$type
    ];
    print_r($fileSql);
    insert('projectvote_upload',$fileSql);
    $image=find('projectvote_upload',['file_name'=>$fileName]);
}

$surveyData = find('projectvote_subject_daily',$_POST['id']);
if(!isset($image)){
    $imageId=$surveyData['image'];
}else{
    $imageId = $image['id'];
}

//data wash
$title = replaceInput('sql',$_POST['title']);
$description = replaceInput('sql',$_POST['description']);
$startTime =date("Y-m-d",strtotime($_POST['start_time']));
$endTime =date("Y-m-d",strtotime($_POST['end_time'])). " 23:59:59";
//將資料更新到subject_daily table
update('projectvote_subject_daily',['title'=>$title,
'description'=>$description,
'type'=>$_POST['type'],
'start_time'=>$startTime,
'end_time'=>$endTime,
'image' => $imageId,
],$_POST['id']);






//修改舊選項
foreach($_POST['opt'] as $key=>$value){
    // echo "id=".$_POST['opt_id'][$key];
    // echo "opt=$value";
    update('projectvote_subject_daily_options',['opt'=>$value],$_POST['opt_id'][$key]);
}

//新增新選項
if(isset($_POST['opt_new'])){
    foreach($_POST['opt_new'] as $value){
        if($value){
            // echo "opt=$value";
            insert('projectvote_subject_daily_options',['subject_id'=>$_POST['id'],'opt'=>$value]);
        }
    }
}

header("location:../admin.php?do=daily_survey_list&status=edit_survey_daily_success");



?>

