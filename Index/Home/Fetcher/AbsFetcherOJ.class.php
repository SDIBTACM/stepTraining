<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 19/03/2017 01:51
 */

namespace Home\Fetcher;


use Domain\Person;
use Home\Crawler\MCrawler;

abstract class AbsFetcherOJ implements IFetcherOJ
{
    /**
     * 获取某个学生某个oj上的解决题数
     * @param Person $person
     * @return mixed
     */
    public function getSolved(Person $person) {
        if (!empty($this->getSwitch())) {
            return $this->filterSolve(
                MCrawler::instance()->execute($this->getUserSolvePageUrl($person)),
                $person
            );
        } else {
            return -1;
        }
    }

    /**
     * 获取某个学生某个oj上某道题的结果
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    public function getProblemStatus(Person $person, $problemId) {
        if (!empty($this->getSwitch())) {
            return $this->filterProblemStatus(
                $this->getUserProblemStatusPage($person, $problemId),
                $person, $problemId
            );
        } else {
            return -1;
        }
    }

    abstract protected function getSwitch();

    /**
     * 获取某个学生解决题数页面的html信息
     * @param Person $person
     * @return mixed
     */
    abstract protected function getUserSolvePageUrl(Person $person);

    /**
     * 从html中过滤出解决的题数
     * @param $html
     * @param Person $person
     * @return mixed
     */
    abstract protected function filterSolve($html, Person $person);

    /**
     * 获取某个学生某题状态页面的html信息
     * [目前只有poj需要这么做, 如果其他oj也需要, 直接实现即可]
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    abstract protected function getUserProblemStatusPage(Person $person, $problemId);

    /**
     * 从html中过滤出题目的解决结果
     * @param $html
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    abstract protected function filterProblemStatus($html, Person $person, $problemId);
}