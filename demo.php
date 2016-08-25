<?php
include_once 'VhallReturnCheck.php';

$appKey = 'xxx';
$secretKey = 'xxxxxxx';

$checkSign = new VhallReturnCheck($appKey,$secretKey);
$return = $checkSign->check();

if ($return['code'] == 200) {
    var_dump($return);

    //file_put_contents('json.txt', json_encode($return));
    // list of return data
    // user_id fee note type
} else {
    echo $return['msg'];
}