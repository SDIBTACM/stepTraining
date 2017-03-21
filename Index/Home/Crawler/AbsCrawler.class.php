<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 18/03/2017 23:45
 */

namespace Home\Crawler;


abstract class AbsCrawler implements ICrawler
{

    protected $curl = null;

    private $result = "";

    public function execute($url) {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL, $url); // 要访问的地址
        $this->setSetting();
        $this->result = curl_exec($this->curl);
        if (curl_errno($this->curl)) {
            $this->result = "";
        }
        curl_close($this->curl);
        return $this->result;
    }

    abstract protected function setAgent();

    abstract protected function setHeader();

    abstract protected function setTimeout();

    abstract protected function setReturnTransfer();

    abstract protected function setMethod();

    private function setSetting() {
        $this->setAgent();
        $this->setHeader();
        $this->setTimeout();
        $this->setReturnTransfer();
        $this->setMethod();
    }
}