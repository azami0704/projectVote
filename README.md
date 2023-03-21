### [網站展示URL](https://azmai.tw/)

### 使用技術
後端
PHP
MySQL

前端
HTML
CSS
JavaScript
AJAX

套件
Axios
C3.js

### 功能
front <br>
<ul>
<li>登入</li>
<li>註冊</li>
<li>分類投票清單</li>
<li>每日投票</li>
<li>近期每日投票</li>
<li>最新投票(三筆)</li>
<li>熱門投票(三筆)</li>
<li>投票</li>
<li>投票結果</li>
</ul>
會員功能
<ul>
    <li>新增投票</li>
    <li>編輯投票</li>
    <li>刪除投票</li>
    <li>修改會員資料</li>
    <li>查詢密碼</li>
</ul>
admin<br>
<ul>
    <li>DashBoard</li>
    <li>每日投票管理</li>
    <li>全站投票管理</li>
</ul>



### 資料表
projectVote_subject
|column|設定|預設值|
|--------|--------|--------|
id|int10|N/A|
title|varchart64|N/A|
description|text|N/A|
type|tinyint|0|
vote|int10|0|
private|tinyint|0|
category_id|int10|N/A|
start_time|timestamp|currenttime|
end_time|timestamp|N/A|
created_at|timestamp|currenttime|
update_at|timestamp|N/A|
check_num|int10|N/A|

projectVote_subject_options
|column|設定|預設值|
|--------|--------|--------|
id|int10|N/A|
subject_id|int10|N/A|
opt|varchart64|N/A|
vote|int10|0|
created_at|timestamp|currenttime|
update_at|timestamp|N/A|

projectVote_subject_daily
|column|設定|預設值|
|--------|--------|--------|
id|int10|N/A|
title|varchart64|N/A|
description|text|N/A|
type|tinyint|0|
vote|int10|0|
image|int10|NULL|
category_id|int10|N/A|
start_time|timestamp|N/A|
end_time|timestamp|N/A|
created_at|timestamp|currenttime|
update_at|timestamp|N/A|
check_num|int10|N/A|

projectVote_subject_daily_options
|column|設定|預設值|
|--------|--------|--------|
id|int10|N/A|
subject_id|int10|N/A|
opt|varchart64|N/A|
vote|int10|0|
created_at|timestamp|currenttime|
update_at|timestamp|N/A|
projectVote_subject_users
id|int10|N/A|
subject_id|int10|N/A|
account|varchart128|N/A|
auth|int1|N/A|

projectVote_users
|column|設定|預設值|
|--------|--------|--------|
id|int10|N/A|
account|varchart64|N/A|
password|varchart64|N/A|
name|varchart64|N/A|
email|varchart128|N/A|
tel|varchart10|N/A|
level|tinyint|N/A|
last_login|timestamp|NULL|
created_at|timestamp|currenttime|
update_at|timestamp|N/A|

projectVote_log
|column|設定|預設值|
|--------|--------|--------|
id|int10|N/A|
user_id|int10|N/A|
subject_id|int10|N/A|
daily_subject_id|int10|N/A|
ip|varchart16|N/A|
option_id|varchart128|N/A|
created_at|timestamp|currenttime|

projectVote_login
|column|設定|預設值|
|--------|--------|--------|
id|int10|N/A|
user_id|int10|N/A|
login_time|timestamp|currenttime|
projectVote_subject_category
id|int10|N/A|
category|varchart32|N/A|

projectVote_upload
|column|設定|預設值|
|--------|--------|--------|
id|int10|N/A|
file_name|varchrt64|N/A|
size|int10|N/A|
type|varchrt64|N/A|
description|text|N/A|
upload_time|timestamp|N/A|
