<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 18/03/2017 23:43
 */

namespace Home\Crawler;


class MCrawler extends AbsCrawler
{

    private static $_instance = null;

    private function __construct() {
    }

    private function __clone() {
    }

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    protected function setAgent() {
        $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36';
        curl_setopt($this->curl, CURLOPT_USERAGENT, $agent);
    }

    protected function setHeader() {
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($this->curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    }

    protected function setTimeout() {
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环}
    }

    protected function setReturnTransfer() {
        curl_setopt($this->curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true); // 使用自动跳转
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    }

    protected function setMethod() {
        curl_setopt($this->curl, CURLOPT_HTTPGET, 1); // 发送一个常规的Post请求
    }
}