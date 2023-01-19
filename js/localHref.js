// 由於include了header.php,無法在這頁用PHP的header()轉址
// 改用js轉
function checkIdAndHref(directUrl){
    const editPageParams = new URLSearchParams(window.location.search);
    if(!editPageParams.get('id')){
        location.href=`?do=${directUrl}&status=edit_error`;
    }
}