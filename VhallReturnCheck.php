<?php

/**
 * Class VhallReturnCheck
 * auth : vhall team
 * time : 2016-8-25
 */
class VhallReturnCheck
{
    private $appKey;
    private $secretKey;
    private $time = 60;

    public function __construct($appKey, $secretKey)
    {
        $this->appKey = $appKey;
        $this->secretKey = $secretKey;
    }

    // 设定超时
    public function setTime($time)
    {
        $this->time = $time;
    }

    // 数据校验
    public function check()
    {
        try {
            $this->checkTime();
            $this->checkSign();

            $userId = $_GET['user_id'] ? : '';
            $fee = $_GET['fee'] ? : '';
            $note = $_GET['note'] ? : '';
            $type = $_GET['type'] ? : '';

            $returnData = [
                'user_id' => $userId,
                'fee' => $fee,
                'note' => $note,
                'type' => $type
            ];

            return ['code'=>200,'data'=>$returnData];
        } catch (Exception $e) {
            return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
        }
    }

    // 超时校验
    private function checkTime()
    {
        $localTime = time();

        if (!isset($_GET['time'])) {
            throw new Exception('访问时间不能为空', 400);
        }

        $requestTime = $_GET['time'];

        if (!$requestTime) {
            throw new Exception('访问时间超时', 400);
        }

        if ($localTime - $this->time > $requestTime || $localTime + $this->time < $requestTime) {
            throw new Exception('访问时间超时', 400);
        }
    }

    // 签名校验
    private function checkSign()
    {
        if (!isset($_GET['sign'])) {
            throw new Exception('签名数据为空', 400);
        }

        $requestSign = $_GET['sign'];
        $localSign = $this->createSign();

        if ($requestSign == $localSign) {
            return true;
        }

        return false;
    }

    // 生成签名
    private function createSign()
    {
        unset($_GET['sign']);

        ksort($_GET);
        $str = '';

        foreach ($_GET as $k => $v) {
            $str .= $k.$v;
        }

        $str = $this->appKey.$str.$this->secretKey;

        unset($_GET['time']);

        return md5($str);
    }
}