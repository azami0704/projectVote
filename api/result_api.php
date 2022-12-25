<?php
include_once "../db/base.php";

if(isset($_GET['id'])){
    if(isset($_GET['daily'])){
        $options = all('projectvote_subject_daily_options',['subject_id'=>$_GET['id']]);
        $res=[];
        foreach($options as $option){
            $res["{$option['opt']}"]=$option['vote'];
        }
        $response = json_encode($res);
        echo $response;
    }else{
        $options = all('projectvote_subject_options',['subject_id'=>$_GET['id']]);
        $res=[];
        foreach($options as $option){
            $res["{$option['opt']}"]=$option['vote'];
        }
        $response = json_encode($res);
        echo $response;
    }
}else{
    echo 'id_not_found';
}

?>