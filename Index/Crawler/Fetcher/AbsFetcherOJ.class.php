<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 19/03/2017 01:51
 */

namespace Crawler\Fetcher;


use Crawler\Common\Person;
use Crawler\Crawler\MCrawler;

abstract class AbsFetcherOJ implements IFetcherOJ
{
    /**
     * 获取某个学生某个oj上的解决题数
     * @param Person $person
     * @return mixed
     */
    public function getSolved(Person $person) {
        if (empty($person->getAccountId())) {
            return 0;
        }
        $url = $this->getUserSolvePageUrl($person);
        $pattern = $this->filterSolvePattern($person);
        if (is_null($url) || is_null($pattern)) {
            return 0;
        }

        $html = MCrawler::instance()->execute($url);
        preg_match($pattern, $html, $solved);
        return isset($solved[1]) && !empty($solved[1]) ? intval($solved[1]) : 0;
    }

    /**
     * 获取某个学生某个oj上某道题的结果
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    public function getProblemStatus(Person $person, $problemId) {
        if (empty($person->getAccountId()) || empty($problemId)) {
            return false;
        }
        $url = $this->getUserProblemStatusPageUrl($person, $problemId);
        $pattern = $this->filterProblemStatusPattern($person, $problemId);
        if (is_null($url) || is_null($pattern)) {
            return false;
        }

        $html = MCrawler::instance()->execute($url);
        $flag = preg_match($pattern, $html, $status);
        return $flag ? date('Y-m-d', strtotime($status[1])) : false;
    }

    /**
     * 获取某个学生解决题数页面的html信息
     * @param Person $person
     * @return mixed
     */
    abstract protected function getUserSolvePageUrl(Person $person);

    /**
     * 从html中过滤出解决的题数
     * @param Person $person
     * @return mixed
     */
    abstract protected function filterSolvePattern(Person $person);

    /**
     * 获取某个学生某题状态页面的html信息
     * [目前只有poj需要这么做, 如果其他oj也需要, 直接实现即可]
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    abstract protected function getUserProblemStatusPageUrl(Person $person, $problemId);

    /**
     * 从html中过滤出题目的解决结果
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    abstract protected function filterProblemStatusPattern(Person $person, $problemId);
}