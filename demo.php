<?php
include_once 'VhallReturnCheck.php';

// appKey secretKey 为vhall 系统提供, 使用前请先开通相关权限
// 地址 http://e.vhall.com/home/vhallapi/authinfo
$app_key = 'xxx';
$secret_key = 'xxxxxxx';

$checkSign = new VhallReturnCheck($app_key, $secret_key);

// 设定超时是长为120秒
// $checkSign->setTime(120);

// 校验sign
$return = $checkSign->check();

if ($return['code'] == 200) {
    var_dump($return);

    $user_id = $return['data']['user_id'];
    $fee = $return['data']['fee'];
    $type = $return['data']['type'];
    $note = $return['data']['note'];

    //file_put_contents('json.txt', json_encode($return));
    // list of return data
    // user_id fee note type
} else {
    echo $return['msg'];
}