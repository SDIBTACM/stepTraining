<?php
namespace Domain;
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:07
 */
class Person
{
    private $userId;

    private $pojId;

    private $hdojId;

    private $sdutojId;

    private $codeforceId;

    private $bestcodeId;

    /**
     * Person constructor.
     * @param $userId
     * @param $pojId
     * @param $hdojId
     * @param $sdutojId
     * @param $codeforceId
     * @param $bestcodeId
     */
    public function __construct($userId, $pojId, $hdojId, $sdutojId, $codeforceId, $bestcodeId) {
        $this->userId = $userId;
        $this->pojId = $pojId;
        $this->hdojId = $hdojId;
        $this->sdutojId = $sdutojId;
        $this->codeforceId = $codeforceId;
        $this->bestcodeId = $bestcodeId;
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
    public function getPojId() {
        return $this->pojId;
    }

    /**
     * @return mixed
     */
    public function getHdojId() {
        return $this->hdojId;
    }

    /**
     * @return mixed
     */
    public function getSdutojId() {
        return $this->sdutojId;
    }

    /**
     * @return mixed
     */
    public function getCodeforceId() {
        return $this->codeforceId;
    }

    /**
     * @return mixed
     */
    public function getBestcodeId() {
        return $this->bestcodeId;
    }
}