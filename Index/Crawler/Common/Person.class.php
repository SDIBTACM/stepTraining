<?php
namespace Crawler\Common;
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:07
 */
class Person
{
    private $userId;

    private $accountId;


    /**
     * Person constructor.
     * @param $userId
     * @param $pojId
     * @param $hdojId
     * @param $sdutojId
     * @param $codeforceId
     * @param $bestcodeId
     */
    public function __construct($userId, $accountId) {
        $this->userId = $userId;
        $this->accountId = $accountId;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getAccountId() {
        return $this->accountId;
    }
}